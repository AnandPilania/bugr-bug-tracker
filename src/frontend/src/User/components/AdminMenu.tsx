import {Divider, MenuItem} from "@mui/material";
import URLs from "../../URLs";
import {PersonAddAltOutlined} from "@mui/icons-material";
import {useNavigate} from "react-router-dom";

const AdminMenu = () => {
    const navigateTo = useNavigate()

    return <>
        <MenuItem onClick={() => navigateTo(URLs.auth.register)}><PersonAddAltOutlined sx={{marginRight:"0.5rem"}} />Create new user</MenuItem>
        <Divider />
    </>

}

export default AdminMenu