import {useContext} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {Typography} from "@mui/material";

const UserProfilePage = () => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return <>
        <Typography>Username: {user.username}</Typography>
        <Typography>Display name: {user.displayName}</Typography>
        <Typography>You are {user.isAdmin ? "an Administrator" : "a Normal user"}</Typography>
    </>
}

export default UserProfilePage
