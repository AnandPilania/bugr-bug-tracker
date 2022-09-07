import {Container, ThemeProvider} from "@mui/material";
import theme from './theme'
import Navbar from "./components/Navbar";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import IndexPage from "./pages/IndexPage";
import LoginPage from "./pages/LoginPage";
import LogoutPage from "./pages/LogoutPage";
import NotFoundPage from "./pages/NotFoundPage";
import RegisterPage from "./pages/RegisterPage";

const App = () => (
    <ThemeProvider theme={theme}>
        <BrowserRouter>
           <Navbar />
            <Container maxWidth="xl" sx={{paddingTop:3}}>
                <Routes>
                    <Route path="/" element={<IndexPage />} />
                    <Route path="/login" element={<LoginPage />} />
                    <Route path="/register" element={<RegisterPage />} />
                    <Route path="/logout" element={<LogoutPage /> } />
                    <Route path="*" element={<NotFoundPage />} />
                </Routes>
            </Container>
        </BrowserRouter>
    </ThemeProvider>
)

export default App;