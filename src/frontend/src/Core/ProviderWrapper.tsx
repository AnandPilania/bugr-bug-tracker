import LoadingOverlayProvider from "../Api/LoadingOverlayProvider";
import AuthProvider from "../Auth/AuthProvider";
import SnackbarProviderWrapper from "./components/SnackbarProviderWrapper";

const ProviderWrapper = ({children}) => (
    <LoadingOverlayProvider>
        <SnackbarProviderWrapper>
            <AuthProvider>
                {children}
            </AuthProvider>
        </SnackbarProviderWrapper>
    </LoadingOverlayProvider>
)

export default ProviderWrapper
