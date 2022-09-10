import {Container} from "@mui/material";
import Navbar from "./Core/components/Navbar";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import IndexPage from "./Core/pages/IndexPage";
import LoginPage from "./Auth/pages/LoginPage";
import LogoutPage from "./Auth/pages/LogoutPage";
import NotFoundPage from "./Core/pages/NotFoundPage";
import RegisterPage from "./Auth/pages/RegisterPage";
import URLs from "./URLs";
import UserProfilePage from "./User/pages/UserProfilePage";
import AuthProvider from "./Auth/AuthProvider";
import ProtectedRoute from "./Auth/components/ProtectedRoute";

const App = () => {
    return (
        <AuthProvider>
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
        </AuthProvider>
    )
}

export default App