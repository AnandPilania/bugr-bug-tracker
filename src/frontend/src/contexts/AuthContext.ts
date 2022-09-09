import {createContext} from "react";

type UserType = {
    username: string,
    displayName: string
}

type AuthContextType = {
    user: UserType,
    setUser: Function
}

const AuthContext = createContext({
    user: null,
    setUser: (user: UserType) => {}
})

export {
    AuthContext,
    AuthContextType,
    UserType
}
