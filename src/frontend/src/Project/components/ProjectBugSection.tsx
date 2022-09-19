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
import {useEffect, useState} from "react";
import {ProjectType} from "../repository/ProjectRepository";
import BugRepository, {BugType} from "../../Bug/repository/BugRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";

type ProjectBugSectionProps = {
    project: ProjectType
}

const ProjectBugSection = ({project}: ProjectBugSectionProps) => {
    const [newBugModalOpen, setNewBugModalOpen] = useState(false)
    const [bugs, setBugs] = useState<Array<BugType>>([])
    const bugRepository = useRepository(BugRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const loadBugs = () => {
        return bugRepository.getByProject(
            project.id,
            (bugs: Array<BugType>) => setBugs(bugs),
            (error: string) => setError(error)
        )
    }

    useEffect(() => {
        return loadBugs()
        // eslint-disable-next-line
    }, [project])

    return (
        <Accordion>
            <AccordionSummary expandIcon={<ExpandMoreOutlined />}>
                <Typography>Bugs in this Project</Typography>
            </AccordionSummary>
            <AccordionDetails>
                <Typography>
                        <Button onClick={() => setNewBugModalOpen(true)}>
                        <BugReportOutlined sx={{marginRight: "0.5rem"}} />
                        Create new Bug
                    </Button>
                </Typography>
                <TableContainer component={Paper}>
                    <Table>
                        <TableBody>
                            {bugs.map((bug, key) => (
                                <TableRow key={`b-${key}`}>
                                    <TableCell>
                                        {bug.title}
                                    </TableCell>
                                    <TableCell align="right">
                                        <Chip sx={{ml: "1rem"}} color="primary" label={bug.status.title}/>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
                <NewBugModalForm open={newBugModalOpen} setOpen={setNewBugModalOpen} onSaveNewBug={loadBugs}
                                 project={project.title} />
            </AccordionDetails>
        </Accordion>
    )
}

export default ProjectBugSection
