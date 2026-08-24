<script setup>

import {alerts} from "@/helpers/addToast.js";
</script>

<template>
  <div class="position-fixed bottom-0 end-0 m-5 z-3">
    <transition-group>
      <div v-for="alert in alerts" class="alert" :class="'alert-' + alert.type" role="alert" :key="alert.id">
        {{ alert.message }}
      </div>
    </transition-group>
  </div>
</template>
<style scoped>
/**
the animation for transition group
 */
.v-enter-active,
.v-leave-active,
.v-move {
  transition: .4s;
}

.v-leave-active {
  position: absolute;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>