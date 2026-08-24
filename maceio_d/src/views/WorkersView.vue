<script setup>

import {api} from "@/helpers/api.js";
import {onMounted, ref} from "vue";
import {useModal} from "@/helpers/useModal.js";
import ModalCreateWorker from "@/components/modals/ModalCreateWorker.vue";
import ModalUpdateWorker from "@/components/modals/ModalUpdateWorker.vue";

const models = ref([]);

async function loadModels() {
  const [res, data] = await api.get('workers');
  models.value = data;
}

const modal = useModal();

function modalCreate() {
  modal.open(ModalCreateWorker, {
    'onLoad': loadModels,
  })
}

function modalUpdate(model) {
  modal.open(ModalUpdateWorker, {
    'onLoad': loadModels,
    ...model
  })
}

async function handleDelete(id) {
  if (confirm('Are you sure? All related data will be lost?')) {
    const [res, data] = await api.delete('workers/' + id);
    loadModels();
  }
}

function handleSchedule(model) {
  const blob = new Blob([model.schedule], {
    type: "text/calendar",
  });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.download = String(model.name).toLowerCase() + '_worker.ics';
  link.click();
  link.remove();
}

onMounted(() => {
  loadModels()
})
</script>

<template>
  <div class="hstack justify-content-between">
    <h1>Workers</h1>
    <button class="btn btn-primary" @click="modalCreate">Create New Worker</button>
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
        <button @click="handleSchedule(model)" class="btn btn-secondary">Export Schedule to .ics</button>
      </td>
    </tr>
    </tbody>
  </table>
</template>