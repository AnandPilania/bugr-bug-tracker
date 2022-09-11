import {useContext} from "react";
import useApi from "../Api/useApi";
import {AuthContext, AuthContextType, UserType} from "./AuthContext";
import URLs from "../URLs";

const useAuth = () => {
    const api = useApi()
    const authContext = useContext<AuthContextType>(AuthContext)

    const validateToken = (token: string, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return api.post(
            URLs.api.validateToken,
            {token},
            response => {
                onSuccess(response.data.user as UserType)
            },
            err => {
                authContext.setUser(null)
                authContext.setToken(null)
                onError(err)
            })
    }

    const login = (
        username: string,
        password: string,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            URLs.api.login,
            {username, password},
            (response) => {
                authContext.setUser(response.data.user as UserType)
                authContext.setToken(response.data.token as string)
                onSuccess()
            },
            (err) => {
                authContext.setUser(null)
                authContext.setToken(null)
                onError(err.data)
            }
        )
    }

    const logout = () => {
        authContext.setUser(null)
        authContext.setToken(null)
    }

    const register = (
        username: string,
        password: string,
        displayName: string,
        isAdmin: boolean,
        apikey: string,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            URLs.api.register,
            {username, displayName, password, isAdmin, apikey},
            () => {
                // this is deliberately nested to ensure our api provider response doesn't leak out
                // if we need to get some of that out in the future, here is where we'll do it
                onSuccess()
            },
            err => {
                onError(err.data)
            })
    }

    return {
        login,
        logout,
        register,
        validateToken
    }
}

export default useAuth
