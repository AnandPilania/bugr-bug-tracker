import AuthContext from "../AuthContext";
import {ReactElement, useContext} from "react";
import NotAuthorisedPage from "../pages/NotAuthorisedPage";

type ProtectedRouteProps = {
    children: ReactElement | ReactElement[],
    requiresAdmin?: boolean
}

const ProtectedRoute = ({children, requiresAdmin = false}: ProtectedRouteProps): ReactElement => {
    const {user} = useContext(AuthContext)

    if (!user) {
        return <NotAuthorisedPage />
    }

    if (requiresAdmin && !user.isAdmin) {
        return <NotAuthorisedPage />
    }

    return children
}

export default ProtectedRoute
