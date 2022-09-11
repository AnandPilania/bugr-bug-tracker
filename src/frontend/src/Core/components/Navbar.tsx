import {AppBar, Toolbar, Typography} from "@mui/material";
import UserProfileMenu from "../../User/components/UserProfileMenu";
import MainMenu from "./MainMenu";
import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import LoginButton from "../../Auth/components/buttons/LoginButton";

const Navbar = () => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return (
        <AppBar position="static">
            <Toolbar variant="dense">
                <MainMenu/>
                <Typography align="center" width="100%">Bug Tracker</Typography>
                {user ? <UserProfileMenu/> : <LoginButton />}
            </Toolbar>
        </AppBar>
    )
}

export default Navbar
