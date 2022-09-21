import {Container} from "@mui/material";
import {BrowserRouter} from "react-router-dom";
import Navbar from "./components/Navbar";
import ProviderWrapper from "./ProviderWrapper";
import RouteWrapper from "./RouteWrapper";
import NewBugModalAndButtonWrapper from "../Bug/NewBugModalAndButtonWrapper";

const App = () => {
    return (
        <ProviderWrapper>
            <BrowserRouter>
                <Navbar />
                <Container maxWidth="xl" sx={{paddingTop: 3}}>
                    <RouteWrapper />
                </Container>

                <NewBugModalAndButtonWrapper />
            </BrowserRouter>
        </ProviderWrapper>
    )
}

export default App