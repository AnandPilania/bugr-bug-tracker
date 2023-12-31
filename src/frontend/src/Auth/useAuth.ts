import {useContext} from "react";
import useApi from "../Api/useApi";
import AuthContext, {UserType} from "./AuthContext";
import Url from "../Url";

const useAuth = () => {
    const api = useApi()
    const authContext = useContext(AuthContext)

    const validateToken = (token: string, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return api.post(
            Url.api.validateToken,
            {},
            response => {
                onSuccess(response.data.user as UserType)
            },
            err => {
                authContext.setUser(null)
                authContext.setToken(null)
                onError(err)
            },
            {token}
        )
    }

    const login = (
        username: string,
        password: string,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            Url.api.login,
            {username, password},
            (response) => {
                // check a user object was returned!
                // It is sufficient to say that if a user property exists in the returned data, that is a valid user object
                if (!response.data.user) {
                    onError("Unexpected data returned from the server")
                    return
                }

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
        friendlyName: string,
        isAdmin: boolean,
        onSuccess: Function = () => {},
        onError: Function = () => {}
    ) => {
        api.post(
            Url.api.register,
            {username, friendlyName, password, isAdmin},
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
