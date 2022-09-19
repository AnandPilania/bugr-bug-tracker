import {Accordion, AccordionDetails, AccordionSummary, Button, List, ListItem, Typography} from "@mui/material";
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
                <List>
                    {statuses.map((status, key) => (
                        <ListItem key={`s-${key}`}>{status.title}</ListItem>
                    ))}
                </List>
                <NewStatusModalForm open={newStatusModalOpen} setOpen={setNewStatusModalOpen} onSaveNewStatus={loadStatuses}
                                    projectTitle={project.title} />
            </AccordionDetails>
        </Accordion>
    )
}

export default ProjectStatusSection
