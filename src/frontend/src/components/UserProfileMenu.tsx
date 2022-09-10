import {AuthContext, AuthContextType} from "../contexts/AuthContext";
import {useContext, useState} from "react";
import {useNavigate} from "react-router-dom";
import LoginButton from "./Buttons/LoginButton";
import {Divider, IconButton, Menu, MenuItem, Tooltip} from "@mui/material";
import {Logout, Person} from "@mui/icons-material";
import URLs from "../config/URLs";

const UserProfileMenu = () => {
    const [menuOpen, setMenuOpen] = useState(false)
    const [anchorElement, setAnchorElement] = useState(null)
    const {user} = useContext<AuthContextType>(AuthContext)
    const navigateTo = useNavigate()

    const showMenu = (e) => {
        setAnchorElement(e.currentTarget)
        setMenuOpen(true)
    }

    const hideMenu = () => {
        setAnchorElement(null)
        setMenuOpen(false)
    }

    return !user ? <LoginButton /> :
        <>
        <Tooltip title="Account settings">
            <IconButton edge="end" color="inherit" onClick={showMenu}>
                <Person/>
            </IconButton>
        </Tooltip>

        <Menu anchorEl={anchorElement} open={menuOpen} onClick={hideMenu} onClose={hideMenu}>
            <MenuItem style={{textAlign: "right"}}>{user.displayName}</MenuItem>
            <MenuItem onClick={() => navigateTo(URLs.auth.profile)}><Person /> Profile</MenuItem>
            <Divider />
            <MenuItem onClick={() => navigateTo(URLs.auth.logout)}><Logout /> Log out</MenuItem>
        </Menu>
    </>
}

export default UserProfileMenu
