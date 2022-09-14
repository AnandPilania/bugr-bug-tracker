import {createContext} from "react";

type UserType = {
    username: string,
    friendlyName: string,
    isAdmin: boolean
}

type AuthContextType = {
    user: UserType|null,
    token: string|null,
    setUser: Function
    setToken: Function
}

const AuthContext = createContext({
    user: null,
    token: null,
    setUser: (user: UserType) => {},
    setToken: (token: string) => {}
})

export {
    AuthContext,
    AuthContextType,
    UserType
}
