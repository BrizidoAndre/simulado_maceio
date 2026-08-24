<script setup>

import {reactive} from "vue";
import Field from "@/components/Field.vue";
import {api} from "@/helpers/api.js";

const emits = defineEmits(['close', 'load'])
const props = defineProps([
  "id",
  "name",
  "price",
  "monthly_usage_limit",
  "created_at",
  "updated_at",
])

const plan = reactive({
  name: props?.name ?? '',
  price: props?.price ?? '',
  monthly_usage_limit: props?.monthly_usage_limit ?? '',
})

async function submit() {
  const [res, data] = await api.put('plans/' + props.id, plan);
  if (res.ok) {
    emits('load');
    emits('close');
  }
}
</script>

<template>
  <h2>Create Plan</h2>
  <form action="" @submit.prevent="submit">
    <field v-model="plan.name">Name</field>
    <field v-model="plan.price" type="number">Price</field>
    <field v-model="plan.monthly_usage_limit" type="number">Monthly usage limit</field>
    <button class="btn btn-primary">Save</button>
  </form>
</template>

<style scoped>

</style>