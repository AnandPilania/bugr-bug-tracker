import useApi from "../../Api/useApi";
import Url from "../../Url";

export type StatusType = {
    id: number
    title: string,
    projectId: number
}

const StatusRepository = (api: useApi) => {
    const get = (id: number) => {
        console.log('Getting status with id', id)
    }

    const getAll = () => {
        console.log('Getting all the statuses')
    }

    const create = (title: string, project: string, onSuccess: Function = (response) => {}, onError: Function = (err) => {}) => {
        api.post(
            Url.api.statuses.create,
            {title, project},
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    return {
        get,
        getAll,
        create
    }
}

export default StatusRepository
