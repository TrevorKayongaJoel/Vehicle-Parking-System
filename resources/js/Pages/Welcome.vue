<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
}>();
</script>

<template>
  <!-- Background wrapper with image -->
  <div
    class="relative min-h-screen bg-cover bg-center bg-no-repeat flex flex-col items-center justify-center text-white"
    style="background-image: url('/images/carpark2.jpg')"
  >
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/70 backdrop-brightness-75 z-0"></div>

    <!-- Content on top of overlay -->
    <div class="relative z-10 flex flex-col items-center justify-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-6xl font-bold text-blue-400 mb-4 text-center">
            🚗 Vehicle Parking Management System 🚗
        </h1>

        <p class="mb-8 text-red-400 md:text-2xl">
            Manage vehicles, view parking slots, and monitor usage in real-time.
        </p>

      <div class="flex gap-6 ">
        <Link
          v-if="canLogin"
          :href="route('login')"
          class="bg-blue-500 text-white text-xl px-5 py-2 rounded hover:bg-blue-600"
        >
          Login
        </Link>
        <Link
          v-if="canRegister"
          :href="route('register')"
          class="bg-green-500 text-white text-xl px-5 py-2 rounded hover:bg-green-600"
        >
          Register
        </Link>
      </div>
    </div>
  </div>
</template>
