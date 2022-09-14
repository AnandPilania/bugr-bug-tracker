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
    const repository = useRepository(ProjectRepository)
    const [project, setProject] = useState(null)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        // fetch project details
        repository.get(
            projectId,
            project => setProject(project),
            err => setError(err, {variant:"error"})
        )
    }, [])

    const deleteProject = () => {
        // make API call to delete a project
        repository.delete(
            projectId,
            () => setError('Project deleted', {variant:"success"}),
            err => setError(err, {variant:"error"})
        )
    }

    if (project === null) {
        return <NotFoundPage />
    }

    return (
        <>
            <Typography>{project.title}</Typography>
            <Divider sx={{marginY: "1rem"}} />

            <Typography><Button onClick={deleteProject}><Delete />Delete project</Button> </Typography>
        </>
    )
}

export default ProjectPage