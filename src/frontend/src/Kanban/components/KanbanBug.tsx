import {
    Card,
    CardActionArea,
    CardContent,
    Typography
} from "@mui/material";
import {BugType} from "../../Bug/repository/BugRepository";

type KanbanBugProps = {
    setBugId: Function,
    bug: BugType
}

const KanbanBug = ({setBugId, bug}: KanbanBugProps) => {
    return (
        <Card variant="outlined" sx={{marginY: "0.5rem"}}>
            <CardActionArea onClick={() => setBugId(bug.id)}>
                <CardContent>
                    <Typography color="primary">{bug.title}</Typography>
                    <Typography>{bug.description}</Typography>
                    <Typography sx={{textAlign: "right"}}
                                color="text.secondary">{bug.assignee?.friendlyName ?? ''}</Typography>
                </CardContent>
            </CardActionArea>
        </Card>
    )
}

export default KanbanBug
