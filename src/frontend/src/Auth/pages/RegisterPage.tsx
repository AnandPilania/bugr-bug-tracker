import {useState} from "react";
import {Typography} from "@mui/material";
import FormButton from "../../Core/components/FormButton";
import FormInput from "../../Core/components/FormInput";
import useAuth from "../useAuth";
import {useSnackbar} from "notistack";
import FormCheckbox from "../../Core/components/FormCheckbox";
import Form from "../../Core/components/Form";

const RegisterPage = () => {
    const [username, setUsername] = useState<string>('')
    const [friendlyName, setFriendlyName] = useState<string>('')
    const [password, setPassword] = useState<string>('')
    const [isAdmin, setIsAdmin] = useState<boolean>(false)

    const {enqueueSnackbar: setError} = useSnackbar()

    const Auth = useAuth()

    const createUser = () => {
        if (username.length === 0 || password.length === 0) {
            setError('Username and Password are required fields', {variant: "error"})
            return
        }

        if (friendlyName.length === 0) {
            setFriendlyName(username)
        }

        Auth.register(
            username,
            password,
            friendlyName,
            isAdmin,
            () => {
                setError('User created successfully', {variant: "success"})
                setUsername('')
                setPassword('')
                setFriendlyName('')
                setIsAdmin(false)
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
            <FormInput label="Display Name" value={friendlyName} onChange={e => setFriendlyName(e.target.value)} type="text" helperText="Defaults to username if not given" />
            <FormInput label="Password" value={password} onChange={e => setPassword(e.target.value)} type="password" />

            <FormCheckbox label="Make this user an Admin User" checked={isAdmin} onChange={e => setIsAdmin(e.target.checked)} />

            <FormButton onClick={createUser}>Create user</FormButton>
        </Form>
    </>
}

export default RegisterPage
