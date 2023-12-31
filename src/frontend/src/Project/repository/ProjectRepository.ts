import {UseApiType, ErrorResponseType, SuccessResponseType} from "../../Api/useApi";
import Url from "../../Url";
import {BugType} from "../../Bug/repository/BugRepository";
import {StatusType} from "../../Status/repository/StatusRepository";
import {UseCacheType} from "../../Core/useCache";

export type ProjectType = {
    id: number,
    title: string,
    bugs: Array<BugType>,
    statuses: Array<StatusType>
}

const ProjectRepository = (api: UseApiType, cache: UseCacheType) => {
    const getAll = (onSuccess: Function, onError: Function) => {
        const CACHE_KEY = 'project_all'

        if (cache.has(CACHE_KEY)) {
            onSuccess(cache.get(CACHE_KEY))
        } else {
            return api.get(
                Url.api.projects.all,
                {},
                ({data: projects}: SuccessResponseType) => {
                    cache.add(CACHE_KEY, projects, 60000)
                    onSuccess(projects as Array<ProjectType>)
                },
                ({data: message}: ErrorResponseType) => onError(message as string)
            )
        }
    }

    const get = (id: number, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return api.get(
            Url.api.projects.get(id),
            {},
            (response: SuccessResponseType) => onSuccess(response.data as ProjectType),
            (error: ErrorResponseType) => onError(error.data as string)
        )
    }

    const deleteProject = (id: number, onSuccess: Function = (response: string) => {}, onError: Function = (err: string) => {}) => {
        api.delete(
            Url.api.projects.delete(id),
            (response: SuccessResponseType) => onSuccess(response.data as string),
            (error: ErrorResponseType) => onError(error.data as string)
        )
    }

    const getBugs = (projectId: number, onSuccess: Function = (bugs: Array<BugType>) => {}, onError: Function = (err: string) => {}) => {
        return api.get(
            Url.api.projects.bugs(projectId),
            {},
            (response: SuccessResponseType) => onSuccess(response.data as Array<BugType>),
            (error: ErrorResponseType) => onError(error.data as string)
        )
    }

    const create = (projectName: string, onSuccess: (response: string) => {}, onError: (err: string) => {}) => {
        api.post(
            Url.api.projects.create,
            {projectName},
            (response: SuccessResponseType) => onSuccess(response.data as string),
            (error: ErrorResponseType) => onError(error.data as string)
        )
    }

    return {
        get,
        getAll,
        getBugs,
        create,
        delete: deleteProject
    }
}

export default ProjectRepository
