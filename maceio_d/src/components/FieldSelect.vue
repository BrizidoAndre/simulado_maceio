<script setup>
import {useId} from "vue";

const id = useId();
const model = defineModel();
defineOptions({
  inheritAttrs: false,
})
// label for select input
defineProps(['label'])
</script>

<template>
  <div class="mb-3">
    <label :for="id" class="form-label">
      {{ label }}
    </label>
    <select :id="id" v-model="model" class="form-select">
      <option value="">Select a value</option>
      <slot></slot>
    </select>
  </div>
</template>