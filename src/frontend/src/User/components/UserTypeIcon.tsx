import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {PersonOutline, SupervisorAccountOutlined} from "@mui/icons-material";

const UserTypeIcon = (props) => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return user.isAdmin ? <SupervisorAccountOutlined {...props} /> : <PersonOutline {...props} />
}

export default UserTypeIcon