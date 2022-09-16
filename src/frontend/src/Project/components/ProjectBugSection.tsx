import {
    Accordion,
    AccordionDetails,
    AccordionSummary,
    Button,
    Chip,
    Paper,
    Table,
    TableBody,
    TableCell, TableContainer,
    TableRow,
    Typography
} from "@mui/material";
import {BugReportOutlined, ExpandMoreOutlined} from "@mui/icons-material";
import NewBugModalForm from "../../Bug/components/NewBugModalForm";
import {useState} from "react";

const ProjectBugSection = ({project, doRefetch}) => {
    const [newBugModalOpen, setNewBugModalOpen] = useState(false)

    console.log('- ProjectBugSection')

    return (
        <Accordion>
            <AccordionSummary expandIcon={<ExpandMoreOutlined />}>
                <Typography>Bugs in this Project</Typography>
            </AccordionSummary>
            <AccordionDetails>
                <Typography><Button onClick={() => setNewBugModalOpen(true)}><BugReportOutlined/>Create new Bug</Button></Typography>
                <TableContainer component={Paper}>
                    <Table>
                        <TableBody>
                            {project.bugs.map((bug, key) => (
                                <TableRow key={`b-${key}`}>
                                    <TableCell>
                                        {bug.title} <Chip sx={{ml: "1rem"}} color="primary" label={bug.status_name}/>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
                <NewBugModalForm open={newBugModalOpen} setOpen={setNewBugModalOpen} onSaveNewBug={doRefetch}
                                 project={project.title}/>
            </AccordionDetails>
        </Accordion>
    )
}

export default ProjectBugSection
