import Axios, {AxiosError, AxiosResponse} from "axios";
import {LoadingOverlayContext, LoadingOverlayContextType} from "./LoadingOverlayContext";
import {useContext} from "react";
import AuthContext from "../Auth/AuthContext";

export type UseApiType = {
    get: Function,
    post: Function,
    put: Function,
    patch: Function,
    delete: Function
}

export type SuccessResponseType = {
    data: any,
    status: number,
    statusText: string,
    headers: Array<any>
}

export type ErrorResponseType = {
    status: number,
    statusText: string,
    data: string,
    headers: Array<any>
}

type CachedDataType = {
    data: any,
    expiry: Date
}

const requestCache = new Map<string,Promise<any>>()
const dataCache = new Map<string,CachedDataType>()

const useApi = (): UseApiType => {
    const {token} = useContext(AuthContext)
    const loadingOverlay = useContext<LoadingOverlayContextType>(LoadingOverlayContext)

    let config = {
        baseUrl: 'http://localhost:8000/api'
    }

    const memoAxios = (method: string, url: string, data: {} = {}, headers: {} = {}, axiosController: AbortController) => {
        const promise = Axios({
            method,
            url,
            data,
            headers,
            signal: axiosController.signal
        })

        // memo-ise GET requests
        if (method.toLowerCase() === 'get') {
            promise.then(resolve => {
                requestCache.delete(url)
                return resolve
            })
            promise.catch(reject => {
                requestCache.delete(url)
                return reject
            })

            // @todo allow denial of caching on some requests
            if (!requestCache.has(url)) {
                requestCache.set(url, promise)
                return promise
            }
            return requestCache.get(url)
        }

        return promise
    }

    const makeRequest = (method: string, url: string, data: Object = {}, onSuccess: Function = () => {}, onError: Function = () => {}, headers: {} = {}) => {
        // check request method is acceptable
        if (!['get', 'post', 'put', 'patch', 'delete'].includes(method.toLowerCase())) {
            throw new Error(`Invalid request method: ${method}`)
        }

        url = config.baseUrl + url

        if (method.toLowerCase() === 'get') {
            // attempt to use data cache for get requests
            console.log('Attempting to use cache for', url)
            if (dataCache.has(url)) {
                const cachedData = dataCache.get(url)
                if (cachedData.expiry > new Date()) {
                    onSuccess(cachedData.data)
                    // early return here because we're finished with this function
                    return
                } else {
                    dataCache.delete(url)
                }
            }
        }

        if (token) {
            headers.token = token
        }

        loadingOverlay.show()

        const axiosController = new AbortController()

        const promise = memoAxios(method, url, data, headers, axiosController)

        promise.then((response: AxiosResponse) => {
            const responseData = {
                data: response.data,
                status: response.status,
                statusText: response.statusText,
                headers: response.headers
            }
            if (method.toLowerCase() === 'get') {
                const expiryDate = new Date()
                expiryDate.setTime(expiryDate.getTime()+6000)
                const dataToCache = {
                    data: responseData,
                    expiry: expiryDate
                }
                dataCache.set(url, dataToCache)
            }
            onSuccess(responseData)
        })

        promise.catch((err: AxiosError) => {
            if (axiosController.signal.aborted) {
                return
            }

            dataCache.delete(url)

            // @todo one day I'll remove this debugging code. But not this day
            console.log(err)
            onError({
                status: err.response?.status,
                statusText: err.response?.statusText,
                data: err.response?.data,
                headers: err.response?.headers
            })
        })

        promise.finally(() => {
            loadingOverlay.hide()
        })

        return  () => axiosController.abort()
    }

    const get = (url: string, data: Object, onSuccess: Function = (response: SuccessResponseType) => {}, onError: Function = (error: ErrorResponseType) => {}) => {
        // build query string from data object
        const params = (() => {
            const params = Object.entries(data).map(([key,value]) => key + '=' + value).join(',')
            if (params.length === 0) {
                return ''
            }
            return '&' + params
        })()

        return makeRequest('get', url+params, data, onSuccess, onError)
    }

    const post = (url: string, data: Object, onSuccess: Function = () => {}, onError: Function = () => {}, headers: {} = {}) => {
        return makeRequest('post', url, data, onSuccess, onError, headers)
    }

    const put = (url: string, data: Object, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return makeRequest('put', url, data, onSuccess, onError)
    }

    const patch = (url: string, data: Object, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return makeRequest('patch', url, data, onSuccess, onError)
    }

    const deleteRequest = (url: string, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        return makeRequest('delete', url, {}, onSuccess, onError)
    }

    return {
        get,
        post,
        put,
        patch,
        delete: deleteRequest  // delete is a reserved word for a function
    }
}

export default useApi
