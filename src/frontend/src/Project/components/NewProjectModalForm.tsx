import {Button} from "@mui/material";
import FormInput from "../../Core/components/FormInput";
import DialogForm from "../../Core/components/DialogForm";
import {useState} from "react";
import {useSnackbar} from "notistack";
import useRepository from "../../Core/hooks/useRepository";
import ProjectRepository from "../repository/ProjectRepository";

const NewProjectModalForm = ({open, setOpen, onSaveNewProject}) => {
    const repository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()
    const [projectName, setProjectName] = useState('')

    const closeModal = () => setOpen(false)
    const saveNewProject = () => {
        repository.create(
            projectName,
            () => {
                closeModal()
                onSaveNewProject()
            },
            err => setError(err, {variant:"error"})
        )
    }

    return (
        <DialogForm title="Create new Project" open={open} onClose={closeModal} fullWidth="true" maxWidth="md"
                    actions={<><Button onClick={closeModal}>Cancel</Button><Button onClick={saveNewProject}>Save</Button></>}>
            <FormInput label="Project name" value={projectName} onChange={e => setProjectName(e.target.value)} type="text" helperText="" />
        </DialogForm>
    )
}

export default NewProjectModalForm
