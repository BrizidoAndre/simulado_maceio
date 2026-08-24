import {compile, computed, ref, watch} from "vue";

// this token is responsible to check if user is logged or not
export const token = ref(null);
// a computed property handling the headers necessary for
// the headers request of the api
export const apiHeaders = computed(() => {
    const headers = new Headers();
    headers.append('Accept', 'application/json');
    headers.append('Content-Type', 'application/json');
    if (token.value) {
        headers.append('Authorization', 'Bearer ' + token.value);
    }
    return headers;
})

// syncs the session storage with a ref variable
export function syncStorage(value, key) {
    const localKey = key + '_br';
    if (sessionStorage[localKey]) {
        value.value = JSON.parse(sessionStorage[localKey])
    }
    watch(value, value => {
        sessionStorage[localKey] = JSON.stringify(value);
    },)
}

syncStorage(token);