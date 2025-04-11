<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

defineProps({ slots: Array })

const form = useForm({
  vehicle_number: '',
  slot_id: '',
})
</script>

<template>
  <AppLayout>
    <h2 class="text-2xl font-bold mb-4">Vehicle Check-In</h2>

    <form @submit.prevent="form.post('/attendant/check-in')" class="space-y-4 max-w-md">
      <div>
        <label class="block font-semibold">Vehicle Number</label>
        <input v-model="form.vehicle_number" type="text" class="w-full border p-2 rounded" />
        <div v-if="form.errors.vehicle_number" class="text-red-600 text-sm">{{ form.errors.vehicle_number }}</div>
      </div>

      <div>
        <label class="block font-semibold">Choose Slot</label>
        <select v-model="form.slot_id" class="w-full border p-2 rounded">
          <option disabled value="">-- select slot --</option>
          <option 
            v-for="slot in slots.filter(s => !s.is_occupied)" 
            :value="slot.id"
            :key="slot.id"
          >
            {{ slot.slot_number }}
          </option>
        </select>
        <div v-if="form.errors.slot_id" class="text-red-600 text-sm">{{ form.errors.slot_id }}</div>
      </div>

      <button 
        type="submit" 
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        :disabled="form.processing"
      >
        Check In
      </button>
    </form>
  </AppLayout>
</template>
