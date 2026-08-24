<script setup>
import {useModal} from "@/helpers/useModal.js";

// all property from useModal composable
const {component, isOpen, options, open, close} = useModal();
</script>

<template>
  <transition>
    <div class="position-fixed top-0 start-0 vw-100 vh-100 d-flex justify-content-center align-items-center"
         @click="close" v-if="isOpen">
      <div class="container-wrapper bg-body-tertiary rounded-3 p-3" @click.stop>
        <component @close="close" :is="component" v-bind="options"></component>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.position-fixed {
  background: rgba(0, 0, 0, .7);
}

.container-wrapper {
  width: clamp(300px, 80%, 700px);
}

.v-enter-active,
.v-leave-active {
  transition: .4s;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>