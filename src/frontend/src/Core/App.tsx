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
import Url from "../Url";
import IfLoggedInRoute from "../Auth/components/IfLoggedInRoute";
import DashboardPage from "./pages/DashboardPage";
import ProjectListPage from "../Project/pages/ProjectListPage";
import ProjectPage from "../Project/pages/ProjectPage";
import KanbanPage from "../Kanban/KanbanPage";

const App = () => {
    return (
        <ProviderWrapper>
            <BrowserRouter>
                <Navbar />
                <Container maxWidth="xl" sx={{paddingTop: 3}}>
                    <Routes>
                        <Route path={Url.root} element={<IfLoggedInRoute notLoggedIn={<IndexPage />} loggedIn={<DashboardPage />} />} />
                        <Route path={Url.auth.login} element={<LoginPage />} />
                        <Route path={Url.auth.register} element={<ProtectedRoute requiresAdmin><RegisterPage /></ProtectedRoute>} />
                        <Route path={Url.auth.logout} element={<LogoutPage />} />
                        <Route path={Url.auth.profile} element={<ProtectedRoute><UserProfilePage /></ProtectedRoute>} />
                        <Route path={Url.projects.all} element={<ProtectedRoute><ProjectListPage /></ProtectedRoute>} />
                        <Route path={Url.projects.one} element={<ProtectedRoute><ProjectPage /></ProtectedRoute>} />
                        <Route path={Url.kanban} element={<ProtectedRoute><KanbanPage /></ProtectedRoute>} />
                        <Route path="*" element={<NotFoundPage />} />
                    </Routes>
                </Container>
            </BrowserRouter>
        </ProviderWrapper>
    )
}

export default App