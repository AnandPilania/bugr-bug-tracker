import {
    Box,
    Button,
    DialogContent,
    MenuItem,
    Select,
    Table,
    TableBody,
    TableCell,
    TableRow,
    Typography
} from "@mui/material";
import DialogForm from "../../Core/components/DialogForm";
import {useEffect, useState} from "react";
import useRepository from "../../Core/hooks/useRepository";
import BugRepository, {BugType} from "../repository/BugRepository";
import {useSnackbar} from "notistack";
import useCache from "../../Core/useCache";

type ViewBugModalProps = {
    setBugId: Function,
    bugId: number|null,
    statuses: Array<{}>,
    onComplete: Function
}

const ViewBugModal = ({setBugId, bugId, statuses = [], onComplete = () => {}}: ViewBugModalProps) => {
    const [bug, setBug] = useState<BugType|null>(null)
    const [newStatus, setNewStatus] = useState<number>(null)
    const bugRepository = useRepository(BugRepository)
    const {enqueueSnackbar: setError} = useSnackbar()
    const cache = useCache()

    useEffect(() => {
        if (bugId) {
            return bugRepository.get(
                bugId,
                bug => {
                    setBug(bug)
                    setNewStatus(bug.status.id)
                },
                err => setError(err, {variant: "error"})
            )
        }
        //eslint-disable-next-line
    }, [bugId])

    const closeModal = () => {
        setBugId(null)
    }

    const saveNewBugStatus = () => {
        bugRepository.setBugStatus(
            bugId,
            newStatus,
            response => {
                cache.delete('bug_all')
                setError(response, {variant: "success"})
                closeModal()
                onComplete()
            },
            err => setError(err, {variant:"error"})
        )
    }

    if (bugId === null || bug === null) {
        return null
    }

    return (
        <DialogForm title={bug.title} open={true} onClose={closeModal} fullWidth="true" maxWidth="md"
                    actions={<Button onClick={closeModal}>Close</Button>}>
            <DialogContent>
                <Typography>{bug.description}</Typography>
                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell><Typography>Project</Typography></TableCell>
                            <TableCell><Typography>{bug.project.title}</Typography></TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell><Typography>Status</Typography></TableCell>
                            <TableCell><Typography>{bug.status.title}</Typography></TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell><Typography>Description</Typography></TableCell>
                            <TableCell><Typography>{bug.description}</Typography></TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <Box sx={{mt: "2rem"}}>
                    <Select value={newStatus} onChange={e => setNewStatus(e.target.value)}>
                        {statuses.map( (status,key) => <MenuItem key={`ss-${key}`} value={status.id}>{status.title}</MenuItem>)}
                    </Select>

                    <Button onClick={saveNewBugStatus}>Change Status</Button>
                </Box>
            </DialogContent>
        </DialogForm>
    )
}

export default ViewBugModal