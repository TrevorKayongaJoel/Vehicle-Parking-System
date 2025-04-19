<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import axios from 'axios'


const todayCheckins = ref(0)
const todayRevenue = ref(0)

const fetchSummary = async () => {
  try {
    const res = await axios.get('/admin/dashboard-summary') // ✅ make sure this matches your route
    todayCheckins.value = res.data.todayCheckins
    todayRevenue.value = res.data.todayRevenue
  } catch (e) {
    console.error('Failed to fetch dashboard summary:', e)
  }
}

onMounted(() => {
  fetchSummary()
  setInterval(fetchSummary, 30000) // refresh every 30 seconds
})

const chartCanvas = ref(null)

onMounted(async () => {
  const res = await axios.get('/api/admin/daily-fees')
  const { dates, fees } = res.data

  new Chart(chartCanvas.value, {
    type: 'line',
    data: {
      labels: dates,
      datasets: [
        {
          label: 'Daily Revenue (UGX)',
          data: fees,
          borderColor: '#4F46E5',
          backgroundColor: 'rgba(79, 70, 229, 0.1)',
          fill: true,
          tension: 0.3,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
      },
    },
  })
})
</script>


<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-4">Welcome Admin</h1>

    <!-- 🔄 Manual Refresh Button -->
    <div class="mb-4">
      <button
        @click="fetchSummary"
        class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 transition"
      >
        🔄 Refresh Now
      </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <div class="bg-blue-100 p-4 rounded shadow">
        <h2 class="text-lg font-semibold">Today's Check-ins</h2>
        <p class="text-3xl">{{ todayCheckins }}</p>
      </div>

      <div class="bg-green-100 p-4 rounded shadow">
        <h2 class="text-lg font-semibold">Today's Revenue</h2>
        <p class="text-3xl">UGX {{ Math.round(todayRevenue).toLocaleString() }}</p>

      </div>
    </div>

    <!-- Admin Links -->
    <div class="space-y-2">
      <Link href="/admin/users" class="text-blue-600 hover:underline">
        ➕ Manage Users
      </Link></div>
      <br />
      <div><Link href="/admin/reports" class="text-purple-600 hover:underline">
        📊 View Full Parking Reports
      </Link>
    </div>
    <br />
    <!-- <h1 class="text-2xl font-bold mb-6">📊 Daily Revenue Trend</h1>

<div class="bg-white rounded shadow p-4">
  <canvas ref="chartCanvas"></canvas>
</div> -->
  </AppLayout>
</template>

