<script setup>

import {api} from "@/helpers/api.js";
import {onMounted, ref} from "vue";
import {useModal} from "@/helpers/useModal.js";
import ModalCreateCustomer from "@/components/modals/ModalCreateCustomer.vue";
import ModalUpdateCustomer from "@/components/modals/ModalUpdateCustomer.vue";

const models = ref([]);

/**
 * loads the current models
 * @returns {Promise<void>}
 */
async function loadModels() {
  const [res, data] = await api.get('customers');
  models.value = data;
}

const modal = useModal();

/**
 * opens the create modal
 */
function modalCreate() {
  modal.open(ModalCreateCustomer, {
    'onLoad': loadModels,
  })
}

/**
 * open the update modal
 * @param model The record to fill the data
 */
function modalUpdate(model) {
  modal.open(ModalUpdateCustomer, {
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
    const [res, data] = await api.delete('customers/' + id);
    loadModels();
  }
}

onMounted(() => {
  loadModels()
})
</script>

<template>
  <div class="hstack justify-content-between">
    <h1>Customers</h1>
    <button class="btn btn-primary" @click="modalCreate">Create New Customer</button>
  </div>
  <table class="table">
    <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    <tr v-for="model in models" :key="model.id">
      <td>{{ model.id }}</td>
      <td>{{ model.name }}</td>
      <td class="hstack gap-2">
        <button @click="modalUpdate(model)" class="btn btn-secondary">Edit</button>
        <button @click="handleDelete(model.id)" class="btn btn-danger">Delete</button>
      </td>
    </tr>
    </tbody>
  </table>
</template>