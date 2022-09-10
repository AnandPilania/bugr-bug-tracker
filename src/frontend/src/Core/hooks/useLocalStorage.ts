
const useLocalStorage = (key: string, defaultValue: string = null) => {
    const getValue = () => {
        return localStorage.getItem(key) ?? defaultValue
    }
    const setValue = (value: string) => localStorage.setItem(key, value)

    return {
        get: getValue,
        set: setValue
    }
}

export default useLocalStorage
