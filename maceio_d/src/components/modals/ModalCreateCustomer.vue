<script setup>

import {reactive} from "vue";
import Field from "@/components/Field.vue";
import {api} from "@/helpers/api.js";

const emits = defineEmits(['close', 'load'])
const props = defineProps([])

const customer = reactive({
  name: '',
})

async function submit() {
  const [res, data] = await api.post('customers', customer);
  if (res.ok) {
    emits('load');
    emits('close');
  }
}
</script>

<template>
  <h2>Create customer</h2>
  <form action="" @submit.prevent="submit">
    <field v-model="customer.name">Name</field>
    <button class="btn btn-primary">Save customer</button>
  </form>
</template>

<style scoped>

</style>