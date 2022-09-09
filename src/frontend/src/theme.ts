import { red } from '@mui/material/colors';
import { createTheme } from '@mui/material/styles';

const theme = createTheme({
    typography: {
        fontFamily: 'Montserrat'
    },
    palette: {
        primary: {
            main: '#4169E1',
        },
        secondary: {
            main: '#008080',
        },
        error: {
            main: red.A400,
        },
    },
});

export default theme;