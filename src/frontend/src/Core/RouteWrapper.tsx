import {Route, Routes} from "react-router-dom";
import Url from "../Url";
import IfLoggedInRoute from "../Auth/components/IfLoggedInRoute";
import IndexPage from "./pages/IndexPage";
import IndexPageLoggedIn from "./pages/IndexPageLoggedIn";
import LoginPage from "../Auth/pages/LoginPage";
import ProtectedRoute from "../Auth/components/ProtectedRoute";
import RegisterPage from "../Auth/pages/RegisterPage";
import LogoutPage from "../Auth/pages/LogoutPage";
import UserProfilePage from "../User/pages/UserProfilePage";
import ProjectListPage from "../Project/pages/ProjectListPage";
import ProjectPage from "../Project/pages/ProjectPage";
import KanbanPage from "../Kanban/KanbanPage";
import NotFoundPage from "./pages/NotFoundPage";

const RouteWrapper = () => (
    <Routes>
        <Route path={Url.root} element={<IfLoggedInRoute notLoggedIn={<IndexPage />} loggedIn={<IndexPageLoggedIn />} />} />
        <Route path={Url.auth.login} element={<LoginPage />} />
        <Route path={Url.auth.register} element={<ProtectedRoute requiresAdmin><RegisterPage /></ProtectedRoute>} />
        <Route path={Url.auth.logout} element={<LogoutPage />} />
        <Route path={Url.auth.profile} element={<ProtectedRoute><UserProfilePage /></ProtectedRoute>} />
        <Route path={Url.projects.all} element={<ProtectedRoute><ProjectListPage /></ProtectedRoute>} />
        <Route path={Url.projects.one} element={<ProtectedRoute><ProjectPage /></ProtectedRoute>} />
        <Route path={Url.kanban.root} element={<ProtectedRoute><KanbanPage /></ProtectedRoute>} />
        <Route path={Url.kanban.project} element={<ProtectedRoute><KanbanPage /></ProtectedRoute>} />
        <Route path="*" element={<NotFoundPage />} />
    </Routes>
)

export default RouteWrapper
