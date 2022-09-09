import {
    Box,
    TextField,
    Typography,
    Link as MuiLink, Button
} from "@mui/material";
import {useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import useAuth from "../hooks/useAuth";

const LoginPage = () => {
    const [username, setUsername] = useState('')
    const [password, setPassword] = useState('')

    const navigateTo = useNavigate()

    const Auth = useAuth()

    const login = () => {
        Auth.login(username, password, () => {
            navigateTo('/')
        })
    }

    return <>
        <Typography>Log in here to access the full Bug Trackr system</Typography>

        <Box>
            <TextField label="Username" margin="dense" type="text" value={username} onChange={e => setUsername(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Password" margin="dense" type="password" value={password} onChange={e => setPassword(e.target.value)} fullWidth variant="standard"></TextField>

            <Button variant="contained" onClick={login}>Log in</Button>
        </Box>

        <Typography>If you haven't set up a user, or have forgotten your details, <MuiLink component={Link} to="/register">create a new one here</MuiLink>.</Typography>
    </>
}

export default LoginPage
