import {useContext, useState} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import {Divider, TextField, Typography} from "@mui/material";
import {useNavigate} from "react-router-dom";
import FormButton from "../../Core/components/FormButton";
import Form from "../../Core/components/Form";
import URLs from "../../URLs";
import useApi from "../../Api/useApi";
import {useSnackbar} from "notistack";

const UserProfilePage = () => {
    const [newPassword, setNewPassword] = useState<string>('')
    const [newPasswordConfirm, setNewPasswordConfirm] = useState<string>('')
    const {user} = useContext<AuthContextType>(AuthContext)
    const api = useApi()
    const {enqueueSnackbar: setError} = useSnackbar()

    const changePassword = () => {
        if (newPassword !== newPasswordConfirm) {
            setError('Passwords entered do not match', {variant: "error"})
            return
        }

        api.post(
            URLs.api.changePassword,
            { password: newPassword },
            response => {
                if (!response.data.result) {
                    setError("Unexpected data returned from the server")
                    return
                }

                setError('Password changed!', {variant: "success"})
            },
            err => setError(err.data, {variant: "error"})
        )
    }

    return <>
        <Typography>Username: {user.username}</Typography>
        <Typography>Display name: {user.displayName}</Typography>
        <Typography>You are {user.isAdmin ? "an Administrator" : "a Normal user"}</Typography>

        <Divider />

        <Typography>Change your password</Typography>
        <Form>
            <TextField label="New password" margin="dense" type="password" value={newPassword} onChange={e => setNewPassword(e.target.value)} fullWidth variant="standard"></TextField>
            <TextField label="Confirm new password" margin="dense" type="password" value={newPasswordConfirm} onChange={e => setNewPasswordConfirm(e.target.value)} fullWidth variant="standard"></TextField>

            <FormButton onClick={changePassword}>Change my password</FormButton>
        </Form>
    </>
}

export default UserProfilePage
