import {Link as MuiLink, Typography} from "@mui/material";
import Config from "../../config";
import {Link} from "react-router-dom";
import Url from "../../Url";

const IndexPage = () => (
    <>
        <Typography variant="h1">{Config.app_title}.</Typography>
        <Typography>
            <MuiLink component={Link} to={Url.auth.login}>Log in here</MuiLink>
        </Typography>
    </>
)

export default IndexPage
