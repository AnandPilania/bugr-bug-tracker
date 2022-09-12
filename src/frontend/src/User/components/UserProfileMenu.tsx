import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {useContext, useState} from "react";
import {useNavigate} from "react-router-dom";
import {Divider, IconButton, Menu, MenuItem, PopoverProps, Tooltip} from "@mui/material";
import {Logout, PersonAdd} from "@mui/icons-material";
import URLs from "../../URLs";
import UserTypeIcon from "./UserTypeIcon";
import AdminMenu from "./AdminMenu";

const UserProfileMenu = () => {
    const [menuOpen, setMenuOpen] = useState(false)
    const [anchorElement, setAnchorElement] = useState<PopoverProps[anchorElement]>(null)
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

    return <>
        <Tooltip title="Account settings">
            <IconButton edge="end" color="inherit" onClick={showMenu}>
                <UserTypeIcon />
            </IconButton>
        </Tooltip>

        <Menu anchorEl={anchorElement} open={menuOpen} onClick={hideMenu} onClose={hideMenu}>
            <Tooltip title="View your profile">
                <MenuItem onClick={() => navigateTo(URLs.auth.profile)}><UserTypeIcon sx={{marginRight:"0.5rem"}} />{user.displayName}</MenuItem>
            </Tooltip>

            <Divider />

            {user.isAdmin && <AdminMenu />}

            <MenuItem onClick={() => navigateTo(URLs.auth.logout)}><Logout sx={{marginRight:"0.5rem"}} />Log out</MenuItem>
        </Menu>
    </>
}

export default UserProfileMenu
