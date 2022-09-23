import {Container} from "@mui/material";
import {BrowserRouter} from "react-router-dom";
import Navbar from "./components/Navbar";
import ProviderWrapper from "./ProviderWrapper";
import RouteWrapper from "./RouteWrapper";
import NewBugFloatingButton from "../Bug/components/NewBugFloatingButton";
import NewBugModal from "../Bug/components/NewBugModal";

const App = () => {
    return (
        <ProviderWrapper>
            <BrowserRouter>
                <Navbar />
                <Container maxWidth="xl" sx={{paddingTop: 3}}>
                    <RouteWrapper />
                </Container>

                <NewBugFloatingButton />
                <NewBugModal />
            </BrowserRouter>
        </ProviderWrapper>
    )
}

export default App