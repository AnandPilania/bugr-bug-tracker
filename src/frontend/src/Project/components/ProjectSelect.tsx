import {useEffect, useState} from "react";
import {FormControl, InputLabel, MenuItem, Select} from "@mui/material";
import ProjectRepository, {ProjectType} from "../repository/ProjectRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";

type ProjectSelectType = {
    onChange?: Function
}

const ProjectSelect = ({onChange = () => {}}: ProjectSelectType) => {
    const [projectId, setProjectId] = useState<string>('')
    const [projects, setProjects] = useState<Array<ProjectType>>([])
    const projectRepository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        return projectRepository.getAll(
            projects => setProjects(projects),
            error => setError(error, {variant: "error"})
        )

        // eslint-disable-next-line
    }, [])

    const _setProjectId = e => {
        const projectId = e.target.value
        setProjectId(projectId)
        onChange(projectId)
    }

    return (
        <FormControl fullWidth>
            <InputLabel>Project</InputLabel>
            <Select value={projectId} label="Project" onChange={_setProjectId} variant="standard">
                <MenuItem value="" key="project-x" disabled>Select a project...</MenuItem>
                { projects.map(
                    (project, key) =>
                        <MenuItem value={project.id} key={`project-${key}`}>{project.title}</MenuItem>
                )}
            </Select>
        </FormControl>
    )
}

export default ProjectSelect