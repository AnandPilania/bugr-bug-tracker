import {createContext, ReactElement, useState} from "react";
import {NewBugStateType} from "../../Bug/components/NewBugModal";

type NewBugModalProviderProps = {
    children: ReactElement|ReactElement[]
}

export const NewBugModalContext = createContext({
    open: false,
    setOpen: (value: boolean) => {},
    setDefaults: (defaults: {}) => {},
    defaults: {}
})

const NewBugModalProvider = ({children}: NewBugModalProviderProps) => {
    const [modalOpen, setModalOpen] = useState<boolean>(false)
    const [modalDefaults,setModalDefaults] = useState<NewBugStateType>({
        title: '',
        description: '',
        projectId: '',
        statusId: ''
    })

    const _setModalOpen = (value: boolean) => {
        setModalOpen(value)
    }

    const _setModalDefaults = (defaults: NewBugStateType) => {
        setModalDefaults({...modalDefaults, ...defaults})
    }

    return (
        <NewBugModalContext.Provider value={{
            open: modalOpen,
            defaults: modalDefaults,
            setOpen: _setModalOpen,
            setDefaults: _setModalDefaults
        }}>
            {children}
        </NewBugModalContext.Provider>
    )
}

export default NewBugModalProvider
