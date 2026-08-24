import {markRaw, ref} from "vue";

// handle if modal is visible
const isOpen = ref(false);
// check which component is being renderable
const component = ref(null);
// check wich options and functions must be passed to then component
const options = ref({});
export const useModal = () => {
    function close() {
        isOpen.value = false;
        component.value = null;
        options.value = {};
    }

    /*
    Closes the modal first then
    open the current request
     */
    function open(target, targetOptions = {}) {
        close();
        setTimeout(() => {
            component.value = markRaw(target);
            options.value = targetOptions;
            isOpen.value = true;
        }, 300)
    }

    return {
        isOpen,
        component,
        options,
        close,
        open,
    }
}