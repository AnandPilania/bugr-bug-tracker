import {ErrorResponseType, SuccessResponseType, UseApiType} from "../../Api/useApi";
import {ProjectType} from "../../Project/repository/ProjectRepository";
import {StatusType} from "../../Status/repository/StatusRepository";
import {UseFirestoreType} from "../../Api/useFirebase";
import {UserType} from "../../Auth/AuthContext";
import Url from "../../Url";

export type BugType = {
    id: number
    title: string,
    description: string,
    status: StatusType,
    project: ProjectType,
    assignee: UserType|null
}

const BugRepository = (api: UseApiType, firestore: UseFirestoreType) => {

    const get = (id: number, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return api.get(
            Url.bugs.view(id),
            {},
            (response: SuccessResponseType) => onSuccess(response.data),
            (error: ErrorResponseType) => onError(error.data)
        )
    }

    const getByProject = (projectId: number, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return api.get(
            Url.bugs.byProject(projectId),
            {},
            (response: SuccessResponseType) => {
                firestore.getByProject(
                    projectId,
                    'bugs',
                    bugs => {
                        response.data.push(...bugs)
                        onSuccess(response.data)
                    },
                    error => onError(error.message)
                )
            },
            (error: ErrorResponseType) => onError(error.data as string)
        )
    }

    const create = (
        title: string,
        description: string,
        project: number,
        status: number,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            Url.api.bugs.create,
            {title, description, project, status},
            (response: SuccessResponseType) => onSuccess(response.data),
            (error: ErrorResponseType) => onError(error.data)
        )
    }

    const setBugStatus = (
        id: number,
        statusId: number,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        return api.post(
            Url.bugs.setStatus(id),
            {status: statusId},
            (response: SuccessResponseType) => onSuccess(response.data),
            (error: ErrorResponseType) => onError(error.data)
        )
    }

    return {
        get,
        getByProject,
        create,
        setBugStatus
    }
}

export default BugRepository
