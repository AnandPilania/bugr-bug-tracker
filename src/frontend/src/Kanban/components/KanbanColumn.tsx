import {BugType} from "../../Bug/repository/BugRepository";
import KanbanBug from "./KanbanBug";
import {TableCell} from "@mui/material";

type KanbanColumnProps = {
    statusId: number,
    bugs: Array<BugType>,
    setBugId: Function
}

const KanbanColumn = ({statusId, bugs, setBugId}: KanbanColumnProps) => (
    <TableCell sx={{verticalAlign: "top"}}>
        {bugs.filter(
            (bug: BugType) => bug.status.id === statusId
        ).map((bug: BugType, key: number) =>
            <KanbanBug key={`b-${key}`} bug={bug} setBugId={setBugId}/>
        )}
    </TableCell>
)

export default KanbanColumn
