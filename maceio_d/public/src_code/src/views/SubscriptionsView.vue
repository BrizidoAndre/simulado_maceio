<script setup>

import {api} from "@/helpers/api.js";
import {onMounted, ref} from "vue";
import {useModal} from "@/helpers/useModal.js";
import ModalCreateSubscription from "@/components/modals/ModalCreateSubscription.vue";
import ModalUpdateSubscription from "@/components/modals/ModalUpdateSubscription.vue";

const models = ref([]);

/**
 * loads the current models
 * @returns {Promise<void>}
 */
async function loadModels() {
  const [res, data] = await api.get('subscriptions');
  models.value = data;
}

const modal = useModal();

/**
 * opens the create modal
 */
function modalCreate() {
  modal.open(ModalCreateSubscription, {
    'onLoad': loadModels,
  })
}

/**
 * open the update modal
 * @param model The record to fill the data
 */
function modalUpdate(model) {
  console.log(model);
  modal.open(ModalUpdateSubscription, {
    'onLoad': loadModels,
    ...model
  })
}

/**
 * The delete method always asking first
 * @param id
 * @returns {Promise<void>}
 */
async function handleDelete(id) {
  if (confirm('Are you sure? All related data will be lost?')) {
    const [res, data] = await api.delete('subscriptions/' + id);
    loadModels();
  }
}

onMounted(() => {
  loadModels()
})
</script>

<template>
  <div class="hstack justify-content-between">
    <h1>Subscriptions</h1>
    <button class="btn btn-primary" @click="modalCreate">Create Subscription</button>
  </div>
  <table class="table">
    <thead>
    <tr>
      <th>ID</th>
      <th>Customer</th>
      <th>Plan</th>
      <th>Start date</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="model in models" :key="model.id">
      <td>{{ model.id }}</td>
      <td>{{ model.customer.name }}</td>
      <td>{{ model.plan.name }}</td>
      <td>{{ model.start_date }}</td>
      <td class="hstack gap-2">
        <button @click="modalUpdate(model)" class="btn btn-secondary">Edit</button>
        <button @click="handleDelete(model.id)" class="btn btn-danger">Delete</button>
      </td>
    </tr>
    </tbody>
  </table>
</template>