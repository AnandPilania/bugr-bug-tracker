import {
    Button,
    Divider,
    Typography
} from "@mui/material";
import {useNavigate, useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import NotFoundPage from "../../Core/pages/NotFoundPage";
import useRepository from "../../Core/hooks/useRepository";
import ProjectRepository, {ProjectType} from "../repository/ProjectRepository";
import {useSnackbar} from "notistack";
import {Delete} from "@mui/icons-material";
import ProjectStatusSection from "../components/ProjectStatusSection";
import ProjectBugSection from "../components/ProjectBugSection";
import Url from "../../Url";
import React from "react";

const ProjectPage = () => {
    const {projectId} = useParams()
    const projectRepository = useRepository(ProjectRepository)
    const [project, setProject] = useState<ProjectType|null>(null)
    const {enqueueSnackbar: setError} = useSnackbar()
    const navigateTo = useNavigate()

    useEffect(() => {
        return projectRepository.get(
            projectId,
            (project: ProjectType) => {
                setProject(project)
            },
            (error: string) => setError(error, {variant:"error"})
        )
        // eslint-disable-next-line
    }, [])

    const deleteProject = () => {
        // make API call to delete a project
        projectRepository.delete(
            projectId,
            (response: string) => {
                setError(response, {variant: "success"})
                navigateTo(Url.projects.all)
            },
            (error: string) => setError(error, {variant:"error"})
        )
    }

    if (project === null) {
        return <NotFoundPage />
    }

    return (
        <>
            <Typography variant="h2">{project.title}</Typography>
            <Typography><Button onClick={deleteProject}><Delete sx={{marginRight: "0.5rem"}} />Delete project</Button> </Typography>

            <Typography>Expand the sections below to see more information about this Project</Typography>
            <Divider />

            <ProjectStatusSection project={project} />
            <ProjectBugSection project={project} />
        </>
    )
}

export default ProjectPage