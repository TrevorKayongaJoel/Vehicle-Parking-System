<template>
  <div class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white p-6">
      <h2 class="text-xl font-bold">Parking System</h2>

      <div class="mt-6">
        <p class="font-semibold">{{ user.name }}</p>
        <p class="text-sm text-gray-400 capitalize">{{ user.role }}</p>
      </div>

      <!-- Navigation -->
      <nav class="mt-8 space-y-2">
        <Link href="/dashboard" class="block hover:text-yellow-400">Dashboard</Link>

        <!-- Admin Links -->
        <Link
          v-if="user.role === 'admin'"
          href="/admin/users"
          class="block hover:text-yellow-400"
        >
          Manage Users
        </Link>

        <!-- Attendant Links -->
        <!-- <Link
          v-if="user.role === 'attendant'"
          href="/attendant/parking"
          class="block hover:text-yellow-400"
        >
          Check-In Vehicles
        </Link> -->

        <!-- <Link
  href="/payments/create"
  v-if="['admin', 'attendant'].includes(user.role)"
  class="block hover:text-yellow-400"
>
  Payment
</Link> -->
      </nav>

 

      <!-- Logout Button -->
      <form @submit.prevent="logout" class="mt-8">
        <button type="submit" class="text-red-400 hover:text-red-600">Logout</button>
      </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { useForm, Link, usePage } from '@inertiajs/vue3'

const user = usePage().props.auth.user
const form = useForm({})

const logout = () => form.post(route('logout'))

console.log('user', user)
</script>
