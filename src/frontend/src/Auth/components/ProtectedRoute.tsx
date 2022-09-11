import {AuthContext, AuthContextType} from "../AuthContext";
import React, {useContext} from "react";
import NotAuthorisedPage from "../pages/NotAuthorisedPage";

type ProtectedRouteProps = {
    children: React.ReactElement | React.ReactElement[],
    requiresAdmin: boolean
}

const ProtectedRoute = ({children, requiresAdmin}) => {
    const {user} = useContext<AuthContextType>(AuthContext)

    if (!user) {
        return <NotAuthorisedPage />
    }

    if (requiresAdmin && !user.isAdmin) {
        return <NotAuthorisedPage />
    }

    return children
}

export default ProtectedRoute
