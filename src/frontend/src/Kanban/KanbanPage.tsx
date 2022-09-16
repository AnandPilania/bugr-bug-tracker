import {
    Card, CardActionArea, CardContent,
    FormControl,
    InputLabel,
    MenuItem,
    Select,
    Table, TableBody,
    TableCell,
    TableHead,
    TableRow,
    Typography
} from "@mui/material";
import {useEffect, useState} from "react";
import useRepository from "../Core/hooks/useRepository";
import ProjectRepository from "../Project/repository/ProjectRepository";
import {useSnackbar} from "notistack";
import {useNavigate} from "react-router-dom";
import Url from "../Url";

const KanbanPage = () => {
    const projectRepository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()
    const [projectId, setProjectId] = useState('')
    const [projects, setProjects] = useState([])
    const [bugs, setBugs] = useState([])
    const navigateTo = useNavigate()

    useEffect(() => {
        return projectRepository.getAll(
            projects => setProjects(projects),
            err => setError(err, {variant: "error"})
        )
    }, [])

    useEffect(() => {
        if (projectId !== '') {
            console.log('Loading project with id', projectId)
            return projectRepository.getBugs(
                projectId as number,
                bugs => {
                    console.log(bugs)
                    setBugs(bugs)
                },
                err => {
                    setError(err)
                }
            )
        }
    }, [projectId])

    const currentProject = projects.filter(project => project.id === projectId)[0]

    return (
        <>
            <Typography variant="h1">Kanban</Typography>
            <FormControl fullWidth>
                <InputLabel>Project</InputLabel>
                <Select value={projectId} label="Project" onChange={e => setProjectId(e.target.value)}>
                    {projects.map((project, key) => <MenuItem value={project.id}
                                                              key={`p-${key}`}>{project.title}</MenuItem>)}
                </Select>
            </FormControl>

            {currentProject && (
                <Table style={{tableLayout:"fixed"}}>
                    <TableHead>
                        <TableRow>
                            {currentProject.statuses.map((status, key) =>
                                <TableCell key={`s-${key}`} align="center">{status.title}</TableCell>
                            )}
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        <TableRow>
                            {currentProject.statuses.map((status,key) => (
                                <TableCell key={`bs-${key}`} sx={{verticalAlign:"top"}}>
                                    {bugs.filter(bug => bug.status.id === status.id).map((bug,key) =>
                                        <Card variant="outlined" key={`b-${key}`} sx={{marginY:"0.5rem"}}>
                                            <CardActionArea onClick={() => navigateTo(Url.bugs.view(bug.id))}>
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
            )}
        </>
    )
}

export default KanbanPage
