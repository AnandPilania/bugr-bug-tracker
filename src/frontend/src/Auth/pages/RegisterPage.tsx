import {useState} from "react";
import {Divider, Typography} from "@mui/material";
import FormButton from "../../Core/components/FormButton";
import FormInput from "../../Core/components/FormInput";
import useAuth from "../useAuth";
import {useSnackbar} from "notistack";
import FormCheckbox from "../../Core/components/FormCheckbox";
import Form from "../../Core/components/Form";

const RegisterPage = () => {
    const [username, setUsername] = useState<string>('')
    const [displayName, setDisplayName] = useState<string>('')
    const [password, setPassword] = useState<string>('')
    const [uniqueKey, setUniqueKey] = useState<string>('')
    const [isAdmin, setIsAdmin] = useState<boolean>(false)

    const {enqueueSnackbar: setError} = useSnackbar()

    const Auth = useAuth()

    const createUser = () => {
        if (username.length === 0 || password.length === 0 || uniqueKey.length === 0) {
            setError('Username, Password and Unique Key are all required fields', {variant: "error"})
            return
        }

        if (displayName.length === 0) {
            setDisplayName(username)
        }

        Auth.register(
            username,
            password,
            displayName,
            isAdmin,
            uniqueKey,
            () => {
                setError('User created successfully', {variant: "success"})
                setUsername('')
                setPassword('')
                setDisplayName('')
                setIsAdmin(false)
                // @todo show some other confirmation message
            },
            (err) => {
                setError(err, {variant:"error"})
            }
        )
    }

    return <>
        <Typography>Create a new use here by completing the form below (you'll need the unique key given to you when you installed the app)</Typography>

        <Form>
            <FormInput label="Username" type="text" value={username} onChange={e => setUsername(e.target.value)} />
            <FormInput label="Display Name" value={displayName} onChange={e => setDisplayName(e.target.value)} type="text" helperText="Defaults to username if not given" />
            <FormInput label="Password" value={password} onChange={e => setPassword(e.target.value)} type="password" />

            <FormCheckbox label="Make this user an Admin User" checked={isAdmin} onChange={e => setIsAdmin(e.target.checked)} />

            <Divider />

            <FormInput label="Unique Key" value={uniqueKey} onChange={e => setUniqueKey(e.target.value)} type="text" />

            <FormButton onClick={createUser}>Create user</FormButton>
        </Form>

        <Typography>If you don't know your unique key, I cannot help you.</Typography>
    </>
}

export default RegisterPage
