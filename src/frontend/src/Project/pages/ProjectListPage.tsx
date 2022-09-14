import {Button, Link as MuiLink, List, ListItem, Typography} from "@mui/material";
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
        repository.getAll(
            projects => setProjects(projects),
            err => setError(err)
        )
        // eslint-disable-next-line
    }, [refetch])

    const onSaveNewProject = () => {
        // A new project has been created, we should re-fetch the list of projects to display
        // @todo DODGY HACK to make the component reload which will trigger the useEffect to load the list of projects
        setRefetch(!refetch)
    }

    return (
        <>
            <Typography variant="h2">Projects</Typography>
            <Typography><Button onClick={() => setNewProjectModalOpen(true)}><AddOutlined /> Create new project</Button></Typography>
            <List>
                {projects.map((project,key) => (
                    <ListItem key={`p-${project.id}`}>
                        <MuiLink component={Link} to={Url.projects.view(project.id)}>{project.title}</MuiLink></ListItem>
                ))}
            </List>

            <NewProjectModalForm open={newProjectModalOpen} setOpen={setNewProjectModalOpen} onSaveNewProject={onSaveNewProject} />
        </>
    )
}

export default ProjectListPage