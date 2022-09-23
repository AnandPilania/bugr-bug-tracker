import {useEffect, useState} from "react";
import {CircularProgress, MenuItem} from "@mui/material";
import ProjectRepository, {ProjectType} from "../repository/ProjectRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";
import FormSelect from "../../Core/components/FormSelect";

type ProjectSelectType = {
    onChange?: Function,
    defaultValue?: string
}

const ProjectSelect = ({defaultValue = '', onChange = () => {}}: ProjectSelectType) => {
    const [projectId, setProjectId] = useState<string>('')
    const [projects, setProjects] = useState<Array<ProjectType>>([])
    const projectRepository = useRepository(ProjectRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    useEffect(() => {
        setProjectId(defaultValue)
    }, [defaultValue])

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

    if (projects.length === 0) {
        return <CircularProgress />
    }

    return (
        <FormSelect onChange={_setProjectId} value={projectId} label="Project">
            <MenuItem value="" key="project-x" disabled>Select a project...</MenuItem>
            {projects.map(
                (project, key) =>
                    <MenuItem value={project.id} key={`project-${key}`}>{project.title}</MenuItem>
            )}
        </FormSelect>
    )
}

export default ProjectSelect