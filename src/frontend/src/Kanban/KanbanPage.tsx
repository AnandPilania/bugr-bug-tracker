import {
    FormControl,
    InputLabel,
    MenuItem,
    Select,
    Typography
} from "@mui/material";
import {useEffect, useState} from "react";
import useRepository from "../Core/hooks/useRepository";
import ProjectRepository, {ProjectType} from "../Project/repository/ProjectRepository";
import {useSnackbar} from "notistack";
import KanbanBoard from "./components/KanbanBoard";
import {useNavigate, useParams} from "react-router-dom";
import Url from "../Url";

const KanbanPage = () => {
    const {projectId = ''} = useParams()
    const navigateTo = useNavigate()
    const projectRepository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()
    const [projects, setProjects] = useState<Array<ProjectType>>([])

    useEffect(() => {
        return projectRepository.getAll(
            (projects: Array<ProjectType>) => setProjects(projects),
            (error: string) => setError(error, {variant: "error"})
        )
        //eslint-disable-next-line
    }, [])

    const ProjectMenuItems = projects.map(
        (project, key) => <MenuItem value={project.id} key={`p-${key}`}>{project.title}</MenuItem>
    )

    return (
        <>
            <Typography variant="h1">Kanban</Typography>
            {projects.length > 0 ?
                <FormControl fullWidth>
                    <InputLabel>Project</InputLabel>
                    <Select value={projectId} label="Project" onChange={e => navigateTo(Url.projects.kanban(Number(e.target.value)))}>
                        {ProjectMenuItems}
                    </Select>
                </FormControl>
            :
                <Typography>No projects have been set up yet.</Typography>
            }

            {projectId !== '' && <KanbanBoard projectId={Number(projectId)} />}
        </>
    )
}

export default KanbanPage
