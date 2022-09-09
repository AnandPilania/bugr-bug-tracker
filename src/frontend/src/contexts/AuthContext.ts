import React from "react";

type UserType = {
    username: string,
    displayName: string
}

type AuthContextType = {
    user: UserType,
    setUser: Function
}

const AuthContext = React.createContext({
    user: null,
    setUser: () => {}
})

export {
    AuthContext,
    AuthContextType,
    UserType
}
