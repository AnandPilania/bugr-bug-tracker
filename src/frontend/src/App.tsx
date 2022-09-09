import {Container, ThemeProvider} from "@mui/material";
import theme from './theme'
import Navbar from "./components/Navbar";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import {AuthContext} from './contexts/AuthContext';
import IndexPage from "./pages/IndexPage";
import LoginPage from "./pages/LoginPage";
import LogoutPage from "./pages/LogoutPage";
import NotFoundPage from "./pages/NotFoundPage";
import RegisterPage from "./pages/RegisterPage";
import {useState} from "react";

const App = () => {
    const [user,setUser] = useState(null)

    return (
        <ThemeProvider theme={theme}>
            <AuthContext.Provider value={{user, setUser}}>
                <BrowserRouter>
                    <Navbar />
                    <Container maxWidth="xl" sx={{paddingTop: 3}}>
                        <Routes>
                            <Route path="/" element={<IndexPage/>}/>
                            <Route path="/login" element={<LoginPage/>}/>
                            <Route path="/register" element={<RegisterPage/>}/>
                            <Route path="/logout" element={<LogoutPage/>}/>
                            <Route path="*" element={<NotFoundPage/>}/>
                        </Routes>
                    </Container>
                </BrowserRouter>
            </AuthContext.Provider>
        </ThemeProvider>
    )
}

export default App