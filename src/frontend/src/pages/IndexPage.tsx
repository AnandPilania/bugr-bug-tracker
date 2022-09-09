import {Link as MuiLink, Typography} from "@mui/material";
import {useContext} from "react";
import {AuthContext} from "../contexts/AuthContext";
import {Link} from "react-router-dom";

const IndexPage = () => {
    const {user} = useContext(AuthContext)

    return (
        <Typography>
            Welcome to Bug Tracker. &nbsp;
            { user
                ? `Hello, ${user.displayName}.`
                : <MuiLink component={Link} to="/login">Log in here</MuiLink>
            }
        </Typography>
    )
}

export default IndexPage
