import {Link, useNavigate} from "react-router-dom";
import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {Link as MuiLink, Typography} from "@mui/material";
import Config from "../../config";
import Url from "../../Url";

const IndexPageLoggedIn = () => {
    const navigateTo = useNavigate()
    const {user} = useContext<AuthContextType>(AuthContext)

    return (
        <>
            <Typography variant="h1">{Config.app_title}.</Typography>
            <Typography>
                Welcome, {user.friendlyName}. The <MuiLink component={Link} to={Url.kanban}>Kanban board</MuiLink>
                &nbsp;is a good place to get started
            </Typography>
        </>
    )
}

export default IndexPageLoggedIn
