import useApi from "../../Api/useApi";
import Url from "../../Url";

export type BugType = {
    id: number
    title: string,
    description: string,
    statusName: string,
    assigneeName: string
}

const BugRepository = (api: useApi) => {

    const get = (id: number, onSuccess: Function = response => {}, onError: Function = err => {}) => {
        return api.get(
            Url.bugs.view(id),
            {},
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    const create = (
        title: string,
        project: string,
        status: string,
        onSuccess: Function = response => {},
        onError: Function = err => {}
    ) => {
        api.post(
            Url.api.bugs.create,
            {title, project, status},
            response => onSuccess(response.data),
            err => onError(err.data)
        )
    }

    const setBugStatus = (
        id,
        status,
        onSuccess: Function = response => {},
        onError: Function = err => {}
    ) => {
        return api.post(
            Url.bugs.setStatus(id),
            {status},
            res => onSuccess(res.data),
            err => onError(err.data)
        )
    }

    return {
        get,
        create,
        setBugStatus
    }
}

export default BugRepository
