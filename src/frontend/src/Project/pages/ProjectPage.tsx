import {Button, Typography} from "@mui/material";
import ProjectRepository from "../repository/ProjectRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useEffect, useState} from "react";
import {useSnackbar} from "notistack";
import {PlusOneOutlined} from "@mui/icons-material";

const ProjectPage = () => {
    const {enqueueSnackbar: setError} = useSnackbar()
    const repository = useRepository(ProjectRepository)
    const [projects, setProjects] = useState([])

    useEffect(() => {
        repository.getAll(
            projects => setProjects(projects),
            err => setError(err)
        )
    }, [])

    const showNewProjectModal = () => {
        // @todo
    }

    return (
        <>
            <Typography variant="h2">Projects</Typography>
            <Typography><Button variant="outlined" onClick={() => showNewProjectModal()}><PlusOneOutlined />Create new Project</Button></Typography>
            <Typography variant="code">{JSON.stringify(projects)}</Typography>
        </>
    )
}

export default ProjectPage