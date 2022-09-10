import {Button} from "@mui/material";

const FormButton = ({children, onClick}) => (
    <Button onClick={onClick} variant="contained" style={{marginTop:"1rem", marginBottom:"1rem"}}>{children}</Button>
)

export default FormButton
