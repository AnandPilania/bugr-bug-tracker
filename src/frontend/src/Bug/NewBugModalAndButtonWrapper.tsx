import NewBugFloatingButton from "./components/NewBugFloatingButton";
import NewBugModal from "./components/NewBugModal";
import {useState} from "react";

const NewBugModalAndButtonWrapper = () => {
    const [open, setOpen] = useState<boolean>(false)

    return <>
        <NewBugFloatingButton onClick={() => setOpen(true)} />
        <NewBugModal open={open} onClose={() => setOpen(false)} />
    </>
}

export default NewBugModalAndButtonWrapper