import {
    FormControl,
    InputLabel,
    MenuItem,
    Select,
    Typography
} from "@mui/material";
import {useEffect, useState} from "react";
import useRepository from "../Core/hooks/useRepository";
import ProjectRepository from "../Project/repository/ProjectRepository";
import {useSnackbar} from "notistack";
import BugTable from "./components/BugTable";

const KanbanPage = () => {
    const projectRepository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()
    const [projectId, setProjectId] = useState('')
    const [projects, setProjects] = useState([])

    console.log('- KanbanPage')

    useEffect(() => {
        return projectRepository.getAll(
            projects => setProjects(projects),
            err => setError(err, {variant: "error"})
        )
        //eslint-disable-next-line
    }, [])

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

            {currentProject && <BugTable projectId={projectId} statuses={currentProject.statuses} />}
        </>
    )
}

export default KanbanPage
