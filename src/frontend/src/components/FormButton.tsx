import {Button} from "@mui/material";

const FormButton = (props) => (
    <Button {...props} style={{marginTop:"1rem", marginBottom:"1rem"}}>{props.children}</Button>
)

export default FormButton
