import {Link as MuiLink, Typography} from "@mui/material";
import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {Link} from "react-router-dom";
import URLs from "../../URLs";
import BugRepository from "../../Bug/Repository/BugRepository";
import useRepository from "../hooks/useRepository";

const IndexPage = () => {
    const {user} = useContext<AuthContextType>(AuthContext)
    const bugRepository = useRepository(BugRepository)

    const bug = bugRepository.get(12)


    return <>
        <Typography>{user && `Hello ${user.friendlyName}, `}Welcome to Bug Tracker.</Typography>
        <Typography>
            {!user && <MuiLink component={Link} to={URLs.auth.login}>Log in here</MuiLink>}
        </Typography>
        <Typography></Typography>
    </>
}

export default IndexPage
