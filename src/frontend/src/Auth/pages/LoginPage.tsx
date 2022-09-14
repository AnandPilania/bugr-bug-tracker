import {
    TextField,
    Typography,
    Link as MuiLink
} from "@mui/material";
import {useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import useAuth from "../useAuth";
import FormButton from "../../Core/components/FormButton";
import Url from "../../Url";
import {useSnackbar} from "notistack";
import Form from "../../Core/components/Form";

const LoginPage = () => {
    const [username, setUsername] = useState('')
    const [password, setPassword] = useState('')

    const navigateTo = useNavigate()
    const Auth = useAuth()

    const {enqueueSnackbar: setError} = useSnackbar()

    const login = () => {
        if (username.length === 0 || password.length === 0) {
            setError('Username and Password must be given', {variant:"error"})
            return
        }

        Auth.login(
            username,
            password,
            () => {
                setError('Log in successful!', {variant:"success"})
                navigateTo(Url.root)
            },
            (err) => {
                setError(err, {variant:"error"})
            })
    }

    return <>
        <Typography>Log in here to access the full Bug Trackr system</Typography>

        <Form>
            <TextField label="Username" margin="dense" type="text" value={username} onChange={e => setUsername(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Password" margin="dense" type="password" value={password} onChange={e => setPassword(e.target.value)} fullWidth variant="standard"></TextField>

            <FormButton onClick={login}>Log in</FormButton>
        </Form>

        <Typography>If you haven't set up a user, or have forgotten your details, <MuiLink component={Link} to={Url.auth.register}>create a new one here</MuiLink>.</Typography>
    </>
}

export default LoginPage
