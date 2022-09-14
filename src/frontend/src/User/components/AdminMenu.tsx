import {Divider, MenuItem} from "@mui/material";
import Url from "../../Url";
import {PersonAddAltOutlined} from "@mui/icons-material";
import {useNavigate} from "react-router-dom";

const AdminMenu = () => {
    const navigateTo = useNavigate()

    return <>
        <MenuItem onClick={() => navigateTo(Url.auth.register)}><PersonAddAltOutlined sx={{marginRight:"0.5rem"}} />Create new user</MenuItem>
        <Divider />
    </>

}

export default AdminMenu