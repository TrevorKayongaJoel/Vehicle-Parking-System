<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { useForm, Link, router } from '@inertiajs/vue3'

const props = defineProps({ users: Object })

const editingUser = ref(null)

const editForm = useForm({
  name: '',
  email: '',
  role: '',
})

const openEdit = (user) => {
  editingUser.value = user
  editForm.name = user.name
  editForm.email = user.email
  editForm.role = user.role
}

const submitEdit = () => {
  editForm.put(route('admin.users.update', editingUser.value.id), {
    onSuccess: () => {
      editingUser.value = null
      router.visit(route('admin.users')) // refresh full page
    },
  })
}

</script>

<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-4">User Management</h1>
    <table class="table-auto w-full">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Name</th>
          <th class="p-2">Email</th>
          <th class="p-2">Role</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="p-2">{{ user.name }}</td>
          <td class="p-2">{{ user.email }}</td>
          <td class="p-2">{{ user.role }}</td>
          <td class="p-2">
            <button @click="openEdit(user)" class="text-blue-600 text-sm hover:underline">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Edit dialog - only shown when editingUser is not null -->
    <div v-if="editingUser" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Edit User</h2>
        <form @submit.prevent="submitEdit">
          <div class="mb-2">
            <label class="block text-sm font-medium">Name</label>
            <input v-model="editForm.name" class="w-full p-2 border rounded" />
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Email</label>
            <input v-model="editForm.email" class="w-full p-2 border rounded" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Role</label>
            <select v-model="editForm.role" class="w-full p-2 border rounded">
              <option value="admin">Admin</option>
              <option value="attendant">Attendant</option>
            </select>
          </div>

          <div class="flex justify-end space-x-2">
            <button type="button" @click="editingUser = null" class="text-gray-500">Cancel</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>