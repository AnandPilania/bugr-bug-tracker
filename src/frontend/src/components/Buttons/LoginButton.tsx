import {IconButton, Tooltip} from "@mui/material";
import {Login} from "@mui/icons-material";
import {useNavigate} from "react-router-dom";
import URLs from "../../config/URLs";

const LoginButton = () => {
    const navigateTo = useNavigate()

    return (
        <Tooltip title="Log in">
            <IconButton edge="end" color="inherit" onClick={() => navigateTo(URLs.auth.login)}>
                <Login />
            </IconButton>
        </Tooltip>
    )
}

export default LoginButton
