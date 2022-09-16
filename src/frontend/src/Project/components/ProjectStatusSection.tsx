import {Accordion, AccordionDetails, AccordionSummary, Button, List, ListItem, Typography} from "@mui/material";
import {ExpandMoreOutlined, ListAltTwoTone} from "@mui/icons-material";
import NewStatusModalForm from "../../Status/components/NewStatusModalForm";
import {useState} from "react";

const ProjectStatusSection = ({project, doRefetch}) => {
    const [newStatusModalOpen, setNewStatusModalOpen] = useState(false)

    return (
        <Accordion>
            <AccordionSummary expandIcon={<ExpandMoreOutlined />}>
                <Typography>Project Statuses</Typography>
            </AccordionSummary>
            <AccordionDetails>
                <Typography><Button onClick={e => setNewStatusModalOpen(true)}><ListAltTwoTone/>Add new
                    Status</Button></Typography>
                <List>
                    {project.statuses.map((status, key) => (
                        <ListItem key={`s-${key}`}>{status.title}</ListItem>
                    ))}
                </List>
                <NewStatusModalForm open={newStatusModalOpen} setOpen={setNewStatusModalOpen} onSaveNewStatus={doRefetch}
                                    project={project.title}/>
            </AccordionDetails>
        </Accordion>
    )
}

export default ProjectStatusSection
