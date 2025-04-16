<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Parking Slots</h1>

    <!-- Grid of parking slots -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div
        v-for="slot in slots"
        :key="slot.id"
        class="p-4 rounded shadow text-center cursor-pointer"
        :class="slot.is_occupied ? 'bg-red-200' : 'bg-green-200'"
      >
        <h2 class="font-semibold text-lg">Slot #{{ slot.id }}</h2>
        <p>Status:
          <span :class="slot.is_occupied ? 'text-red-600' : 'text-green-700'">
            {{ slot.is_occupied ? 'Occupied' : 'Available' }}
          </span>
        </p>

        <button
          v-if="!slot.is_occupied"
          @click="openCheckIn(slot)"
          class="mt-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700"
        >
          Check In
        </button>

        <button
          v-else
          @click="checkOut(slot.id)"
          class="mt-2 px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700"
        >
          Check Out
        </button>
      </div>
    </div>

    <!-- Check-in Modal/Form -->
    <div v-if="selectedSlot" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white p-6 rounded shadow w-full max-w-md relative">
        <button @click="selectedSlot = null" class="absolute top-2 right-3 text-gray-500 hover:text-red-600">&times;</button>
        <h2 class="text-xl font-bold mb-4">Check In to Slot #{{ selectedSlot.id }}</h2>

        <form @submit.prevent="submitCheckIn">
          <div class="mb-4">
            <label class="block mb-1 text-sm font-semibold">Vehicle Number</label>
            <input
              v-model="form.vehicle_number"
              type="text"
              class="w-full border p-2 rounded"
              placeholder="Enter vehicle number"
              required
            />
          </div>
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Confirm Check In
          </button>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  slots: {
    type: Array,
    default: () => [],
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
  form.post('/attendant/check-in', {
    onSuccess: () => {
      selectedSlot.value = null
      router.reload({ only: ['slots'] })
    }
  })
}

const checkOut = (slotId) => {
  router.post('/attendant/check-out', { slot_id: slotId }, {
    onSuccess: () => router.reload({ only: ['slots'] })
  })
}
</script>
