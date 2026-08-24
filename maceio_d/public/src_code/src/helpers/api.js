import {apiHeaders} from "@/helpers/global.js";
import {addToast} from "@/helpers/addToast.js";

const api_url = 'http://10.83.10.136/gonzaga-barber/public/api/';

/**
 * the default request methods
 * every method from api object uses this function
 * @param url
 * @param options
 * @returns {Promise<(Response|any)[]|*[]>}
 */
export async function request(url, options = {}) {
    try {
        const res = await fetch(api_url + url, {
            headers: apiHeaders.value,
            ...options,
        })
        // check if is no content response
        if (res.status === 204) {
            return [null, null]
        }
        const data = await res.json();
        // check if errors property is an array to render every alert as a call
        if (data?.errors && Array.isArray(data?.errors)) {
            data.errors.forEach(erro => {
                addToast(erro, 'danger');
            })
        } else if (data?.errors && typeof data.errors === 'object') {
            // check if errors is an object to render
            // every corresponding error
            for (const errorKey in data.errors) {
                data.errors[errorKey].forEach(msg => {
                    addToast(msg, 'danger');
                })
            }
        } else if (data?.error && typeof data.error === 'string') {
            // check if error is a single string to add as an alert
            addToast(data.error, 'danger');
        } else if (data?.message) {
            // if api has a necessary message
            addToast(data.message, 'secondary');
        }
        return [res, data];

    } catch (e) {
        return [null, null]
    }
}


/**
 * the api object
 * use this to make a request from the api
 * every method has its corresponding function
 * @type {{get: function(*): Promise<null[]|[Response,any]|undefined>, post: function(*, *): Promise<null[]|[Response,any]|undefined>, put: function(*, *): Promise<null[]|[Response,any]|undefined>, delete: function(*): Promise<null[]|[Response,any]|undefined>}}
 */
export const api = {
    get: async (url) => {
        return await request(url, {
            method: 'GET'
        })
    },
    post: async (url, body) => {
        return await request(url, {
            method: 'POST',
            body: JSON.stringify(body)
        })
    },
    put: async (url, body) => {
        return await request(url, {
            method: 'PUT',
            body: JSON.stringify(body)
        })
    },
    delete: async (url) => {
        return await request(url, {
            method: 'DELETE',
        })
    },
}