import {Link} from "react-router-dom";
import {useContext} from "react";
import AuthContext from "../../Auth/AuthContext";
import {Link as MuiLink, Typography} from "@mui/material";
import Config from "../../config";
import Url from "../../Url";

const IndexPageLoggedIn = () => {
    const {user} = useContext(AuthContext)

    return (
        <>
            <Typography variant="h1">{Config.app_title}.</Typography>
            <Typography>
                Welcome, {user.friendlyName}. The <MuiLink component={Link} to={Url.kanban.root}>Kanban board</MuiLink>
                &nbsp;is a good place to get started
            </Typography>
        </>
    )
}

export default IndexPageLoggedIn
