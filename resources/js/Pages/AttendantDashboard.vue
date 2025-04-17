<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps({
  slots: {
    type: Array,
    default: () => [],
  }
})

const selectedSlot = ref(null)
const checkoutResult = ref(null)

const form = useForm({
  vehicle_number: '',
  slot_id: null,
})

const openCheckIn = (slot) => {
  form.vehicle_number = ''
  form.slot_id = slot.id
  selectedSlot.value = slot
}

const submitCheckIn = () => {
  form.post(route('parking.checkin'), {
    onSuccess: () => {
      selectedSlot.value = null
      router.reload({ only: ['slots'] })
    },
  })
}

const checkOut = (slotId) => {
  router.post(route('parking.checkout'), { slot_id: slotId }, {
    preserveScroll: true,
    preserveState: true, // ✅ ADD THIS
    onFinish: () => {
      const flash = page.props.flash

      console.log('FLASH from usePage():', flash)

      const message = flash?.success || ''
      const fee = flash?.fee
      const duration = flash?.duration_minutes

      if (fee !== undefined && duration !== undefined) {
        checkoutResult.value = { message, fee, duration }
      }

      router.reload({ only: ['slots'] })

      setTimeout(() => {
        checkoutResult.value = null
      }, 7000)
    }
  })
}
</script>

<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">Parking Slots</h1>

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

    <!-- Check-in Modal -->
    <div
      v-if="selectedSlot"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Check In - Slot #{{ selectedSlot.id }}</h2>
        <form @submit.prevent="submitCheckIn">
          <label class="block mb-2 text-sm font-medium">Vehicle Number</label>
          <input
            v-model="form.vehicle_number"
            class="w-full p-2 border rounded mb-4"
            placeholder="Enter vehicle number"
            required
          />

          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="selectedSlot = null"
              class="text-gray-500"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
              Check In
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Checkout Feedback -->
    <div
      v-if="checkoutResult"
      class="mt-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded max-w-md mx-auto"
    >
      <p class="font-semibold">{{ checkoutResult.message }}</p>
      <p> Duration: {{ checkoutResult.duration }} minutes</p>
      <p> Fee: ${{ checkoutResult.fee }}</p>
    </div>
  </AppLayout>
</template>
