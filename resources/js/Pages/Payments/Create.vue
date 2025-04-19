<template>
    <AppLayout>
      <h1 class="text-2xl font-bold mb-6">Cash Payment</h1>
  
      <form @submit.prevent="form.post(route('payments.store'),{
  onSuccess: () => form.reset()
})" class="space-y-4 max-w-xl">
        <div>
          <label>Type</label>
          <select v-model="form.type" class="form-control w-full">
            <option value="cash">Cash</option>
            <option value="fake">Fake</option>
          </select>
        </div>
  
        <div>
          <label>Amount</label>
          <input type="number" v-model="form.amount" class="form-control w-full" step="0.01" />
        </div>
  
        <div>
          <label>Parking Slot</label>
          <p class="font-semibold text-gray-700">
            {{ getSlotName(form.slot_id) || 'Slot ID: ' + form.slot_id }}
          </p>
          <input type="hidden" v-model="form.slot_id" />
        </div>
  
        <div>
          <label>Notes</label>
          <textarea v-model="form.notes" class="form-control w-full"></textarea>
        </div>


        <div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>

        </div>
      </form>
      <div v-if="page.props.flash?.status" class="text-green-600 font-semibold mt-4">
  {{ page.props.flash.status }}
</div>

      <div v-if="page.props.flash?.error" class="text-red-600 font-semibold mt-4">
        {{ page.props.flash.error }}
      </div>


    </AppLayout>
  </template>
  
  <script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

const page = usePage()
const slots = page.props.slots
const defaultSlotId = page.props.slot_id ?? ''

const form = useForm({
  type: 'cash',
  amount: page.props.amount ?? '',
  slot_id: '',
  notes: '',
})

// Auto-fill slot_id from props
watchEffect(() => {
  if (!form.slot_id && page.props.slot_id) {
    form.slot_id = page.props.slot_id
  }
})

const getSlotName = (id) => {
  const slot = slots.find((s) => s.id === id)
  return slot ? slot.name : null
}

// ✅ Controlled submission with delay before reset
const submitForm = () => {
  form.post(route('payments.store'), {
    onSuccess: () => {
      setTimeout(() => {
        form.reset()
      }, 3000) // wait 3s so flash message is seen
    }
  })
}
</script>
  