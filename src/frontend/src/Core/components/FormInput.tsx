import {TextField} from "@mui/material";
import {ChangeEventHandler} from "react";

type FormInputProps = {
    label: string,
    value: string,
    onChange: ChangeEventHandler,
    type: string,
    helperText: string
}

const FormInput = (props: FormInputProps) => (
    <TextField {...props} margin="dense" fullWidth variant="standard"></TextField>
)

export default FormInput
