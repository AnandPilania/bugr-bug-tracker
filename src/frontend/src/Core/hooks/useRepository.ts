import useApi from "../../Api/useApi";
import useFirebase from "../../Api/useFirebase";

const useRepository = (repositoryName) => {
    // The point of this hook is to inject the API hook into the repository when returning it.
    const api = useApi()
    const firebase = useFirebase()
    return repositoryName(api, firebase)
}

export default useRepository
