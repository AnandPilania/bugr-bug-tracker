import {Link as MuiLink, Typography} from "@mui/material";
import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {Link} from "react-router-dom";
import URLs from "../../URLs";

const IndexPage = () => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return <>
        <Typography>{user && `Hello ${user.displayName}, `}Welcome to Bug Tracker.</Typography>
        <Typography>
            {!user && <MuiLink component={Link} to={URLs.auth.login}>Log in here</MuiLink>}
        </Typography>
    </>
}

export default IndexPage
