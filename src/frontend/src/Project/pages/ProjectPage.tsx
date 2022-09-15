import {Button, Divider, Typography} from "@mui/material";
import {useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import NotFoundPage from "../../Core/pages/NotFoundPage";
import useRepository from "../../Core/hooks/useRepository";
import ProjectRepository from "../repository/ProjectRepository";
import {useSnackbar} from "notistack";
import {Delete} from "@mui/icons-material";

const ProjectPage = () => {
    const {projectId} = useParams()
    const projectRepository = useRepository(ProjectRepository)
    const [project, setProject] = useState(null)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        console.log('Fetching project data')
        return projectRepository.get(
            projectId,
            project => {
                setProject(project)
            },
            err => setError(err, {variant:"error"})
        )
        // eslint-disable-next-line
    }, [])

    useEffect(() => {
        if (project !== null) {
            console.log('Fetching bugs for project')
            return projectRepository.getBugs(project.id)
        }
        // eslint-disable-next-line
    }, [project])

    const deleteProject = () => {
        // make API call to delete a project
        projectRepository.delete(
            projectId,
            response => {
                setError(response, {variant: "success"})
            },
            err => setError(err, {variant:"error"})
        )
    }

    if (project === null) {
        return <NotFoundPage />
    }

    return (
        <>
            <Typography variant="h2">{project.title}</Typography>
            <Typography><Button onClick={deleteProject}><Delete />Delete project</Button> </Typography>

            <Divider sx={{marginY:"1rem"}} />
            <Typography>Some other information about the project</Typography>
        </>
    )
}

export default ProjectPage