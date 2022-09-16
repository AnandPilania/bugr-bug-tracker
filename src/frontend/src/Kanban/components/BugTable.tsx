import {
    Card,
    CardActionArea,
    CardContent,
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableRow,
    Typography
} from "@mui/material";
import ViewBugModal from "../../Bug/components/ViewBugModal";
import {useEffect, useState} from "react";
import useRepository from "../../Core/hooks/useRepository";
import ProjectRepository from "../../Project/repository/ProjectRepository";
import {useSnackbar} from "notistack";

const BugTable = ({projectId, statuses}) => {
    const [bugId, setBugId] = useState(null)
    const [bugs, setBugs] = useState([])
    const [refetch, setRefetch] = useState(false)
    const projectRepository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        if (projectId !== '') {
            return projectRepository.getBugs(
                projectId as number,
                bugs => {
                    setBugs(bugs)
                },
                err => {
                    setError(err)
                }
            )
        }
        //eslint-disable-next-line
    }, [projectId,refetch])

    const doRefetch = () => setRefetch(v => !v)

    return (
        <>
            <Table style={{tableLayout: "fixed"}}>
                <TableHead>
                    <TableRow>
                        {statuses.map((status, key) =>
                            <TableCell key={`s-${key}`} align="center">{status.title}</TableCell>
                        )}
                    </TableRow>
                </TableHead>
                <TableBody>
                    <TableRow>
                        {statuses.map((status, key) => (
                            <TableCell key={`bs-${key}`} sx={{verticalAlign: "top"}}>
                                {bugs.filter(bug => bug.status.id === status.id).map((bug, key) =>
                                    <Card variant="outlined" key={`b-${key}`} sx={{marginY: "0.5rem"}}>
                                        <CardActionArea onClick={() => setBugId(bug.id)}>
                                            <CardContent>
                                                <Typography color="primary">{bug.title}</Typography>
                                                <Typography>{bug.description}</Typography>
                                                <Typography sx={{textAlign: "right"}}
                                                            color="text.secondary">{bug.assignee?.friendlyName ?? ''}</Typography>
                                            </CardContent>
                                        </CardActionArea>
                                    </Card>
                                )}
                            </TableCell>
                        ))}
                    </TableRow>
                </TableBody>
            </Table>

            <ViewBugModal setBugId={setBugId} bugId={bugId} statuses={statuses} doRefetch={doRefetch}/>
        </>
    )
}

export default BugTable
