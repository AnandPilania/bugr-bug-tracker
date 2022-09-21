import {Fab} from "@mui/material";
import {BugReportTwoTone} from "@mui/icons-material";

type NewBugFloatingButtonProps = {
    onClick: Function
}

const NewBugFloatingButton = ({onClick}: NewBugFloatingButtonProps) => {

    return (
        <Fab color="secondary" onClick={onClick} sx={{position:"absolute", bottom:"1rem", right: "1rem"}}>
            <BugReportTwoTone fontSize="large" />
        </Fab>
    )
}

export default NewBugFloatingButton
