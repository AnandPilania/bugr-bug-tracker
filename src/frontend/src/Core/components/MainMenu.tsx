import MenuIcon from "@mui/icons-material/Menu";
import {IconButton, Menu} from "@mui/material";
import {useNavigate} from "react-router-dom";
import Url from "../../Url";
import {useContext, useState} from "react";
import {PagesOutlined, ViewKanban} from "@mui/icons-material";
import MenuItemWithIcon from "./MenuItemWithIcon";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";

const MainMenu = () => {
    const navigateTo = useNavigate()
    const [anchorEl, setAnchorEl] = useState<HTMLElement|null>(null)
    const menuOpen = Boolean(anchorEl)
    const {user} = useContext<AuthContextType>(AuthContext)

    const openMenu = (e) => {
        setAnchorEl(e.currentTarget)
    }

    const closeMenu = () => {
        setAnchorEl(null)
    }

    const toggleMenu = (e) => {
        if (anchorEl === null) {
            openMenu(e)
            return
        }

        closeMenu()
    }

    return <>
        <IconButton edge="start" color="inherit" onClick={toggleMenu}>
            <MenuIcon />
        </IconButton>
        <Menu open={menuOpen} anchorEl={anchorEl} onClose={closeMenu} onClick={closeMenu}>
            {user?.isAdmin && <MenuItemWithIcon onClick={() => navigateTo(Url.projects.all)} icon={<PagesOutlined />} text="Projects" />}
            <MenuItemWithIcon onClick={() => navigateTo(Url.kanban)} icon={<ViewKanban />} text="Kanban board" />
        </Menu>
    </>
}

export default MainMenu
