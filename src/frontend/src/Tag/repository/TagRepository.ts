import {UseApiType} from "../../Api/useApi";
import Url from "../../Url";

export type TagType = {
    id: number
    title: string,
    projectId: number
}

const TagRepository = (api: UseApiType) => {
    const getByProject = (
        projectId: number,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        return api.get(
            Url.api.tags.byProject(projectId),
            {},
            response => onSuccess(response.data),
            error => onError(error.data)
        )
    }

    const create = (
        projectId: number, title: string,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        return api.post(
            Url.api.tags.create,
            {projectId, title},
            response => onSuccess(response.data),
            error => onError(error.data)
        )
    }

    return {
        getByProject,
        create
    }
}

export default TagRepository