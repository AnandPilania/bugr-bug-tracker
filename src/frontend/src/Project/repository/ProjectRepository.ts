import useApi from "../../Api/useApi";
import URLs from "../../URLs";

const ProjectRepository = (api: useApi) => {
    const getAll = (onSuccess: Function, onError: Function) => {
        api.post(
            URLs.api.projects.all,
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

    return {
        get,
        getAll,
        getWithBugs
    }
}

export default ProjectRepository
