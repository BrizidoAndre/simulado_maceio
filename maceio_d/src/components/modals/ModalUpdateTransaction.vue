<script setup>

import {reactive} from "vue";
import {api} from "@/helpers/api.js";
import FieldSelect from "@/components/FieldSelect.vue";
import Field from "@/components/Field.vue";

const emits = defineEmits(['close', 'load'])
const props = defineProps([
  "id",
  "subscription_id",
  "amount",
  "transaction_date",
  "status",
  "worker_id",
  "usage_count",
  "description",
  "created_at",
  "updated_at",
  "worker",
  'subscription',
  'customers',
  'plans',
  'workers',
])
const transaction = reactive({
  "worker_id": props?.worker_id ?? '',
  "transaction_date": props?.transaction_date ?? '',
  "amount": props?.amount ?? '',
  "usage_count": props?.usage_count ?? '',
  "description": props?.description ?? '',
})

async function submit() {
  const [res, data] = await api.put('transactions/' + props.id, transaction);
  if (res.ok) {
    emits('load');
    emits('close');
  }
}
</script>

<template>
  <h1>Update Transaction</h1>
  <form action="" @submit.prevent="submit">
    <field v-model="transaction.amount">Amount</field>
    <field-select label="Worker" v-model="transaction.worker_id">
      <option v-for="worker in workers" :value="worker.id">{{ worker.name }}</option>
    </field-select>
    <field v-model="transaction.transaction_date" type="date">Transaction Date</field>
    <field v-model="transaction.description">Description</field>
    <button class="btn btn-primary">Edit</button>
  </form>
</template>

<style scoped>

</style>