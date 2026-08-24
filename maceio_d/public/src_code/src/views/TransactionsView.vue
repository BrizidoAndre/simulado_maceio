<script setup>

import {computed, onMounted, reactive, ref, watch} from "vue";
import {api} from "@/helpers/api.js";
import Field from "@/components/Field.vue";
import FieldSelect from "@/components/FieldSelect.vue";
import {useModal} from "@/helpers/useModal.js";
import ModalUpdateTransaction from "@/components/modals/ModalUpdateTransaction.vue";


const transactions = ref([]);
// every transaction marked as paid
const paidTransactions = computed(() => {
  return transactions.value.filter(t => t.status === 'paid');
})
// every transaction marked as pending
const pendingTransactions = computed(() => {
  return transactions.value.filter(t => t.status === 'pending');
})
// every transaction marked as not_apply
const notApplyTransactions = computed(() => {
  return transactions.value.filter(t => t.status === 'not_apply');
})
// the filters
const filters = reactive({
  customer: '',
  plan: '',
  worker: '',
  status: '',
  end_date: getMonthExtremes(),
  start_date: getMonthExtremes(true),
})

const urlFilters = computed(() => {
  const url = new URLSearchParams();
  for (const filtersKey in filters) {
    if (filters[filtersKey] !== '') {
      url.append(filtersKey, filters[filtersKey]);
    }
  }
  return url.toString();
})
const total = computed(() => {
  let totalCopy = 0;
  const transactionsCopy = [...transactions.value];
  transactionsCopy.forEach(t => {
    if (t.status === 'paid') {
      totalCopy += t.amount;
    }
  })
  return formatNumber(totalCopy);
})

/**
 * format the number to render the decimals
 * @param number
 * @returns {string}
 */
function formatNumber(number) {
  const numberString = String(number);
  if (number === 0) {
    return '0,00'
  }
  return numberString.slice(0, numberString.length - 2) + ',' + numberString.slice(numberString.length - 2)
}

async function loadModels() {
  const [res, data] = await api.get('transactions?' + urlFilters.value);
  if (res.ok) {
    transactions.value = data;
  }
}

//  helper dictionary
const status = {
  'pending': 'text-bg-primary',
  'paid': 'text-bg-success',
  'not_apply': 'text-bg-secondary',
}
const customers = ref([]);
const plans = ref([]);
const workers = ref([]);

// load all data needed for selects
async function loadSelects() {
  const [resCustomers, dataCustomers] = await api.get('customers');
  const [resPlans, dataPlans] = await api.get('plans');
  const [resWorkers, dataWorkers] = await api.get('workers');
  if (resCustomers.ok) {
    customers.value = dataCustomers;
  }
  if (resPlans.ok) {
    plans.value = dataPlans;
  }
  if (resWorkers.ok) {
    workers.value = dataWorkers;
  }
}

// get the extreme values from current month
function getMonthExtremes(start = false) {
  const now = new Date();
  if (start) {
    now.setDate(1);
    now.setMonth(now.getMonth() + 1)
  } else {
    now.setMonth(now.getMonth() + 2)
    now.setDate(-1);
  }
  const days = String(now.getDate()).padStart(2, "0")
  const month = String(now.getMonth()).padStart(2, "0")
  const year = String(now.getFullYear()).padStart(4, '0');
  return `${year}-${month}-${days}`;
}

// clear all filters to empty
function clearFilters() {
  for (const filtersKey in filters) {
    filters[filtersKey] = '';
  }
}

// paying a single transaction
async function handlePay(id) {
  if (confirm('Should mark this transaction as paid?')) {
    const [res, data] = await api.post(`transactions/${id}/mark-as-paid`)
    if (res.ok) {
      loadModels();
    }
  }
}

const modal = useModal();

// show the update modal with filled data
function modalUpdate(model) {
  modal.open(ModalUpdateTransaction, {
    'onLoad': loadModels,
    ...model,
    'customers': customers.value,
    'plans': plans.value,
    'workers': workers.value,
  })
}

onMounted(() => {
  loadModels()
  loadSelects()
})
watch(filters, value => {
  loadModels()
})
</script>

<template>
  <div class="d-print-none">
    <div class="hstack justify-content-between">
      <h1>Transactions Management</h1>
      <div>
        <p class="text-end mb-0">Period:</p>
        <div class="hstack gap-2">
          <field type="date" v-model="filters.start_date"></field>
          to
          <field type="date" v-model="filters.end_date"></field>
        </div>
      </div>
    </div>
    <table class="table table-striped">
      <thead>
      <tr>
        <th>Client</th>
        <th>Transaction Date</th>
        <th>Plan</th>
        <th>Professional</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Usage</th>
        <th>Actions</th>
      </tr>
      <tr>
        <th>
          <field-select v-model="filters.customer">
            <option v-for="model in customers" :value="model.id">{{ model.name }}</option>
          </field-select>
        </th>
        <th></th>
        <th>
          <field-select v-model="filters.plan">
            <option v-for="model in plans" :value="model.id">{{ model.name }}</option>
          </field-select>
        </th>
        <th>
          <field-select v-model="filters.worker">
            <option v-for="model in workers" :value="model.id">{{ model.name }}</option>
          </field-select>
        </th>
        <th></th>
        <th>
          <field-select v-model="filters.status">
            <option class="text-capitalize" v-for="(model,key) in status" :value="key">{{ key }}</option>
          </field-select>
        </th>
        <th></th>
        <th>
          <button class="btn btn-primary" @click="clearFilters">Clear</button>
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="transaction in transactions">
        <td>{{ transaction.subscription.customer.name }}</td>
        <td>{{ transaction.transaction_date }}</td>
        <td>{{ transaction.subscription.plan.name }}</td>
        <td>{{ transaction?.worker?.name ?? 'No worker yet' }}</td>
        <td>US${{ formatNumber(transaction.amount) }}</td>
        <td class="text-capitalize">
        <span class="badge" :class="status[transaction.status]">
        {{ transaction.status }}
        </span>
          <template v-if="transaction.status === 'pending'">
            <button @click="handlePay(transaction.id)" class="btn btn-success btn-paid">Mark as Paid</button>
          </template>
        </td>
        <td>{{ transaction.usage_count }}</td>
        <td>
          <button class="btn btn-primary" @click="modalUpdate(transaction)">
            ✏️
          </button>
        </td>
      </tr>
      </tbody>
    </table>
    <h2 class="text-end">Total Amount: US$ {{ total }}</h2>
    <hr>
  </div>
  <div class="d-none d-print-block">
    <h2 class="text-center">Transactoins Report</h2>
    <h3>Transaction Status <span class="badge bg-success">Paid</span></h3>
    <div class="bg-body-tertiary border-bottom p-3 fw-bold" v-for="transaction in paidTransactions">
      <p class="mb-0">Client: {{ transaction.subscription.customer.name }}</p>
      <p class="mb-0">Transation: {{ transaction.transaction_date }}</p>
      <p class="mb-0">Plan: {{ transaction.subscription.plan.name }}</p>
      <p class="mb-0">Professional: {{ transaction.worker.name }}</p>
      <p class="mb-0">Amount: US${{ formatNumber(transaction.amount) }}</p>
    </div>
    <h3 class="text-end my-3">Total Amount: US${{ total }}</h3>
    <h3>Transaction Status <span class="badge bg-primary">Pending</span></h3>
    <div class="bg-body-tertiary border-bottom p-3 fw-bold" v-for="transaction in pendingTransactions">
      <p class="mb-0">Client: {{ transaction.subscription.customer.name }}</p>
      <p class="mb-0">Transation: {{ transaction.transaction_date }}</p>
      <p class="mb-0">Plan: {{ transaction.subscription.plan.name }}</p>
      <p class="mb-0">Professional: {{ transaction.worker?.name ?? 'Not yet included' }}</p>
      <p class="mb-0">Amount: US${{ formatNumber(transaction.amount) }}</p>
    </div>
    <h3 class="mt-3">Transaction Status <span class="badge bg-secondary">Not apply</span></h3>
    <div class="bg-body-tertiary border-bottom p-3 fw-bold" v-for="transaction in notApplyTransactions">
      <p class="mb-0">Client: {{ transaction.subscription.customer.name }}</p>
      <p class="mb-0">Transation: {{ transaction.transaction_date }}</p>
      <p class="mb-0">Plan: {{ transaction.subscription.plan.name }}</p>
      <p class="mb-0">Professional: {{ transaction.worker?.name ?? 'Not yet included' }}</p>
      <p class="mb-0">Amount: US${{ formatNumber(transaction.amount) }}</p>
    </div>
  </div>
</template>

<style scoped>
.btn-paid {
  display: none;
}

.badge:hover ~ .btn-paid,
.btn-paid:hover {
  display: block;
}
</style>