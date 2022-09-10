import {Route} from "react-router-dom";
import {AuthContext, AuthContextType} from "../contexts/AuthContext";
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
