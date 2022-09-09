import {AppBar, IconButton, Toolbar, Tooltip, Typography} from "@mui/material";
import MenuIcon from "@mui/icons-material/Menu";
import {LockPerson, Person} from "@mui/icons-material";
import {Link, useNavigate} from "react-router-dom";
import {AuthContext, AuthContextType} from "../contexts/AuthContext";
import {useContext} from "react";

const Navbar = () => {
    const authContext: AuthContextType = useContext(AuthContext)
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
                        <MenuIcon onClick={() => navigateTo('/')} />
                </IconButton>

                <Typography align="center" width="100%">Bug Tracker</Typography>

                { authContext.user
                    ? <Tooltip title="Log out"><IconButton edge="end" color="inherit" onClick={logout}><Person /></IconButton></Tooltip>
                    : <Tooltip title="Log in"><IconButton edge="end" color="inherit" onClick={login}><LockPerson /></IconButton></Tooltip>
                }
            </Toolbar>
        </AppBar>
    )
}

export default Navbar
