import LoadingOverlayProvider from "../Api/LoadingOverlayProvider";
import AuthProvider from "../Auth/AuthProvider";
import SnackbarProviderWrapper from "./providers/SnackbarProviderWrapper";
import NewBugModalProvider from "./providers/NewBugModalProvider";

const ProviderWrapper = ({children}) => (
    <LoadingOverlayProvider>
        <SnackbarProviderWrapper>
            <AuthProvider>
                <NewBugModalProvider>
                    {children}
                </NewBugModalProvider>
            </AuthProvider>
        </SnackbarProviderWrapper>
    </LoadingOverlayProvider>
)

export default ProviderWrapper
