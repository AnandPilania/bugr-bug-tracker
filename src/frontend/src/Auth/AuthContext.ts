import {createContext} from "react";

type UserType = {
    username: string,
    displayName: string
}

type AuthContextType = {
    user: UserType,
    token: string,
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
