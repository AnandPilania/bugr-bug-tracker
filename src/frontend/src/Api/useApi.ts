import Axios, {AxiosError} from "axios";
import {LoadingOverlayContext, LoadingOverlayContextType} from "./LoadingOverlayContext";
import {useContext} from "react";
import AuthContext from "../Auth/AuthContext";
import useCache from "../Core/useCache";

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

const buildGetRequestParamString = (data: {} = {}) => {
    const params = Object.entries(data).map(([key,value]) => key + '=' + value).join(',')
    if (params.length === 0) {
        return ''
    }
    return '&' + params
}

const useApi = (): UseApiType => {
    const {token} = useContext(AuthContext)
    const loadingOverlay = useContext<LoadingOverlayContextType>(LoadingOverlayContext)
    const Cache = useCache()

    let config = {
        baseUrl: 'http://localhost:8000/api'
    }

    const createCachedPromise = (url: string, headers: {} = {}, axiosController: AbortController) => {
        const PromiseCacheKey = `promise.${url}`

        if (Cache.has(PromiseCacheKey)) {
            return Cache.get(PromiseCacheKey)
        }

        const promise = Axios({
            method: 'get',
            url,
            headers,
            signal: axiosController.signal
        }).then(resolve => {
            Cache.delete(PromiseCacheKey)

            // For GET requests only, we'll cache the response data
            const responseData = {
                data: resolve.data,
                status: resolve.status,
                statusText: resolve.statusText,
                headers: resolve.headers
            }

            Cache.add(url, responseData, 6000)

            return responseData
        }).catch(reject => {
            Cache.delete(PromiseCacheKey)
            throw reject
        })

        Cache.add(PromiseCacheKey, promise)
        return promise
    }

    const createPromise = (method: string, url: string, data: {} = {}, headers: {} = {}, axiosController: AbortController) => {
        return Axios({
            method,
            url,
            data,
            headers,
            signal: axiosController.signal
        })
    }

    const makeRequest = (method: string, url: string, data: Object = {}, onSuccess: Function = () => {}, onError: Function = () => {}, headers: {} = {}) => {
        // check request method is acceptable
        if (!['get', 'post', 'put', 'patch', 'delete'].includes(method.toLowerCase())) {
            throw new Error(`Invalid request method: ${method}`)
        }

        loadingOverlay.show()

        url = config.baseUrl + url

        if (token) {
            headers.token = token
        }

        const abortController = new AbortController()

        const promise = method === 'get'
            ? createCachedPromise(url, headers, abortController)
            : createPromise(method, url, data, headers, abortController)

        promise.then(response => {
            const responseData = {
                data: response.data,
                status: response.status,
                statusText: response.statusText,
                headers: response.headers
            }
            onSuccess(responseData)
        }).catch((err: AxiosError) => {
            if (abortController.signal.aborted) {
                return
            }

            // @todo one day I'll remove this debugging code. But not this day
            console.log(err)
            onError({
                status: err.response?.status,
                statusText: err.response?.statusText,
                data: err.response?.data,
                headers: err.response?.headers
            })
        }).finally(() => {
            loadingOverlay.hide()
        })

        return () => {
            /**
             * Due to the async nature of the calls being made from React, we need to delete any Promises from the
             * cache when cancelling the request to save us from accidentally returning a cancelled promise later.
             *
             * NB: Not all promises go into the cache but this doesn't give any errors and will only be a very minor
             * performance hit
              */
            Cache.delete(`promise.${url}`)
            abortController.abort()
        }
    }

    const get = (url: string, data: Object, onSuccess: Function = () => {}, onError: Function = () => {}) => {
        const params = buildGetRequestParamString(data)

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
