import React from 'react';
import {StrictMode} from "react";
import {createRoot} from 'react-dom/client';
import {CssBaseline, ThemeProvider} from "@mui/material";
import App from './Core/App';
import '@fontsource/montserrat/300.css';
import '@fontsource/montserrat/400.css';
import '@fontsource/montserrat/500.css';
import '@fontsource/montserrat/600.css';
import '@fontsource/montserrat/700.css';
import theme from "./theme";

const root = createRoot(document.getElementById('root') as HTMLElement);
root.render(
    <StrictMode>
        <ThemeProvider theme={theme}>
            <CssBaseline enableColorScheme />
            <App />
        </ThemeProvider>
    </StrictMode>
);
