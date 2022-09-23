import {Checkbox, FormControlLabel, FormGroup} from "@mui/material";

type FormCheckboxProps = {
    label: string,
    onChange: Function,
    checked: boolean
}

const FormCheckbox = ({onChange, checked, ...props}: FormCheckboxProps) => (
    <FormGroup>
        <FormControlLabel sx={{display:"block"}} control={<Checkbox checked={checked} onChange={onChange} />} {...props} />
    </FormGroup>
)

export default FormCheckbox
