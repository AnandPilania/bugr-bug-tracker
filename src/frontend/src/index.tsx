import {StrictMode} from "react";
import {createRoot} from 'react-dom/client';
import App from './App';
import {CssBaseline} from "@mui/material";
import '@fontsource/montserrat/300.css';
import '@fontsource/montserrat/400.css';
import '@fontsource/montserrat/500.css';
import '@fontsource/montserrat/600.css';
import '@fontsource/montserrat/700.css';

const root = createRoot(document.getElementById('root') as HTMLElement);
root.render(
    <StrictMode>
        <CssBaseline />
        <App />
    </StrictMode>
);
