import useApi from "../../Api/useApi";

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

    return {
        get,
        topX
    }
}

export default BugRepository
