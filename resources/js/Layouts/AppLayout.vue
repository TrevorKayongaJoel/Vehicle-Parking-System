<template>
    <div class="min-h-screen flex">
      <!-- Sidebar -->
      <aside class="w-64 bg-gray-900 text-white p-4">
        <h2 class="text-lg font-bold">Dashboard</h2>
        <p class="mt-4">Hello, {{ $page.props.auth.user.name }}</p>
        <p class="text-sm text-gray-300">{{ $page.props.auth.user.role }}</p>
  
        <nav class="mt-6 space-y-2">
          <Link href="/dashboard" class="block hover:text-yellow-400">Dashboard</Link>
          <!-- Add more links based on role -->
        </nav>
  
        <form @submit.prevent="logout" class="mt-6">
          <button type="submit" class="text-red-400 hover:text-red-600">Logout</button>
        </form>
      </aside>
  
      <!-- Main content -->
      <main class="flex-1 p-6 bg-gray-100">
        <slot />
      </main>
    </div>
  </template>
  
  <script setup>
  import { useForm, Link } from '@inertiajs/vue3'
  
  const form = useForm({})
  const logout = () => form.post(route('logout'))
  </script>
  