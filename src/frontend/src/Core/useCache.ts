/**
 * The items in this cache are never REMOVED.  They expire when their time is up but they remain in the cache.
 * @todo perhaps add a function to iterate over the cache and remove all expired items, or a similar feature that
 *       operates on a single key to remove it when expired.  Call that feature on has() and get() calls.
 */

export type UseCacheType = {
    get: Function,
    has: Function,
    add: Function,
    delete: Function
}

type CachedDataType = {
    data: any,
    expiry: Date
}

const cache = new Map<string,CachedDataType>()

const wrapDataWithExpiry = (data: any, expiry: Date): CachedDataType => ({data,expiry})
const unwrapData = (data: CachedDataType) => data?.data

const addDataToCache = (name: string, data: any, expiry: number = 6000) => {
    const expiryDate = new Date()
    expiryDate.setTime(expiryDate.getTime()+expiry)

    cache.set(name, wrapDataWithExpiry(data,expiryDate))
}

const removeDataFromCache = (name) => {
    return cache.delete(name)
}

const getDataFromCache = (name): any|null => {
    if (!cache.has(name)) {
        return null
    }

    return unwrapData(cache.get(name))
}

const isDataInCache = (name: string) => {
    return cache.has(name) && cache.get(name).expiry <= new Date();
}

const useCache = () => {
    return {
        delete: (name: string) => removeDataFromCache(name),
        add: (name: string, data: any, expiry: number = 6000) => addDataToCache(name, data, expiry),
        get: (name: string) => getDataFromCache(name),
        has: (name: string) => isDataInCache(name)
    }
}

export default useCache