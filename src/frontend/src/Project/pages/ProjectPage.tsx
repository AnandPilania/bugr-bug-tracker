import {
    Button,
    Divider,
    Typography
} from "@mui/material";
import {useNavigate, useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import NotFoundPage from "../../Core/pages/NotFoundPage";
import useRepository from "../../Core/hooks/useRepository";
import ProjectRepository from "../repository/ProjectRepository";
import {useSnackbar} from "notistack";
import {Delete} from "@mui/icons-material";
import ProjectStatusSection from "../components/ProjectStatusSection";
import ProjectBugSection from "../components/ProjectBugSection";
import Url from "../../Url";

const ProjectPage = () => {
    const {projectId} = useParams()
    const projectRepository = useRepository(ProjectRepository)
    const [project, setProject] = useState(null)
    const {enqueueSnackbar: setError} = useSnackbar()
    const navigateTo = useNavigate()

    const [refetch, setRefetch] = useState(false)

    console.log('- ProjectPage')

    useEffect(() => {
        console.log('Fetching project data')
        return projectRepository.getWithBugs(
            projectId,
            project => {
                setProject(project)
            },
            err => setError(err, {variant:"error"})
        )
        // eslint-disable-next-line
    }, [refetch])

    const deleteProject = () => {
        // make API call to delete a project
        projectRepository.delete(
            projectId,
            response => {
                setError(response, {variant: "success"})
                navigateTo(Url.projects.all)
            },
            err => setError(err, {variant:"error"})
        )
    }

    const doRefetch = () => {
        setRefetch(v => !v)
    }

    if (project === null) {
        return <NotFoundPage />
    }

    return (
        <>
            <Typography variant="h2">{project.title}</Typography>
            <Typography><Button onClick={deleteProject}><Delete />Delete project</Button> </Typography>

            <Typography>Expand the sections below to see more information about this Project</Typography>
            <Divider sx={{marginY:"1rem"}} />

            <ProjectStatusSection project={project} doRefetch={doRefetch} />
            <ProjectBugSection project={project} doRefetch={doRefetch} />
        </>
    )
}

export default ProjectPage