import {useState} from "react";
import {LoadingOverlayContext} from "./LoadingOverlayContext";
import {Backdrop, CircularProgress} from "@mui/material";

/**
 * This dodgy looking hack is to prevent the component (and therefore the entire app) re-rendering when "show" is
 * called and the overlay is already visible.  Instead, we count the number of times we've been asked to show/hide
 * the overlay and only when the number reaches zero do we hide it.
 */
let timesShown: number = 0

const LoadingOverlayProvider = ({children}) => {
    const [visible, setVisible] = useState<boolean>(false)

    const show = () => {
        ++timesShown
        if (timesShown > 0) {
            setVisible(true)
        }
    }

    const hide = () => {
        --timesShown
        if (timesShown <= 0)
        setVisible(false)
    }

    return (
        <LoadingOverlayContext.Provider value={{show, hide}}>
            {children}
            <Backdrop open={visible}>
                <CircularProgress color="inherit" />
            </Backdrop>
        </LoadingOverlayContext.Provider>
    )
}

export default LoadingOverlayProvider