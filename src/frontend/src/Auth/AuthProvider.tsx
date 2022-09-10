import {SetStateAction, useEffect, useState} from "react";
import {AuthContext, UserType} from "./AuthContext"
import useCookie from "../Core/hooks/useCookie";
import useAuth from "./useAuth";

const AuthProvider = ({children}) => {
    const storedToken = useCookie('token', null)
    const [token, _setToken] = useState<string|null>(storedToken.get())
    const [user, _setUser] = useState<UserType|null>(null)

    const auth = useAuth()

    useEffect(() => {
        // This hook will fire after every render of the AuthProvider, which should be once per app load
        // If we fished a token out of the cookie, we'll query the API to fetch the User for that token
        if (token) {
            const apiRequest = auth.validateToken(
                token,
                user => setUser(user),
                err => {
                    console.log(err)
                    setToken(null)
                    setUser(null)
                }
            )

            return () => apiRequest.abort()
        }
        // I acknowledge that this dependency array is deliberately empty as we only want this hook to run once
        //eslint-disable-next-line
    }, [])

    /**
     * These functions exist to satisfy the linter.
     * If you pass the function returned by useState, that has a different signature to this hand-crafted one
     */
    const setUser = (user: UserType|null) => {
        _setUser(user as SetStateAction<UserType>)
    }

    const setToken = (token: string|null) => {
        if (token === null) {
            storedToken.delete()
        } else {
            storedToken.set(token)
        }
        _setToken(token as SetStateAction<string>)
    }

    return (
        <AuthContext.Provider value={{user, setUser, token, setToken}}>
            {children}
        </AuthContext.Provider>
    )
}

export default AuthProvider