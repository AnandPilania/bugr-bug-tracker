import {Button} from "@mui/material";
import FormInput from "../../Core/components/FormInput";
import DialogForm from "../../Core/components/DialogForm";
import {useState} from "react";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";
import StatusRepository from "../repository/StatusRepository";

const NewStatusModalForm = ({open, setOpen, onSaveNewStatus, project}) => {
    const [status, setStatus] = useState('')
    const statusRepository = useRepository(StatusRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const closeModal = () => {
        setOpen(false)
    }

    const saveNewStatus = () => {
        // @todo build dropdown with project names so we can send a project id instead of title
        statusRepository.create(
            status, project,
            response => {
                setError(response, {variant: "success"})
                onSaveNewStatus()
            },
            err => setError(err, {variant:"error"})
        )
    }

    return (
        <DialogForm title="Create new Status" open={open} onClose={closeModal} fullWidth="true" maxWidth="md"
                    actions={<><Button onClick={closeModal}>Cancel</Button><Button onClick={saveNewStatus}>Save</Button></>}>
            <FormInput label="Project name" value={project} type="text" disabled />
            <FormInput label="Status name" value={status} onChange={e => setStatus(e.target.value)} type="text" />
        </DialogForm>
    )
}

export default NewStatusModalForm