import {useContext, useState} from "react";
import AuthContext from "../../Auth/AuthContext";
import {Divider, Typography} from "@mui/material";
import FormButton from "../../Core/components/FormButton";
import Form from "../../Core/components/Form";
import Url from "../../Url";
import useApi from "../../Api/useApi";
import {useSnackbar} from "notistack";
import FormInput from "../../Core/components/FormInput";

const UserProfilePage = () => {
    const [newPassword, setNewPassword] = useState<string>('')
    const [newPasswordConfirm, setNewPasswordConfirm] = useState<string>('')
    const {user} = useContext(AuthContext)
    const api = useApi()
    const {enqueueSnackbar: setError} = useSnackbar()

    const changePassword = () => {
        if (newPassword === '') {
            setError('Be sure to enter a new password before trying to change it!', {variant: "error"})
            return
        }

        if (newPassword !== newPasswordConfirm) {
            setError('Passwords entered do not match', {variant: "error"})
            return
        }

        api.post(
            Url.api.changePassword,
            { password: newPassword },
            response => {
                if (!response.data.result) {
                    setError("Unexpected data returned from the server")
                    return
                }

                setError('Password changed!', {variant: "success"})
                setNewPassword('')
                setNewPasswordConfirm('')
            },
            err => setError(err.data, {variant: "error"})
        )
    }

    return <>
        <Typography>Username: {user.username}</Typography>
        <Typography>Display name: {user.friendlyName}</Typography>
        <Typography>You are {user.isAdmin ? "an Administrator" : "a Normal user"}</Typography>

        <Divider />

        <Typography>Change your password</Typography>
        <Form>
            <FormInput label="New password" value={newPassword} type="password" onChange={e => setNewPassword(e.target.value)} />
            <FormInput label="Confirm new password" value={newPasswordConfirm} type="password" onChange={e => setNewPasswordConfirm(e.target.value)} />

            <FormButton onClick={changePassword}>Change my password</FormButton>
        </Form>
    </>
}

export default UserProfilePage
