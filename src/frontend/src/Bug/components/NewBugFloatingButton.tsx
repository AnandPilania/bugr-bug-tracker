import {Fab} from "@mui/material";
import {BugReportTwoTone} from "@mui/icons-material";
import {NewBugModalContext} from "../../Core/providers/NewBugModalProvider";
import {useContext} from "react";

const NewBugFloatingButton = () => {
    const {setOpen, setDefaults} = useContext(NewBugModalContext)

    const onClick = () => {
        setDefaults({
            projectId: '',
            statusId: '',
            title: '',
            description: ''
        })
        setOpen(true)
    }

    return (
        <Fab color="primary" onClick={onClick} sx={{position: "fixed", bottom: "1rem", right: "1rem"}}>
            <BugReportTwoTone fontSize="large"/>
        </Fab>
    )
}

export default NewBugFloatingButton
