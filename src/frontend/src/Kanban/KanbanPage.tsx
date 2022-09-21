import {
    MenuItem,
    Typography
} from "@mui/material";
import {useEffect, useState} from "react";
import useRepository from "../Core/hooks/useRepository";
import ProjectRepository, {ProjectType} from "../Project/repository/ProjectRepository";
import {useSnackbar} from "notistack";
import KanbanBoard from "./components/KanbanBoard";
import {useNavigate, useParams} from "react-router-dom";
import Url from "../Url";
import ProjectSelect from "../Project/components/ProjectSelect";

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

        // eslint-disable-next-line
    }, [])

    return (
        <>
            <Typography variant="h1">Kanban</Typography>
            {projectId === '' ?
                <ProjectSelect onChange={projectId => navigateTo(Url.projects.kanban(projectId))} />
            : <Typography variant="h4">{projects.find(project => project.id === Number(projectId))?.title}</Typography>
            }

            {projectId !== '' && <KanbanBoard projectId={Number(projectId)} />}
        </>
    )
}

export default KanbanPage
