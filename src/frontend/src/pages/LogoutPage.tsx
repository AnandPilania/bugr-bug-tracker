import {Navigate} from "react-router-dom"
import useAuth from "../hooks/useAuth";

const LogoutPage = () => {
    const Auth = useAuth()

    Auth.logout()

    return <Navigate to="/"></Navigate>
}

export default LogoutPage
