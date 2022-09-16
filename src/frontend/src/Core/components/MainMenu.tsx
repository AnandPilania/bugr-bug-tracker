import MenuIcon from "@mui/icons-material/Menu";
import {IconButton, Menu} from "@mui/material";
import {useNavigate} from "react-router-dom";
import Url from "../../Url";
import {useState} from "react";
import {BugReportOutlined, DashboardOutlined, PagesOutlined, ViewKanban} from "@mui/icons-material";
import MenuItemWithIcon from "./MenuItemWithIcon";

const MainMenu = () => {
    const navigateTo = useNavigate()
    const [anchorEl, setAnchorEl] = useState<HTMLElement|null>(null)
    const menuOpen = Boolean(anchorEl)

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
            <MenuItemWithIcon onClick={() => navigateTo(Url.root)} icon={<DashboardOutlined />} text="Dashboard" />
            <MenuItemWithIcon onClick={() => navigateTo(Url.projects.all)} icon={<PagesOutlined />} text="Projects" />
            <MenuItemWithIcon onClick={closeMenu} icon={<BugReportOutlined />} text="Bugs" />
            <MenuItemWithIcon onClick={() => navigateTo(Url.kanban)} icon={<ViewKanban />} text="Kanban board" />
        </Menu>
    </>
}

export default MainMenu
