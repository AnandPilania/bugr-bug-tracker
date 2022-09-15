import useApi from "../../Api/useApi";
import Url from "../../Url";

const ProjectRepository = (api: useApi) => {
    const getAll = (onSuccess: Function, onError: Function) => {
        return api.post(
            Url.api.projects.all,
            {},
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    const get = (id: number, onSuccess: Function = (project) => {}, onError: Function = (err) => {}) => {
        return api.get(
            Url.api.projects.get(id),
            {},
            res => onSuccess(res.data),
            err => onError(err.data)
        )
    }

    const getWithBugs = (id: number, onSuccess: Function = (project) => {}, onError: Function = (err) => {}) => {
        return api.get(
            Url.api.projects.getWithBugs(id),
            {},
            res => onSuccess(res.data),
            err => onError(err.data)
        )
    }

    const deleteProject = (id: number, onSuccess: Function = () => {}, onError: Function = (err) => {}) => {
        api.delete(
            Url.api.projects.delete(id),
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    const getBugs = (projectId: number, onSuccess: Function = (bugs) => {}, onError: Function = (err) => {}) => {
        return api.get(
            Url.api.projects.bugs(projectId),
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    const create = (projectName: string, onSuccess: (response) => {}, onError: (err) => {}) => {
        api.post(
            Url.api.projects.create,
            {projectName},
            res => onSuccess(res.data),
            err => onError(err.data)
        )
    }

    return {
        get,
        getAll,
        getWithBugs,
        create,
        delete: deleteProject
    }
}

export default ProjectRepository
