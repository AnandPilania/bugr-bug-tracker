import {useState} from "react";
import {Alert, Box, Snackbar, Typography} from "@mui/material";
import FormButton from "../components/FormButton";
import FormInput from "../components/FormInput";
import useAuth from "../hooks/useAuth";

const RegisterPage = () => {
    const [username, setUsername] = useState<string>('')
    const [displayName, setDisplayName] = useState<string>('')
    const [password, setPassword] = useState<string>('')
    const [uniqueKey, setUniqueKey] = useState<string>('')

    const [error, setError] = useState<string|null>(null)

    const Auth = useAuth()

    // @todo extract this to a different component
    const handleSnackbarClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        setError(null)
    }

    const createUser = () => {
        setError(null)

        Auth.register(
            username,
            password,
            displayName,
            uniqueKey,
            () => {
                alert('User created!')
            },
            (err) => {
                setError(err)
            }
        )
    }

    return <>
        <Typography>Create a new use here by completing the form below (you'll need the unique key given to you when you installed the app)</Typography>

        <Box>
            <FormInput label="Username" type="text" value={username} onChange={e => setUsername(e.target.value)} />
            <FormInput label="Display Name" value={displayName} onChange={e => setDisplayName(e.target.value)} type="text" />
            <FormInput label="Password" value={password} onChange={e => setPassword(e.target.value)} type="password" />
            <FormInput label="Unique Key" value={uniqueKey} onChange={e => setUniqueKey(e.target.value)} type="text" />

            <FormButton onClick={createUser}>Create user</FormButton>
        </Box>

        <Typography>If you don't know your unique key, I cannot help you.</Typography>

        {error && <Snackbar anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }} open={!!error} autoHideDuration={5000} onClose={handleSnackbarClose}><Alert severity="error" variant="filled">{error}</Alert></Snackbar>}
    </>
}

export default RegisterPage
