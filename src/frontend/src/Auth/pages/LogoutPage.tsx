import {useNavigate} from "react-router-dom"
import useAuth from "../useAuth";
import {useEffect} from "react";
import {Typography} from "@mui/material";
import Url from "../../Url";

const LogoutPage = () => {
    const navigateTo = useNavigate()
    const Auth = useAuth()

    useEffect(() => {
        Auth.logout()
        navigateTo(Url.root)
    })

    return <Typography>Logging out...</Typography>
}

export default LogoutPage
