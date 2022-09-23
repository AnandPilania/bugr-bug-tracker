import {
    Accordion, AccordionDetails, AccordionSummary,
    Button, Checkbox, Paper,
    Table, TableBody, TableCell,
    TableContainer, TableHead, TableRow,
    Typography
} from "@mui/material";
import {ExpandMoreOutlined, ListAltTwoTone} from "@mui/icons-material";
import NewStatusModalForm from "../../Status/components/NewStatusModalForm";
import {useEffect, useState} from "react";
import {ProjectType} from "../repository/ProjectRepository";
import StatusRepository, {StatusType} from "../../Status/repository/StatusRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";

type ProjectStatusSectionProps = {
    project: ProjectType
}

const ProjectStatusSection = ({project}: ProjectStatusSectionProps) => {
    const [newStatusModalOpen, setNewStatusModalOpen] = useState(false)
    const [statuses, setStatuses] = useState<Array<StatusType>>([])
    const statusRepository = useRepository(StatusRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const loadStatuses = () => {
        return statusRepository.getByProject(
            project.id,
            (statuses: Array<StatusType>) => setStatuses(statuses),
            (error: string) => setError(error)
        )
    }

    useEffect(() => {
        return loadStatuses()
        // eslint-disable-next-line
    }, [project])

    const changeOnKanbanStatus = (statusId, value) => {
        statusRepository.changeOnKanban(
            statusId, value !== 'on',
            response => {
                setError(response, {variant: "success"})
                loadStatuses()
            },
            error => setError(error, {variant: "error"})
        )
    }

    return (
        <Accordion>
            <AccordionSummary expandIcon={<ExpandMoreOutlined />}>
                <Typography>Project Statuses</Typography>
            </AccordionSummary>
            <AccordionDetails>
                <Typography>
                    <Button onClick={e => setNewStatusModalOpen(true)}>
                        <ListAltTwoTone sx={{marginRight: "0.5rem"}} />
                        Add new Status
                    </Button>
                </Typography>
                <TableContainer component={Paper}>
                    <Table size="small">
                        <TableHead>
                            <TableRow>
                                <TableCell>Title</TableCell>
                                <TableCell sx={{width:"10rem"}}>Show on Kanban</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {statuses.map((status: StatusType, key: number) => (
                                <TableRow key={`s-${key}`}>
                                    <TableCell>{status.title}</TableCell>
                                    <TableCell><Checkbox checked={status.onKanban} onChange={e => changeOnKanbanStatus(status.id, e.currentTarget.value)} /></TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
                <NewStatusModalForm open={newStatusModalOpen} setOpen={setNewStatusModalOpen} onSaveNewStatus={loadStatuses}
                                    projectTitle={project.title} />
            </AccordionDetails>
        </Accordion>
    )
}

export default ProjectStatusSection
