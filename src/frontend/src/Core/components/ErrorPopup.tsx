import {Alert, Snackbar} from "@mui/material";
import {useState, SyntheticEvent, useEffect} from "react";

const ErrorPopup = ({error}) => {
    const [open, setOpen] = useState<boolean>(false)

    const handleSnackbarClose = (event: SyntheticEvent, reason: string) => {
        // This stops the popup from disappearing if the user clicks somewhere on the screen
        if (reason === 'clickaway') {
            return;
        }
        setOpen(false)
    }

    useEffect(() => {
        setOpen(error.length > 0)
    }, [error])

    return (
        <Snackbar anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }} open={open} autoHideDuration={5000} onClose={handleSnackbarClose}>
            <Alert severity="error" variant="filled">
                {error}
            </Alert>
        </Snackbar>
    )
}

export default ErrorPopup
