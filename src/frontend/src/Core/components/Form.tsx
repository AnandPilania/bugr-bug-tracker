
const Form = ({children, ...props}) => {
    const onSubmit = e => {
        e.preventDefault()
        return false
    }

    return (
        <form onSubmit={onSubmit} {...props}>
            {children}
        </form>
    )
}

export default Form
