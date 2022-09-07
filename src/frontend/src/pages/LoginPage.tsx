import {
    Box,
    TextField,
    Typography,
    Link as MuiLink
} from "@mui/material";
import {useState} from "react";
import {Link} from "react-router-dom";

const LoginPage = () => {
    const [username, setUsername] = useState('')
    const [password, setPassword] = useState('')

    return <>
        <Typography>Log in here to access the full Bug Trackr system</Typography>

        <Box>
            <TextField label="Username" margin="dense" type="text" value={username} onChange={e => setUsername(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Password" margin="dense" type="password" value={password} onChange={e => setPassword(e.target.value)} fullWidth variant="standard"></TextField>
        </Box>

        <Typography>If you haven't set up a user, or have forgotten your details, <MuiLink  component={Link} to="/register">create a new one here</MuiLink>.</Typography>
    </>
}

export default LoginPage
