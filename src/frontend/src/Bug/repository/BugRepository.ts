import {ErrorResponseType, SuccessResponseType, UseApiType} from "../../Api/useApi";
import Url from "../../Url";
import {StatusType} from "../../Status/repository/StatusRepository";
import {UserType} from "../../Auth/AuthContext";
import {ProjectType} from "../../Project/repository/ProjectRepository";
import Database from "../../Core/Firestore";
import { collection , onSnapshot } from 'firebase/firestore';

export type BugType = {
    id: number
    title: string,
    description: string,
    status: StatusType,
    project: ProjectType,
    assignee: UserType|null
}

const BugRepository = (api: UseApiType) => {

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
                onSnapshot(
                    collection(Database, 'bugs'),
                    snapshot => {
                        response.data.push(...snapshot.docs.map(doc => doc.data()))
                        onSuccess(response.data)
                    }
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
