import {Typography} from "@mui/material";
import {useParams} from "react-router-dom";

const ProjectPage = () => {
    const {projectId} = useParams()
    return <Typography>{projectId}</Typography>
}

export default ProjectPage