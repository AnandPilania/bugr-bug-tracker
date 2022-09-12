import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {Person, SupervisorAccount} from "@mui/icons-material";

const UserTypeIcon = (props) => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return user.isAdmin ? <SupervisorAccount {...props} /> : <Person {...props} />
}

export default UserTypeIcon