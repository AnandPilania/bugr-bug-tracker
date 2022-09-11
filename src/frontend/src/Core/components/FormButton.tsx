import {Button} from "@mui/material";

type FormButtonProps = {
    children: any,
    onClick: Function
}

const FormButton = ({children, onClick}: FormButtonProps) => (
    <Button onClick={onClick} type="submit" variant="outlined" style={{marginTop:"1rem", marginBottom:"1rem"}}>{children}</Button>
)

export default FormButton
