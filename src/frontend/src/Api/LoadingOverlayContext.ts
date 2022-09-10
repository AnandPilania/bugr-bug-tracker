import {createContext} from "react";

type LoadingOverlayContextType = {
    show: Function,
    hide: Function
}

const LoadingOverlayContext = createContext<LoadingOverlayContextType>({
    show: () => {},
    hide: () => {}}
)

export {
    LoadingOverlayContext,
    LoadingOverlayContextType
}
