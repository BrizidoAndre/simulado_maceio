<script setup>
import AppToast from "@/components/AppToast.vue";
import AppHeader from "@/AppHeader.vue";
import AppModal from "@/components/AppModal.vue";

</script>

<template>
  <AppHeader/>
  <main class="container py-5">
    <router-view></router-view>
  </main>
  <app-toast/>
  <app-modal/>
</template>