<script setup>

import {onMounted, reactive, ref} from "vue";
import Field from "@/components/Field.vue";
import {api} from "@/helpers/api.js";
import FieldSelect from "@/components/FieldSelect.vue";

const emits = defineEmits(['close', 'load'])
const props = defineProps([
  "customer_id",
  "plan_id",
  "start_date",
  "updated_at",
  "created_at",
  "id",
  'plan',
  'customer',
])

const subscription = reactive({
  customer_id: props?.customer_id ?? '',
  plan_id: props?.plan_id ?? '',
  start_date: props?.start_date ?? '',
})

async function submit() {
  const [res, data] = await api.put('subscriptions/' + props.id, subscription);
  if (res.ok) {
    emits('load');
    emits('close');
  }
}

const plans = ref([]);
const customers = ref([]);

async function loadSelects() {
  const [planRes, planData] = await api.get('plans');
  const [customerRes, customerData] = await api.get('customers');
  if (planRes.ok) {
    plans.value = planData;
  }
  if (customerRes.ok) {
    customers.value = customerData;
  }
}

onMounted(() => {
  loadSelects()
})
</script>

<template>
  <h2>Update Subscription</h2>
  <form action="" @submit.prevent="submit">
    <field-select label="Customer" v-model="subscription.customer_id">
      <option v-for="customer in customers" :value="customer.id">{{ customer.name }}</option>
    </field-select>
    <field-select label="Plans" v-model="subscription.plan_id">
      <option v-for="plan in plans" :value="plan.id">{{ plan.name }}</option>
    </field-select>
    <field type="date" v-model="subscription.start_date">Start Date</field>
    <button class="btn btn-primary">Edit</button>
  </form>
</template>

<style scoped>

</style>