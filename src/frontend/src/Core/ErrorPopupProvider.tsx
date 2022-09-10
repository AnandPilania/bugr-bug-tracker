import ErrorPopup from "./components/ErrorPopup";
import {ErrorPopupContext} from "./contexts/ErrorPopupContext";
import {useState} from "react";

const ErrorPopupProvider = ({children}) => {
    const [error, setError] = useState('')

    return (
        <ErrorPopupContext.Provider value={{setError}}>
            {children}
            <ErrorPopup error={error} />
        </ErrorPopupContext.Provider>
    )
}

export default ErrorPopupProvider