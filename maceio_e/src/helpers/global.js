// syncs the session storage with a ref variable
import {watch} from "vue";

export function syncStorage(value, key) {
    const localKey = key + '_br';
    if (localStorage[localKey]) {
        value.value = JSON.parse(localStorage[localKey])
    }
    watch(value, value => {
        localStorage[localKey] = JSON.stringify(value);
    },{
        deep:true
    })
}
