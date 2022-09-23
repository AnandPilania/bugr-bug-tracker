import {useEffect, useState} from "react";
import {MenuItem} from "@mui/material";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";
import StatusRepository, {StatusType} from "../repository/StatusRepository";
import FormSelect from "../../Core/components/FormSelect";

type StatusSelectType = {
    onChange?: Function
}

const StatusSelect = ({projectId, onChange = () => {}}: StatusSelectType) => {
    const [statusId, setStatusId] = useState<string>('')
    const [statuses, setStatuses] = useState<Array<StatusType>>([])
    const statusRepository = useRepository(StatusRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        if (projectId !== '') {
            return statusRepository.getByProject(
                projectId,
                statuses => setStatuses(statuses),
                error => setError(error, {variant: "error"})
            )
        }

        // eslint-disable-next-line
    }, [projectId])

    const _setStatusId = e => {
        const statusId = e.target.value
        setStatusId(statusId)
        onChange(statusId)
    }

    const statusList = projectId === ''
        ? [<MenuItem value="" key="status-x" disabled>Select a Project first to see its Statuses</MenuItem>]
        : [
            <MenuItem value="" key="status-x" disabled>Select a status...</MenuItem>,
            ...statuses.map(
                (status, key) =>
                    <MenuItem value={status.id} key={`status-${key}`}>{status.title}</MenuItem>
            )
        ]

    return (
        <FormSelect onChange={_setStatusId} value={statusId} label="Status">
            {statusList}
        </FormSelect>
    )
}

export default StatusSelect
