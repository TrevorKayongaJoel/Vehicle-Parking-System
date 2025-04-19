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
    <!-- Overlay - lighter with gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/60 backdrop-filter backdrop-blur-sm z-0"></div>
    
    <!-- Content on top of overlay -->
    <div class="relative z-10 flex flex-col items-center justify-center max-w-4xl px-4">
      <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-6xl font-bold text-white mb-4 text-center">
        <span class="text-blue-300">Vehicle Parking</span> Management System
      </h1>
      
      <p class="mb-8 text-gray-100 md:text-2xl text-center font-light">
        Manage vehicles, view parking slots, and monitor usage in real-time.
      </p>
      
      <div class="flex gap-6 flex-wrap justify-center">
        <Link
          v-if="canLogin"
          :href="route('login')"
          class="bg-blue-600 text-white text-xl px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg"
        >
          Sign In
        </Link>
        
        <Link
          v-if="canRegister"
          :href="route('register')"
          class="bg-emerald-600 text-white text-xl px-6 py-3 rounded-lg hover:bg-emerald-700 transition duration-300 shadow-lg"
        >
          Create Account
        </Link>
      </div>
      
      
    </div>
    
   
  </div>
</template>