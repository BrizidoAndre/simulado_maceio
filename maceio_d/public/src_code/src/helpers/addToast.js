import {ref} from "vue";

export const alerts = ref([]);
// adds a toast to every request
export const addToast = (message, type = 'primary') => {
    const id = Math.random();
    alerts.value.push({
        id, message, type,
    })
    setTimeout(() => {
        alerts.value = alerts.value.filter(a => a.id !== id);
    }, 3000);
}