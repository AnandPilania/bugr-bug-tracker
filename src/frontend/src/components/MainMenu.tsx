import MenuIcon from "@mui/icons-material/Menu";
import {IconButton} from "@mui/material";
import {useNavigate} from "react-router-dom";
import URLs from "../config/URLs";

const MainMenu = () => {
    const navigateTo = useNavigate()

    return (
        <IconButton edge="start" color="inherit">
            <MenuIcon onClick={() => navigateTo(URLs.root)} />
        </IconButton>
    )
}

export default MainMenu
