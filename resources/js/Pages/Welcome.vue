<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Welcome to VPMS" />

  <div class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-white">
    <div class="flex flex-col min-h-screen items-center justify-center px-6">
      <div class="max-w-3xl w-full text-center py-16">

        <div>
        <!-- Header -->
        <h1 class="text-4xl font-bold mb-2">Vehicle Parking Management System</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">
          Automate parking , manage users and monitor revenue with ease.
        </p>
        </div>
        <br>
        <div>
        <!-- Logo -->
        <img
          src="/Pics/pexels-photo-164634.jpeg"
          alt="VPMS Logo"
          class="mx-auto mb-8 h-45 w-auto"
        />
        </div>
        <!-- Action Links -->
        <div class="mt-10 space-y-4 md:space-y-0 md:space-x-4 flex flex-col md:flex-row justify-center">
          <Link
            href="/login"
            class="px-6 py-3 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition"
          >
            Login
          </Link>
          <Link
            href="/register"
            class="px-6 py-3 bg-green-600 text-white rounded shadow hover:bg-green-700 transition"
          >
            Register
          </Link>
          <!-- <Link
            href="/admin-dashboard"
            class="px-6 py-3 bg-purple-600 text-white rounded shadow hover:bg-purple-700 transition"
          >
            Admin Dashboard
          </Link> -->
        </div>

        <!-- Features -->
        <div class="mt-16 grid gap-6 md:grid-cols-2">
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-left">
            <h2 class="text-xl font-semibold mb-2">Manage Parking Slots</h2>
            <p class="text-gray-600 dark:text-gray-400">
              Check-in and check-out vehicles in real-time. Track occupancy and automate slot status.
            </p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-left">
            <h2 class="text-xl font-semibold mb-2">Generate Reports</h2>
            <p class="text-gray-600 dark:text-gray-400">
              Get daily, monthly, and custom reports on usage, revenue, and trends.
            </p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-left">
            <h2 class="text-xl font-semibold mb-2">User Management</h2>
            <p class="text-gray-600 dark:text-gray-400">
              Assign roles, create accounts for attendants and admins, and manage access securely.
            </p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-left">
            <h2 class="text-xl font-semibold mb-2">Mobile-Friendly Access</h2>
            <p class="text-gray-600 dark:text-gray-400">
              Access and operate the system from any device, anytime, anywhere.
            </p>
          </div>
        </div>

        <!-- Footer -->
        <footer class="mt-16 text-sm text-gray-500 dark:text-gray-400">
          © 2025 VPMS. By Group G Day. Built with Laravel and PHP.
        </footer>
      </div>
    </div>
  </div>
</template>
