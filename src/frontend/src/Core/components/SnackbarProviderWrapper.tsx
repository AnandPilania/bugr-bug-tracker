import {SnackbarProvider} from "notistack";

const SnackbarProviderWrapper = ({children}) => (
    <SnackbarProvider maxSnack="3" autoHideDuration="3000" anchorOrigin={{vertical:"bottom", horizontal:"right"}}>
        {children}
    </SnackbarProvider>
)

export default SnackbarProviderWrapper
