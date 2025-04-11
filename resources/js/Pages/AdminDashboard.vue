<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
//
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <AppLayout>
    <h1 class="text-2xl font-bold">Welcome Admin</h1>
    <div class="space-y-2">
      <Link 
        href="/admin/users" 
        class="text-blue-600 hover:underline"
      >
        ➕ Manage Users
      </Link>
    </div>
  </AppLayout>
</template>
