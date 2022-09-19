import {createContext} from "react";

export type UserType = {
    username: string,
    friendlyName: string,
    isAdmin: boolean
}

export type AuthContextType = {
    user: UserType|null,
    token: string|null,
    setUser: Function
    setToken: Function
}

const AuthContext = createContext({
    user: null,
    token: null,
    setUser: () => {},
    setToken: () => {}
})

export default AuthContext
