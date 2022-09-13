import {ListItemIcon, ListItemText, MenuItem} from "@mui/material";

const MenuItemWithIcon = ({icon, text, ...props}) => (
    <MenuItem {...props}>
        <ListItemIcon>
            {icon}
        </ListItemIcon>
        <ListItemText>
            {text}
        </ListItemText>
    </MenuItem>
)

export default MenuItemWithIcon