import {Button} from "@mui/material";
import FormInput from "../../Core/components/FormInput";
import DialogForm from "../../Core/components/DialogForm";
import {useState} from "react";
import useRepository from "../../Core/hooks/useRepository";
import BugRepository from "../repository/BugRepository";
import {useSnackbar} from "notistack";

const NewBugModalForm = ({open, setOpen, onSaveNewBug, project}) => {
    const [projectName, setProjectName] = useState<string>(project)
    const [bugTitle, setBugTitle] = useState('')
    const [status, setStatus] = useState('')
    const bugRepository = useRepository(BugRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const closeModal = () => {
        setOpen(false)
    }

    const saveNewBug = () => {
        // @todo build dropdown with project names so we can send a project id instead of title
        bugRepository.create(
            bugTitle, projectName, status,
            response => {
                setError(response, {variant: "success"})
                onSaveNewBug()
            },
            err => setError(err, {variant:"error"})
        )
    }

    return (
        <DialogForm title="Create new Bug" open={open} onClose={closeModal} fullWidth="true" maxWidth="md"
                    actions={<><Button onClick={closeModal}>Cancel</Button><Button onClick={saveNewBug}>Save</Button></>}>
            <FormInput label="Project name" value={projectName} onChange={e => setProjectName(e.target.value)} type="text" disabled />
            <FormInput label="Bug title" value={bugTitle} onChange={e => setBugTitle(e.target.value)} type="text" />
            <FormInput label="Initial Status" value={status} onChange={e => setStatus(e.target.value)} type="text" />
        </DialogForm>
    )
}

export default NewBugModalForm