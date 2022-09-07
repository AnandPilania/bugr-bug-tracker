import {AppBar, IconButton, Toolbar, Tooltip, Typography} from "@mui/material";
import MenuIcon from "@mui/icons-material/Menu";
import useAuth from "../hooks/useAuth";
import {LockPerson, Person} from "@mui/icons-material";
import {useNavigate} from "react-router-dom";

const Navbar = () => {
    const Auth = useAuth()
    const navigateTo = useNavigate()

    const login = () => {
        navigateTo('/login')
    }

    const logout = () => {
        navigateTo('/logout')
    }

    return (
        <AppBar position="static">
            <Toolbar variant="dense">
                <IconButton edge="start" color="inherit">
                    <MenuIcon/>
                </IconButton>

                <Typography align="center" width="100%">Bug Tracker</Typography>

                { Auth.user
                    ? <Tooltip title="Log out"><IconButton edge="end" color="inherit" onClick={logout}><Person /></IconButton></Tooltip>
                    : <Tooltip title="Log in"><IconButton edge="end" color="inherit" onClick={login}><LockPerson /></IconButton></Tooltip>
                }
            </Toolbar>
        </AppBar>
    )
}

export default Navbar
