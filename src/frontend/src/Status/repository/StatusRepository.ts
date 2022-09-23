import {ErrorResponseType, SuccessResponseType, UseApiType} from "../../Api/useApi";
import Url from "../../Url";

export type StatusType = {
    id: number
    title: string,
    projectId: number,
    onKanban: boolean,
    order: number,
}

const StatusRepository = (api: UseApiType) => {
    const getByProject = (
        projectId: number,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        return api.get(
            Url.statuses.byProject(projectId),
            {},
            (response: SuccessResponseType) => onSuccess(response.data as Array<StatusType>),
            (error: ErrorResponseType) => onError(error.data as string)
        )
    }

    const create = (
        title: string, project: string,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            Url.api.statuses.create,
            {title, project},
            (response: SuccessResponseType) => onSuccess(response.data as string),
            (error: ErrorResponseType) => onError(error.data)
        )
    }

    const changeOnKanban = (
        statusId: number, onKanban: boolean,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            Url.api.statuses.changeOnKanban,
            {statusId, onKanban},
            (response: SuccessResponseType) => onSuccess(response.data as string),
            (error: ErrorResponseType) => onError(error.data)
        )
    }

    const swapOrder = (
        firstStatusId, secondStatusId,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            Url.api.statuses.swap,
            {firstStatusId, secondStatusId},
            (response: SuccessResponseType) => onSuccess(response.data as string),
            (error: ErrorResponseType) => onError(error.data)
        )
    }

    return {
        getByProject,
        create,
        changeOnKanban,
        swapOrder
    }
}

export default StatusRepository
