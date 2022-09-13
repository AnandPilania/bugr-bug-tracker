import {ReactElement, useContext} from "react";
import {AuthContext, AuthContextType} from "../AuthContext";

type IfLoggedInRouteProps = {
    notLoggedIn: ReactElement,
    loggedIn: ReactElement
}

const IfLoggedInRoute = ({notLoggedIn, loggedIn}: IfLoggedInRouteProps) => {
    const {user} = useContext<AuthContextType>(AuthContext)

    return user ? loggedIn : notLoggedIn
}

export default IfLoggedInRoute
