import {Dialog, DialogActions, DialogContent, DialogTitle} from "@mui/material";

const DialogForm = ({children, title, actions, ...props}) => {
    // @todo sometimes props.fullWidth is a STRING "true" when it should be a BOOLEAN
    if (typeof props.fullWidth === 'string') {
        props.fullWidth = props.fullWidth.toLowerCase() === 'true'
    }

    return (
        <Dialog {...props}>
            <DialogTitle>{title}</DialogTitle>
            <DialogContent>
                {children}
            </DialogContent>
            {actions && <DialogActions>{actions}</DialogActions>}
        </Dialog>
    )
}

export default DialogForm