import {Container} from "@mui/material";
import Navbar from "./components/Navbar";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import IndexPage from "./pages/IndexPage";
import LoginPage from "./pages/LoginPage";
import LogoutPage from "./pages/LogoutPage";
import NotFoundPage from "./pages/NotFoundPage";
import RegisterPage from "./pages/RegisterPage";
import URLs from "./config/URLs";
import UserProfilePage from "./pages/UserProfilePage";
import AuthProvider from "./providers/AuthProvider";
import ProtectedRoute from "./components/ProtectedRoute";

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