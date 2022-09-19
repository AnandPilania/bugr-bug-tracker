import DialogForm from "../../Core/components/DialogForm";
import FormInput from "../../Core/components/FormInput";
import StatusRepository from "../repository/StatusRepository";
import useRepository from "../../Core/hooks/useRepository";
import {Button} from "@mui/material";
import {useSnackbar} from "notistack";
import {ChangeEvent, useState} from "react";

type NewStatusModalFormProps = {
    open: boolean,
    setOpen: Function,
    onSaveNewStatus: Function,
    projectTitle: string
}

const NewStatusModalForm = ({open, setOpen, onSaveNewStatus, projectTitle}: NewStatusModalFormProps) => {
    const [status, _setStatus] = useState('')
    const statusRepository = useRepository(StatusRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const closeModal = () => {
        _setStatus('')
        setOpen(false)
    }

    const saveNewStatus = () => {
        // @todo build dropdown with project names so we can send a project id instead of title
        statusRepository.create(
            status, projectTitle,
            (response: string) => {
                setError(response, {variant: "success"})
                setOpen(false)
                onSaveNewStatus()
            },
            (err: string) => setError(err, {variant:"error"})
        )
    }

    const setStatus = (e: ChangeEvent) => {
        // Trickery with Typescript type coercion to stop IDE errors
        const target = e.target as HTMLInputElement
        _setStatus(target.value)
    }

    return (
        <DialogForm title="Create new Status" open={open} onClose={closeModal} fullWidth="true" maxWidth="md"
                    actions={<><Button onClick={closeModal}>Cancel</Button><Button onClick={saveNewStatus}>Save</Button></>}>
            <FormInput label="Project name" value={projectTitle} type="text" disabled />
            <FormInput label="Status name" value={status} onChange={setStatus} type="text" />
        </DialogForm>
    )
}

export default NewStatusModalForm