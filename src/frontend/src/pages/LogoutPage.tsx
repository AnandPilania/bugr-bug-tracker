import {Navigate, useNavigate} from "react-router-dom"
import useAuth from "../hooks/useAuth";
import {useEffect} from "react";
import {Typography} from "@mui/material";
import URLs from "../config/URLs";

const LogoutPage = () => {
    const navigateTo = useNavigate()
    const Auth = useAuth()

    useEffect(() => {
        Auth.logout()
        navigateTo(URLs.root)
    })

    return <Typography>Logging out...</Typography>
}

export default LogoutPage
