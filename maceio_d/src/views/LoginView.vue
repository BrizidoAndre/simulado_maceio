<script setup>
import Field from "@/components/Field.vue";
import {api} from "@/helpers/api.js";
import {reactive} from "vue";
import {token} from "@/helpers/global.js";
import {useRouter} from "vue-router";

const user = reactive({
  username: '',
  password: '',
})
const router = useRouter();

/**
 * Logs the user to the software
 * @returns {Promise<void>}
 */
async function submit() {
  const [res, data] = await api.post('login', user);
  token.value = data.token;
  router.push({
    name: 'customers',
  })
}
</script>

<template>
  <h1>Login</h1>
  <form action="" @submit.prevent="submit">
    <field v-model="user.username">Username</field>
    <field type="password" v-model="user.password">Password</field>
    <button class="btn btn-primary">Login</button>
  </form>
</template>