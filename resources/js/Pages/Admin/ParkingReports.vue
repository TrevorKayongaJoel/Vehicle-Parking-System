<script setup>
const props = defineProps({
  reports: Array,
  filter: String
})
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Parking Reports ({{ props.filter }})</h1>

    <table class="w-full border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2">Date</th>
          <th class="p-2">Total Check-ins</th>
          <th class="p-2">Revenue</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="r in reports" :key="r.period">
          <td class="p-2">{{ r.period }}</td>
          <td class="p-2">{{ r.total_checkins }}</td>
          <td class="p-2">UGX {{ Math.round(r.total_revenue).toLocaleString()}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
