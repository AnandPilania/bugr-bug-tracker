import {
    Box, Card, CardActionArea, CardContent,
    Divider, Link as MuiLink,
    Paper,
    Table, TableBody,
    TableCell, TableContainer,
    TableHead,
    TableRow,
    Typography
} from "@mui/material";
import {useContext, useEffect, useState} from "react";
import {AuthContext, AuthContextType} from "../../Auth/AuthContext";
import useRepository from "../hooks/useRepository";
import Config from "../../config";
import DashboardRepository from "../../Bug/repository/DashboardRepository";
import {Link, useNavigate} from "react-router-dom";
import Url from "../../Url";
import {useSnackbar} from "notistack";

const DashboardPage = () => {
    const navigateTo = useNavigate()
    const {enqueueSnackbar: setError} = useSnackbar()
    const {user} = useContext<AuthContextType>(AuthContext)
    const [projects, setProjects] = useState([])
    const dashboardRepository = useRepository(DashboardRepository)

    useEffect(() => {
        dashboardRepository.getDashboardData(
            response => console.log(response),
            err => setError(err)
        )
        // eslint-disable-next-line
    }, [])

    return <>
        <Typography variant="h1">{Config.app_title}.</Typography>
        {user && <Typography>Hello, {user.friendlyName}.</Typography>}

        <Divider sx={{marginY:"1rem"}} />
    </>
    /*
        {projects.map((project,key) => {
            const statusColumnWidth = (100 / project.statuses.length) + '%';
            return (
                <Box key={`p${key}`}>
                    <Typography variant="h4"><MuiLink component={Link} to={Url.projects.view(project.id)}>{project.title}</MuiLink></Typography>
                    <TableContainer component={Paper}>
                        <Table>
                            <TableHead>
                                <TableRow>
                                    {project.statuses.map((status,key) => (
                                        <TableCell key={`ps${key}`} sx={{textAlign:"center", width:statusColumnWidth}}>{status}</TableCell>
                                    ))}
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                <TableRow>
                                    {project.statuses.map((status,key) => (
                                        <TableCell key={`s${key}`}>
                                            {project.bugs.filter(bug => bug.statusName === status && bug.assigneeName === 'rwatson').map((bug, key) => (
                                                <Card variant="outlined" key={`b${key}`}>
                                                    <CardActionArea onClick={() => navigateTo(Url.bugs.view(bug.id))}>
                                                        <CardContent>
                                                            <Typography color="primary">{bug.title}</Typography>
                                                            <Typography>{bug.description}</Typography>
                                                            <Typography sx={{textAlign: "right"}}
                                                                        color="text.secondary">{bug.assigneeName}</Typography>
                                                        </CardContent>
                                                    </CardActionArea>
                                                </Card>
                                            ))}
                                        </TableCell>
                                    ))}
                                </TableRow>
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Box>
            )
        })}
    </>
     */
}

export default DashboardPage
