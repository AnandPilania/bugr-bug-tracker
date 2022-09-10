import {AppBar, Toolbar, Typography} from "@mui/material";
import UserProfileMenu from "../../User/components/UserProfileMenu";
import MainMenu from "./MainMenu";

const Navbar = () => (
    <AppBar position="static">
        <Toolbar variant="dense">
            <MainMenu />
            <Typography align="center" width="100%">Bug Tracker</Typography>
            <UserProfileMenu />
        </Toolbar>
    </AppBar>
)

export default Navbar
