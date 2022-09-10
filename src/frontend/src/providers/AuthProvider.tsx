import {SetStateAction, useState} from "react";
import {AuthContext, UserType} from "../contexts/AuthContext"
import useCookie from "../hooks/useCookie";

const AuthProvider = ({children}) => {
    const storedUser = useCookie('user', null)

    // @todo refactor out this JSON.parse block by storing a string token instead of a user object
    let serialisedUser = storedUser.get()
    let defaultUser = null
    if(serialisedUser) {
        defaultUser = JSON.parse(serialisedUser)
    }
    const [user, _setUser] = useState<UserType|null>(defaultUser)

    /**
     * This function exists to satisfy the linter.
     * If you pass the function returned by useState, that has a different signature to this hand-crafted one
     */
    const setUser = (user: UserType|null) => {
        if (user === null) {
            storedUser.delete()
        } else {
            storedUser.set(JSON.stringify(user))
        }
        _setUser(user as SetStateAction<UserType>)
    }

    return (
        <AuthContext.Provider value={{user, setUser}}>
            {children}
        </AuthContext.Provider>
    )
}

export default AuthProvider