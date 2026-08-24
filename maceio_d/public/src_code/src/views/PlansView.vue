<script setup>

import {api} from "@/helpers/api.js";
import {onMounted, ref} from "vue";
import {useModal} from "@/helpers/useModal.js";
import ModalCreatePlan from "@/components/modals/ModalCreatePlan.vue";
import ModalUpdatePlan from "@/components/modals/ModalUpdatePlan.vue";

const models = ref([]);


/**
 * loads the current models
 * @returns {Promise<void>}
 */
async function loadModels() {
  const [res, data] = await api.get('plans');
  models.value = data;
}

const modal = useModal();

/**
 * opens the create modal
 */
function modalCreate() {
  modal.open(ModalCreatePlan, {
    'onLoad': loadModels,
  })
}

/**
 * open the update modal
 * @param model The record to fill the data
 */
function modalUpdate(model) {
  modal.open(ModalUpdatePlan, {
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
    const [res, data] = await api.delete('plans/' + id);
    loadModels();
  }
}

onMounted(() => {
  loadModels()
})
</script>

<template>
  <div class="hstack justify-content-between">
    <h1>Plans</h1>
    <button class="btn btn-primary" @click="modalCreate">Create Plan</button>
  </div>
  <table class="table">
    <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price</th>
      <th>Usage limit</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    <tr v-for="model in models" :key="model.id">
      <td>{{ model.id }}</td>
      <td>{{ model.name }}</td>
      <td>{{ model.price }}</td>
      <td>{{ model.monthly_usage_limit }}</td>
      <td class="hstack gap-2">
        <button @click="modalUpdate(model)" class="btn btn-secondary">Edit</button>
        <button @click="handleDelete(model.id)" class="btn btn-danger">Delete</button>
      </td>
    </tr>
    </tbody>
  </table>
</template>