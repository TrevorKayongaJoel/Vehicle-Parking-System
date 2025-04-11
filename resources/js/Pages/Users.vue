<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">User Management</h1>
      <ul>
        <li v-for="user in users" :key="user.id" class="mb-2">
          {{ user.name }} — <span class="text-gray-500">{{ user.role }}</span>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  defineProps({
    users: Array
  })
  </script>
  