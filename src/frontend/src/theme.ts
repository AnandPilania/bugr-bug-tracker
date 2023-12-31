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
        },
        MuiDivider: {
            styleOverrides: {
                root: {
                    marginTop: "1rem",
                    marginBottom: "1rem"
                }
            }
        }
    },
    palette: {
        mode: "dark",
        primary: {
            main: '#FF69B4',
            contrastText: '#000000'
        }
    },
});

export default theme;
