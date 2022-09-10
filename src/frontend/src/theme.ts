import { createTheme } from '@mui/material/styles';

const theme = createTheme({
    typography: {
        fontFamily: 'Montserrat',
        fontWeightRegular: 400
    },
    components: {
        MuiLink: {
            styleOverrides: {
                root: {
                    fontWeight: 600
                }
            }
        }
    },
    palette: {
        mode: "dark",
        primary: {
            main: '#FF69B4',
        }
    },
});

export default theme;
