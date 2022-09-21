import useApi from "../../Api/useApi";

const useRepository = (repositoryName) => {
    // The point of this hook is to inject the API hook into the repository when returning it.
    const api = useApi()
    return repositoryName(api)
}

export default useRepository
