import {
    TableBody,
    TableCell,
    TableHead,
    TableRow
} from "@mui/material";
import ViewBugModal from "../../Bug/components/ViewBugModal";
import {useEffect, useState} from "react";
import StatusRepository, {StatusType} from "../../Status/repository/StatusRepository";
import BugRepository, {BugType} from "../../Bug/repository/BugRepository";
import FixedTable from "../../Core/components/FixedTable";
import KanbanColumn from "./KanbanColumn";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";

type KanbanBoardProps = {
    projectId: number
}

const KanbanBoard = ({projectId}: KanbanBoardProps) => {
    const [statuses, setStatuses] = useState<Array<StatusType>>([])
    const [bugs, setBugs] = useState<Array<BugType>>([])
    const [bugId, setBugId] = useState<number|null>(null)
    const statusRepository = useRepository(StatusRepository)
    const bugRepository = useRepository(BugRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const loadBugs = () => {
        return bugRepository.getByProject(
            projectId,
            (bugs: Array<BugType>) => setBugs(bugs.sort((a,b) => a.title.localeCompare(b.title))),
            (error: string) => setError(error, {variant: "error"})
        )
    }

    useEffect(() => {
        return statusRepository.getByProject(
            projectId,
            (statuses: Array<StatusType>) => setStatuses(
                statuses
                    .filter(status => status.onKanban === true)
                    .sort((a,b) => (a.order - b.order))),
            (error: string) => setError(error, {variant:"error"})
        )
        // eslint-disable-next-line
    }, [projectId])

    useEffect(() => {
        return loadBugs()
        // eslint-disable-next-line
    }, [projectId])

    return (
        <>
            <FixedTable>
                <TableHead>
                    <TableRow>
                        {statuses.map((status: StatusType) =>
                            <TableCell key={`s-${status.id}`} align="center">{status.title}</TableCell>
                        )}
                    </TableRow>
                </TableHead>
                <TableBody>
                    <TableRow>
                        {statuses.map((status, key) => (
                            <KanbanColumn key={`bs-${key}`} statusId={status.id} bugs={bugs} setBugId={setBugId} />
                        ))}
                    </TableRow>
                </TableBody>
            </FixedTable>

            <ViewBugModal setBugId={setBugId} bugId={bugId} statuses={statuses} onComplete={loadBugs} />
        </>
    )
}

export default KanbanBoard