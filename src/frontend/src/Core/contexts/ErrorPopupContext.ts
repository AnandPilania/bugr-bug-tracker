import {createContext} from "react";

type ErrorPopupContextType = {
    error: string,
    setError: Function
}

const ErrorPopupContext = createContext({error: '', setError: (error: string) => {}})

export {
    ErrorPopupContext,
    ErrorPopupContextType
}
