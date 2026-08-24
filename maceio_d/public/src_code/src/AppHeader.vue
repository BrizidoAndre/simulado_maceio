<script setup>

import {useRouter} from "vue-router";
import {token} from "@/helpers/global.js";
import {api} from "@/helpers/api.js";

const router = useRouter();

/**
 * logs out the user
 * @returns {Promise<void>}
 */
async function logout() {
  const [res, data] = await api.post('logout');
  if (res.ok) {
    token.value = null;
    router.push({
      name: 'login',
    })
  }
}
</script>

<template>
  <header class="container bg-body-tertiary d-print-none">
    <nav class="navbar navbar-expand">
      <div class="container-fluid">
        <router-link to="/" class="navbar-brand">Gonzaga Barber</router-link>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-0">
            <template v-if="!token">
              <li class="nav-item">
                <router-link class="nav-link" to="/login">Login</router-link>
              </li>
            </template>
            <template v-else>
              <li class="nav-item">
                <router-link class="nav-link" to="/transactions">Transactions</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/workers">Workers</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/">Customers</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/plans">Plans</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/subscriptions">Subscriptions</router-link>
              </li>
              <li class="nav-item">
                <button class="btn btn-danger" @click="logout">Logout</button>
              </li>
            </template>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>