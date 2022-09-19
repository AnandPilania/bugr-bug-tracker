import {Table} from "@mui/material";
import {ReactElement} from "react";

type FixedTableProps = {
    children: ReactElement|Array<ReactElement>
}

const FixedTable = ({children}: FixedTableProps) => <Table style={{tableLayout: "fixed"}}>{children}</Table>

export default FixedTable
