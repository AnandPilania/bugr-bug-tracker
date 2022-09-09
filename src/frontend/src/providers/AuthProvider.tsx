import {SetStateAction, useEffect, useState} from "react";
import {AuthContext, UserType} from "../contexts/AuthContext"
import useCookie from "../hooks/useCookie";

const AuthProvider = ({children}) => {
    const [user, _setUser] = useState<UserType|null>()
    const storedUser = useCookie('user', null)

    const setUser = (user: UserType|null) => {
        if (user === null) {
            storedUser.delete()
        } else {
            storedUser.set(JSON.stringify(user))
        }
        _setUser(user as SetStateAction<UserType>)
    }

    useEffect(() => {
        const user = JSON.parse(storedUser.get())
        setUser(user)
    }, [])

    return (
        <AuthContext.Provider value={{user, setUser}}>
            {children}
        </AuthContext.Provider>
    )
}

export default AuthProvider