
const useCookie = (key: string, defaultValue: string) => {
    const createCookieObject = () => {
        return document.cookie
            .split(';')
            .filter(item => !!item?.trim())
            .map(item => item.split('='))
            .filter(item => item?.length > 1)
            .reduce((previous,current) => {
                return {
                    ...previous,
                    [current[0].trim()]: current[1].trim()
                }
            }, {})
    }

    const setCookieString = (cookieObj) => {
        const cookieArr = Object.entries(cookieObj).map(item => item[0]+'='+item[1])
        document.cookie = cookieArr.join(';')
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
        // @todo refactor this to properly deal with deleting a cookie entry
        // looks like it needs to have an expiry set on it with a negative time
        cookieObj[key] = ''
        setCookieString(cookieObj)
    }

    return {
        get,
        set,
        delete: del
    }
}

export default useCookie
