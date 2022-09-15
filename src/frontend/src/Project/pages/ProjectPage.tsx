import {Button, Divider, List, ListItem, Typography} from "@mui/material";
import {useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import NotFoundPage from "../../Core/pages/NotFoundPage";
import useRepository from "../../Core/hooks/useRepository";
import ProjectRepository from "../repository/ProjectRepository";
import {useSnackbar} from "notistack";
import {AddOutlined, BugReportOutlined, Delete, ListAltTwoTone} from "@mui/icons-material";
import NewProjectModalForm from "../components/NewProjectModalForm";
import NewBugModalForm from "../../Bug/components/NewBugModalForm";
import NewStatusModalForm from "../../Status/components/NewStatusModalForm";

const ProjectPage = () => {
    const {projectId} = useParams()
    const projectRepository = useRepository(ProjectRepository)
    const [project, setProject] = useState(null)
    const [newBugModalOpen, setNewBugModalOpen] = useState(false)
    const [newStatusModalOpen, setNewStatusModalOpen] = useState(false)
    const {enqueueSnackbar: setError} = useSnackbar()

    const [refetch, setRefetch] = useState(false)

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
            },
            err => setError(err, {variant:"error"})
        )
    }

    const openNewBugModal = () => {
        console.log('openNewBugModal')
        setNewBugModalOpen(true)
    }

    const onSaveNewBug = () => {
        // trigger re-render as the bug should now appear in this list
        setRefetch(v => !v)
    }

    const openNewStatusModal = () => {
        console.log('openNewStatusModal')
        setNewStatusModalOpen(true)
    }

    const onSaveNewStatus = () => {
        setNewStatusModalOpen(false)
        // trigger re-render as the status should now appear in this list
        setRefetch(v => !v)
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

            <Typography><Button onClick={openNewStatusModal}><ListAltTwoTone />Add new Status</Button></Typography>
            <List>
                {project.statuses.map((status,key) => (
                    <ListItem key={`s-${key}`}>{status.title}</ListItem>
                ))}
            </List>
            <NewStatusModalForm open={newStatusModalOpen} setOpen={setNewStatusModalOpen} onSaveNewStatus={onSaveNewStatus} project={project.title} />

            <Typography><Button onClick={openNewBugModal}><BugReportOutlined />Create new Bug</Button></Typography>
            <NewBugModalForm open={newBugModalOpen} setOpen={setNewBugModalOpen} onSaveNewBug={onSaveNewBug} project={project.title} />
        </>
    )
}

export default ProjectPage