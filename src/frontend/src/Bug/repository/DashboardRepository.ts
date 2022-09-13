import {UseApiType} from "../../Api/useApi";
import URLs from "../../URLs";

// return [{
//     id: 1,
//     title: "BugTrackr todo",
//     statuses: [
//         'Backlog',
//         'In progress',
//         'Review',
//         'Done',
//         'Cancelled'
//     ],
//     bugs: [
//         {
//             id: 1,
//             title: "Pretend bug",
//             description: "Unable to replicate",
//             statusName: "Backlog",
//             assigneeName: "rwatson"
//         } as BugType,
//         {
//             id: 2,
//             title: "Another Bug",
//             description: "Probably a duplicate",
//             statusName: "In progress",
//             assigneeName: "dhayes"
//         } as BugType,
//         {
//             id: 3,
//             title: "Sort something",
//             description: "The thing needs a tweak",
//             statusName: "Review",
//             assigneeName: "rwatson"
//         } as BugType,
//         {
//             id: 4,
//             title: "Finished this one",
//             description: "Not important",
//             statusName: "Done",
//             assigneeName: "dhayes"
//         } as BugType,
//         {
//             id: 5,
//             title: "Rubbish",
//             description: "Not important",
//             statusName: "Cancelled",
//             assigneeName: "rwatson"
//         } as BugType
//     ]
// } as ProjectType]

const DashboardRepository = (api: UseApiType) => {
    const getDashboardData = (onSuccess: Function, onError: Function) => {
        api.post(
            URLs.api.dashboard,
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