import useApi from "../../Api/useApi";
import Url from "../../Url";

const ProjectRepository = (api: useApi) => {
    const getAll = (onSuccess: Function, onError: Function) => {
        api.post(
            Url.api.projects.all,
            {},
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    const get = (id: number) => {
        console.log('Getting bug with id', id)
    }

    const getWithBugs = (): ProjectType[] => {
        return []
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
        create
    }
}

export default ProjectRepository
