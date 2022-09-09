import {useContext} from "react";
import {AuthContext, AuthContextType} from "../contexts/AuthContext";
import {Typography} from "@mui/material";

const UserProfilePage = () => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return <>
        <Typography>Username: {user.username}</Typography>
        <Typography>Display name: {user.displayName}</Typography>
    </>
}

export default UserProfilePage
