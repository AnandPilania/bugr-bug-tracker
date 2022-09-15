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
    const get = (id: number) => {
        console.log('Getting bug with id', id)
    }

    const topX = (x: number) => {
        // gets the top X bugs
        console.log('Getting top ', x)
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

    return {
        get,
        create,
        topX
    }
}

export default BugRepository
