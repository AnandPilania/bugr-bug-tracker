import {FormControl, FormGroup, InputLabel, MenuItem, Select} from "@mui/material";
import {ReactElement} from "react";

type FormSelectProps = {
    children: ReactElement|ReactElement[]
    onChange: Function,
    value: string,
    label: string
}

const FormSelect = ({children, ...props}: FormSelectProps) => (
    <FormGroup>
        <FormControl margin="dense">
            <InputLabel>{props.label}</InputLabel>
            <Select variant="outlined" {...props}>
                {children}
            </Select>
        </FormControl>
    </FormGroup>
)

export default FormSelect
