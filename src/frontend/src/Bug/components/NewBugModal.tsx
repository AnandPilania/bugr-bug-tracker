import {useContext, useEffect, useState} from "react";
import {Button, Dialog, DialogActions, DialogContent, DialogTitle} from "@mui/material";
import Form from "../../Core/components/Form";
import FormInput from "../../Core/components/FormInput";
import {Close, SaveAltOutlined} from "@mui/icons-material";
import ProjectSelect from "../../Project/components/ProjectSelect";
import StatusSelect from "../../Status/components/StatusSelect";
import {NewBugModalContext} from "../../Core/providers/NewBugModalProvider";
import useRepository from "../../Core/hooks/useRepository";
import BugRepository from "../repository/BugRepository";
import {useSnackbar} from "notistack";

export type NewBugStateType = {
    title: string,
    description: string,
    projectId: string,
    statusId: string,
}

const NewBugModal = () => {
    const {open, setOpen, defaults} = useContext(NewBugModalContext)
    const [state, setState] = useState<NewBugStateType>({...defaults})
    const bugRepository = useRepository(BugRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        setState({...defaults})
    }, [defaults])

    const updateData = (key, value) => {
        const newState = {
            ...state,
            [key]: value
        }

        setState(newState)
    }

    const onClose = () => {
        setOpen(false)
    }

    const saveNewBug = () => {
        bugRepository.create(
            state.title,
            state.description,
            state.projectId,
            state.statusId,
            message => {
                setError(message, {variant: "success"})
                onClose()
            },
            error => setError(error, {variant: "error"})
        )
    }

    if (!open) {
        return null
    }

    return (
        <Dialog fullScreen open={open} onClose={onClose}>
            <DialogTitle>CreateBug</DialogTitle>
            <DialogContent dividers>
                <Form>
                    <ProjectSelect defaultValue={state.projectId} onChange={projectId => updateData('projectId', projectId)} />
                    <FormInput label="Bug title" value={state.title} type="text" onChange={e => updateData('title', e.target.value)} />
                    <FormInput label="Description" value={state.description} type="text" multiline rows="7" onChange={e => updateData('description', e.target.value)} />
                    <StatusSelect onChange={statusId => updateData('statusId', statusId)} projectId={state.projectId} />
                </Form>
            </DialogContent>
            <DialogActions sx={{display:"flex", justifyContent:"space-between"}}>
                <Button onClick={onClose}><Close sx={{marginRight: "0.5rem"}} /> Cancel</Button>
                <Button onClick={saveNewBug}><SaveAltOutlined sx={{marginRight: "0.5rem"}}/> Save</Button>
            </DialogActions>
        </Dialog>
    )
}

export default NewBugModal
