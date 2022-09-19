import AuthContext from "../../Auth/AuthContext";
import {useContext, useState} from "react";
import {useNavigate} from "react-router-dom";
import {Divider, IconButton, Menu, MenuItem, PopoverProps, Tooltip} from "@mui/material";
import {Logout} from "@mui/icons-material";
import Url from "../../Url";
import UserTypeIcon from "./UserTypeIcon";
import AdminMenu from "./AdminMenu";

const UserProfileMenu = () => {
    const [anchorElement, setAnchorElement] = useState<PopoverProps[anchorElement]>(null)
    const {user} = useContext(AuthContext)
    const navigateTo = useNavigate()
    const menuOpen = Boolean(anchorElement)

    const showMenu = (e) => {
        setAnchorElement(e.currentTarget)
    }

    const hideMenu = () => {
        setAnchorElement(null)
    }

    return <>
        <Tooltip title="Account settings">
            <IconButton edge="end" color="inherit" onClick={showMenu}>
                <UserTypeIcon />
            </IconButton>
        </Tooltip>

        <Menu anchorEl={anchorElement} open={menuOpen} onClick={hideMenu} onClose={hideMenu}>
            <Tooltip title="View your profile">
                <MenuItem onClick={() => navigateTo(Url.auth.profile)}><UserTypeIcon sx={{marginRight:"0.5rem"}} />{user.friendlyName}</MenuItem>
            </Tooltip>

            <Divider />

            {user.isAdmin && <AdminMenu />}

            <MenuItem onClick={() => navigateTo(Url.auth.logout)}><Logout sx={{marginRight:"0.5rem"}} />Log out</MenuItem>
        </Menu>
    </>
}

export default UserProfileMenu
