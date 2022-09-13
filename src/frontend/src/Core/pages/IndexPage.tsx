import {Link as MuiLink, Typography} from "@mui/material";
import Config from "../../config";
import {Link} from "react-router-dom";
import URLs from "../../URLs";

const IndexPage = () => (
    <>
        <Typography variant="h1">{Config.app_title}.</Typography>
        <Typography>
            <MuiLink component={Link} to={URLs.auth.login}>Log in here</MuiLink>
        </Typography>
    </>
)


export default IndexPage
