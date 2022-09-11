import {Container} from "@mui/material";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Navbar from "./components/Navbar";
import IndexPage from "./pages/IndexPage";
import LoginPage from "../Auth/pages/LoginPage";
import LogoutPage from "../Auth/pages/LogoutPage";
import NotFoundPage from "./pages/NotFoundPage";
import RegisterPage from "../Auth/pages/RegisterPage";
import UserProfilePage from "../User/pages/UserProfilePage";
import ProtectedRoute from "../Auth/components/ProtectedRoute";
import ProviderWrapper from "./ProviderWrapper";
import URLs from "../URLs";

const App = () => {
    return (
        <ProviderWrapper>
            <BrowserRouter>
                <Navbar />
                <Container maxWidth="xl" sx={{paddingTop: 3}}>
                    <Routes>
                        <Route path={URLs.root} element={<IndexPage />} />
                        <Route path={URLs.auth.login} element={<LoginPage />} />
                        <Route path={URLs.auth.register} element={<RegisterPage />} />
                        <Route path={URLs.auth.logout} element={<LogoutPage />} />
                        <Route path={URLs.auth.profile} element={<ProtectedRoute><UserProfilePage /></ProtectedRoute>} />
                        <Route path="*" element={<NotFoundPage />} />
                    </Routes>
                </Container>
            </BrowserRouter>
        </ProviderWrapper>
    )
}

export default App