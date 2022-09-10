import {useContext, useState} from "react";
import {Alert, Box, Snackbar, Typography} from "@mui/material";
import FormButton from "../../Core/components/FormButton";
import FormInput from "../../Core/components/FormInput";
import useAuth from "../useAuth";
import {ErrorPopupContext, ErrorPopupContextType} from "../../Core/contexts/ErrorPopupContext";

const RegisterPage = () => {
    const [username, setUsername] = useState<string>('')
    const [displayName, setDisplayName] = useState<string>('')
    const [password, setPassword] = useState<string>('')
    const [uniqueKey, setUniqueKey] = useState<string>('')

    const {setError} = useContext<ErrorPopupContextType>(ErrorPopupContext)

    const Auth = useAuth()

    const createUser = () => {
        setError('')

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
    </>
}

export default RegisterPage
