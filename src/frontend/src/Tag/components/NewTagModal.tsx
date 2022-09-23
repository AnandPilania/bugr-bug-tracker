import DialogForm from "../../Core/components/DialogForm";
import FormInput from "../../Core/components/FormInput";
import useRepository from "../../Core/hooks/useRepository";
import {Button} from "@mui/material";
import {useSnackbar} from "notistack";
import {ChangeEvent, useState} from "react";
import TagRepository from "../repository/TagRepository";
import {ProjectType} from "../../Project/repository/ProjectRepository";

type NewTagModalProps = {
    open: boolean,
    setOpen: Function,
    onSaveNewTag: Function,
    project: ProjectType
}

const NewTagModal = ({open, setOpen, onSaveNewTag, project}: NewTagModalProps) => {
    const [title, _setTitle] = useState('')
    const tagRepository = useRepository(TagRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const closeModal = () => {
        _setTitle('')
        setOpen(false)
    }

    const saveNewTag = () => {
        tagRepository.create(
            project.id, title,
            (response: string) => {
                setError(response, {variant: "success"})
                setOpen(false)
                onSaveNewTag()
            },
            (err: string) => setError(err, {variant:"error"})
        )
    }

    const setTitle = (e: ChangeEvent) => {
        // Trickery with Typescript type coercion to stop IDE errors
        const target = e.target as HTMLInputElement
        _setTitle(target.value)
    }

    return (
        <DialogForm title="Create new Tag" open={open} onClose={closeModal} fullWidth="true" maxWidth="md"
                    actions={<><Button onClick={closeModal}>Cancel</Button><Button onClick={saveNewTag}>Save</Button></>}>
            <FormInput label="Project name" value={project.title} type="text" disabled />
            <FormInput label="Tag name" value={title} onChange={setTitle} type="text" />
        </DialogForm>
    )
}

export default NewTagModal