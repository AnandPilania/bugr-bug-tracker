
const useCookie = (key: string, defaultValue: string) => {
    const createCookieObject = () => {
        const cookies = document.cookie.split(';').map(item => item.split('='))
        // @todo re-write this as cookies.reduce(...)
        let cookieObj = {}
        cookies.every(item => cookieObj[item[0].trim()] = item[1].trim())
        return cookieObj
    }

    const setCookieString = (cookieObj) => {
        const cookieArr = Object.entries(cookieObj).map(item => item[0]+'='+item[1])
        document.cookie = cookieArr.join(';')
        console.log(document.cookie)
    }

    const get = () => {
        const cookieObj = createCookieObject()
        return cookieObj[key] ?? defaultValue
    }

    const set = (newValue) => {
        const cookieObj = createCookieObject()
        cookieObj[key] = newValue
        setCookieString(cookieObj)
    }

    const del = () => {
        const cookieObj = createCookieObject()
        delete cookieObj[key]
        console.log(cookieObj)
        setCookieString(cookieObj)
    }

    return {
        get,
        set,
        delete: del
    }
}

export default useCookie
