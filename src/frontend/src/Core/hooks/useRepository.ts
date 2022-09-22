import useApi from "../../Api/useApi";
import useCache from "../useCache";

const useRepository = (repositoryName) => {
    // The point of this hook is to inject the API hook into the repository when returning it.
    const api = useApi()
    const cache = useCache()
    return repositoryName(api, cache)
}

export default useRepository
