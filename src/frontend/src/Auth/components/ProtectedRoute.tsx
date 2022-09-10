import {AuthContext, AuthContextType} from "../AuthContext";
import {useContext} from "react";
import NotAuthorisedPage from "../pages/NotAuthorisedPage";

const ProtectedRoute = ({children}) => {
    const {user} = useContext<AuthContextType>(AuthContext)

    if (!user) {
        return <NotAuthorisedPage />
    }

    return children
}

export default ProtectedRoute
