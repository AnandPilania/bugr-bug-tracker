import {UseApiType} from "../../Api/useApi";
import Url from "../../Url";

const DashboardRepository = (api: UseApiType) => {
    const getDashboardData = (onSuccess: Function, onError: Function) => {
        return api.post(
            Url.api.dashboard,
            {},
            response => {
                // @todo Transform response before sending back to Dashboard component
                onSuccess(response.data)
            },
            err => onError(err.data)
        )
    }

    return {
        getDashboardData
    }
}

export default DashboardRepository