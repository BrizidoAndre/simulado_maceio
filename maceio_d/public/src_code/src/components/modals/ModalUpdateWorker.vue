<script setup>

import {reactive} from "vue";
import Field from "@/components/Field.vue";
import {api} from "@/helpers/api.js";

const emits = defineEmits(['close', 'load'])
const props = defineProps(['id', 'name', 'created_at', 'updated_at', 'schedule'])

const customer = reactive({
  name: props?.name ?? '',
})

async function submit() {
  const [res, data] = await api.put('workers/' + props.id, customer);
  if (res.ok) {
    emits('load');
    emits('close');
  }
}
</script>

<template>
  <h2>Edit Worker</h2>
  <form action="" @submit.prevent="submit">
    <field v-model="customer.name">Name</field>
    <button class="btn btn-primary">Update</button>
  </form>
</template>

<style scoped>

</style>