import {useState} from "react";

const useAuth = () => {
    const [user, setUser] = useState(null)

    const login = (user: String, password: String) => {
        // do login
        setUser({
            user, password
        })
    }

    const logout = () => {
        setUser(null)
    }

    return {
        user,
        login,
        logout
    }
}

export default useAuth
