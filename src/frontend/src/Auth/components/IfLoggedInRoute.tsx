import {ReactElement, useContext} from "react";
import AuthContext from "../AuthContext";

type IfLoggedInRouteProps = {
    notLoggedIn: ReactElement,
    loggedIn: ReactElement
}

const IfLoggedInRoute = ({notLoggedIn, loggedIn}: IfLoggedInRouteProps) => {
    const {user} = useContext(AuthContext)

    return user ? loggedIn : notLoggedIn
}

export default IfLoggedInRoute
