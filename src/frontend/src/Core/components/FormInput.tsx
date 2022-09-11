import {TextField} from "@mui/material";
import {ChangeEventHandler} from "react";

type FormInputProps = {
    label: string,
    value: string,
    onChange: ChangeEventHandler,
    type: string
}

const FormInput = ({label, value, onChange, type}: FormInputProps) => (
    <TextField label={label} margin="dense" type={type} value={value} onChange={onChange} fullWidth variant="standard"></TextField>
)

export default FormInput
