import {Checkbox, FormControlLabel} from "@mui/material";

type FormCheckboxProps = {
    label: string,
    onChange: Function,
    checked: boolean
}

const FormCheckbox = ({onChange, checked, ...props}: FormCheckboxProps) => (
    <FormControlLabel control={<Checkbox checked={checked} onChange={onChange} />} {...props} />
)

export default FormCheckbox
