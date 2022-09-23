import {
    Accordion, AccordionDetails, AccordionSummary,
    Button, List, ListItem, Typography
} from "@mui/material";
import {ExpandMoreOutlined, LabelTwoTone} from "@mui/icons-material";
import {useEffect, useState} from "react";
import {ProjectType} from "../repository/ProjectRepository";
import useRepository from "../../Core/hooks/useRepository";
import {useSnackbar} from "notistack";
import TagRepository, {TagType} from "../../Tag/repository/TagRepository";
import NewTagModal from "../../Tag/components/NewTagModal";

type ProjectTagSectionProps = {
    project: ProjectType
}

const ProjectTagSection = ({project}: ProjectTagSectionProps) => {
    const [newTagModalOpen, setNewTagModalOpen] = useState(false)
    const [tags, setTags] = useState<Array<TagType>>([])
    const tagRepository = useRepository(TagRepository)
    const {enqueueSnackbar: setError} = useSnackbar()

    const loadTags = () => {
        return tagRepository.getByProject(
            project.id,
            (tags: Array<TagType>) => setTags(
                tags.sort((a,b) => (a.title.localeCompare(b.title)))
            ),
            (error: string) => setError(error, {variant: "error"})
        )
    }

    useEffect(() => {
        return loadTags()
        // eslint-disable-next-line
    }, [project])

    return (
        <Accordion>
            <AccordionSummary expandIcon={<ExpandMoreOutlined />}>
                <Typography>Project Tags</Typography>
            </AccordionSummary>
            <AccordionDetails>
                <Typography>
                    <Button onClick={e => setNewTagModalOpen(true)}>
                        <LabelTwoTone sx={{marginRight: "0.5rem"}} />
                        Add new Tag
                    </Button>
                </Typography>
                <List>
                    {tags.map((tag,key) => <ListItem key={`t-${key}`}>{tag.title}</ListItem>)}
                </List>
                <NewTagModal open={newTagModalOpen} setOpen={setNewTagModalOpen} onSaveNewTag={loadTags} project={project} />
            </AccordionDetails>
        </Accordion>
    )
}

export default ProjectTagSection
