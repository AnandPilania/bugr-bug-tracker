import Database from "../Core/Firestore"
import {collection, onSnapshot, query, where} from 'firebase/firestore';

export type UseFirestoreType = {
    getByProject: Function
}

const useFirebase = () => {
    return {
        getByProject: (
            projectId: number,
            name: string,
            onSuccess: Function = () => {},
            onError: Function = () => {}
        ) => {
            onSnapshot(
                query(collection(Database, name), where('projectId', '==', projectId)),
                snapshot => onSuccess(snapshot.docs.map(doc => doc.data())),
                error => onError(error)
            )
        }
    }
}

export default useFirebase
