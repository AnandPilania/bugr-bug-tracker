import {Button, Divider, Link as MuiLink, List, ListItem, Typography} from "@mui/material";
import ProjectRepository from "../repository/ProjectRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useEffect, useState} from "react";
import {useSnackbar} from "notistack";
import NewProjectModalForm from "../components/NewProjectModalForm";
import {Link} from "react-router-dom";
import Url from "../../Url";
import {AddOutlined} from "@mui/icons-material";

const ProjectListPage = () => {
    const {enqueueSnackbar: setError} = useSnackbar()
    const repository = useRepository(ProjectRepository)
    const [projects, setProjects] = useState([])
    const [newProjectModalOpen, setNewProjectModalOpen] = useState(false)

    let [refetch, setRefetch] = useState(false)
    useEffect(() => {
        return repository.getAll(
            projects => {
                setProjects(projects)
            },
            err => setError(err)
        )

        // eslint-disable-next-line
    }, [refetch])

    const doRefetch = () => {
        setRefetch(v => !v)
    }

    const openNewProjectModal = () => setNewProjectModalOpen(true)

    return (
        <>
            <Typography variant="h2">Projects</Typography>
            <Typography><Button onClick={() => openNewProjectModal()}><AddOutlined /> Create new project</Button></Typography>
            <Divider />
            <List>
                {projects.map((project,key) => (
                    <ListItem key={`p-${project.id}`}>
                        <MuiLink component={Link} to={Url.projects.view(project.id)}>{project.title}</MuiLink>
                    </ListItem>
                ))}
            </List>

            <NewProjectModalForm open={newProjectModalOpen} setOpen={setNewProjectModalOpen} onSaveNewProject={doRefetch} />
        </>
    )
}

export default ProjectListPage