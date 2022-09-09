import {useContext} from "react";
import useApi from "./useApi";
import {AuthContext, AuthContextType, UserType} from "../contexts/AuthContext";
import URLs from "../config/URLs";

const useAuth = () => {
    const Api = useApi()
    const authContext: AuthContextType = useContext(AuthContext)

    const login = (username: String, password: String, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        Api.post(
            URLs.api.login,
            {username, password},
            (response) => {
                authContext.setUser(response.data.user as UserType)
                onSuccess()
            },
            (err) => {
                authContext.setUser(null)
                onError(err.data)
            }
        )
    }

    const logout = () => {
        authContext.setUser(null)
    }

    const register = (username: string, password: string, displayName: string, apikey: string, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        Api.post(
            URLs.api.register,
            {username, displayName, password, apikey},
            response => {
                onSuccess()
            },
            err => {
                onError(err.data)
            })
    }

    return {
        login,
        logout,
        register
    }
}

export default useAuth
