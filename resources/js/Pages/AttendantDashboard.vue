<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Parking Slots</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div v-for="slot in slots" :key="slot.id" class="p-4 rounded shadow text-center cursor-pointer" :class="slot.is_occupied ? 'bg-red-200' : 'bg-green-200'">
        <h2 class="font-semibold text-lg">Slot #{{ slot.id }}</h2>
        <p>Status: <span :class="slot.is_occupied ? 'text-red-600' : 'text-green-700'">
          {{ slot.is_occupied ? 'Occupied' : 'Available' }}
        </span></p>

        <button v-if="!slot.is_occupied" @click="openCheckIn(slot)" class="mt-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
          Check In
        </button>
        <p v-else class="text-sm mt-2 italic text-gray-600">In use</p>
      </div>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
  slots: {
    type: Array,
    default: () => [], // Ensure it's always an array
  }
})

const form = useForm({
  vehicle_number: '',
  slot_id: null,
})

const selectedSlot = ref(null)

const openCheckIn = (slot) => {
  form.vehicle_number = ''
  form.slot_id = slot.id
  selectedSlot.value = slot
}

const submitCheckIn = () => {
  form.post(route('parking.checkin'), {
    onSuccess: () => {
      selectedSlot.value = null
      router.reload({ only: ['slots'] }) // Refresh slot data
    },
  })
}
</script>
