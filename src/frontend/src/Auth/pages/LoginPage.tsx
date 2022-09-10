import {
    Box,
    TextField,
    Typography,
    Link as MuiLink
} from "@mui/material";
import {useContext, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import useAuth from "../useAuth";
import FormButton from "../../Core/components/FormButton";
import URLs from "../../URLs";
import {ErrorPopupContext, ErrorPopupContextType} from "../../Core/contexts/ErrorPopupContext";

const LoginPage = () => {
    const [username, setUsername] = useState('')
    const [password, setPassword] = useState('')

    const {setError} = useContext<ErrorPopupContextType>(ErrorPopupContext)
    const navigateTo = useNavigate()
    const Auth = useAuth()

    const login = () => {
        setError('')

        Auth.login(
            username,
            password,
            () => {
                navigateTo(URLs.auth.profile)
            },
            (err) => {
                setError(err)
            })
    }

    return <>
        <Typography>Log in here to access the full Bug Trackr system</Typography>

        <Box>
            <TextField label="Username" margin="dense" type="text" value={username} onChange={e => setUsername(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Password" margin="dense" type="password" value={password} onChange={e => setPassword(e.target.value)} fullWidth variant="standard"></TextField>

            <FormButton onClick={login}>Log in</FormButton>
        </Box>

        <Typography>If you haven't set up a user, or have forgotten your details, <MuiLink component={Link} to={URLs.auth.register}>create a new one here</MuiLink>.</Typography>
    </>
}

export default LoginPage
