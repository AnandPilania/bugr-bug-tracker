import MenuIcon from "@mui/icons-material/Menu";
import {IconButton} from "@mui/material";
import {useNavigate} from "react-router-dom";
import URLs from "../config/URLs";

const MainMenu = () => {
    const navigateTo = useNavigate()

    return (
        <IconButton edge="start" color="inherit" onClick={() => navigateTo(URLs.root)}>
            <MenuIcon />
        </IconButton>
    )
}

export default MainMenu
