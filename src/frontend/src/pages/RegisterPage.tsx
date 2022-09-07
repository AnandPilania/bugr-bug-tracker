import {useState} from "react";
import {Alert, Box, Button, Snackbar, TextField, Typography} from "@mui/material";
import useApi from "../hooks/useApi";

const RegisterPage = () => {
    const [username, setUsername] = useState('')
    const [displayName, setDisplayName] = useState('')
    const [password, setPassword] = useState('')
    const [uniqueKey, setUniqueKey] = useState('')

    const [error, setError] = useState<String>('')
    const clearError = () => setError('')

    const handleSnackbarClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        clearError()
    }

    const Api = useApi()

    const createUser = () => {
        const user = {
            username,
            password,
            displayName
        }

        const apikey = uniqueKey

        Api.post(
            '/register',
            {...user, apikey},
            response => {
                clearError()
            },
            err => {
                setError(err.data ?? (err.status.toString() + ': ' + err.statusText))
            })
    }

    return <>
        <Typography>Create a new use here by completing the form below (you'll need the unique key given to you when you installed the app)</Typography>

        <Box>
            <TextField label="Username" margin="dense" type="text" value={username} onChange={e => setUsername(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Display Name" margin="dense" type="text" value={displayName} onChange={e => setDisplayName(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Password" margin="dense" type="password" value={password} onChange={e => setPassword(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Unique Key" margin="dense" type="text" value={uniqueKey} onChange={e => setUniqueKey(e.target.value)} fullWidth variant="standard"></TextField>

            <Button variant="contained" onClick={createUser}>Create user</Button>
        </Box>

        <Typography>If you don't know your unique key, I cannot help you.</Typography>

        {error && <Snackbar anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }} open={!!error} autoHideDuration={5000} onClose={handleSnackbarClose}><Alert severity="error" variant="filled">{error}</Alert></Snackbar>}
    </>
}

export default RegisterPage
