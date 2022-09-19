import {AppBar, Toolbar, Typography} from "@mui/material";
import UserProfileMenu from "../../User/components/UserProfileMenu";
import MainMenu from "./MainMenu";
import {useContext} from "react";
import AuthContext from "../../Auth/AuthContext";
import LoginButton from "../../Auth/components/buttons/LoginButton";
import Config from "../../config";

const Navbar = () => {
    const {user} = useContext(AuthContext)

    return (
        <AppBar position="static">
            <Toolbar variant="dense">
                <MainMenu/>
                <Typography align="center" width="100%">{Config.app_title}</Typography>
                {user ? <UserProfileMenu/> : <LoginButton />}
            </Toolbar>
        </AppBar>
    )
}

export default Navbar
