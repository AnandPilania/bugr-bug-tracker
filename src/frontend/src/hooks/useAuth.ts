import {useContext} from "react";
import useApi from "./useApi";
import {AuthContext, AuthContextType, UserType} from "../contexts/AuthContext";

const useAuth = () => {
    const Api = useApi()
    const authContext: AuthContextType = useContext(AuthContext)

    const login = (username: String, password: String, callback: Function) => {
        Api.post(
            '/login',
            {username, password},
            (response) => {
                authContext.setUser(response.data.user as UserType)
                callback()
            },
            (err) => {
                authContext.setUser(null)
                console.log(err)
            }
        )
    }

    const logout = () => {
        authContext.setUser(null)
    }

    return {
        login,
        logout
    }
}

export default useAuth
