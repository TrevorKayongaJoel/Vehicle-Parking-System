<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
  canResetPassword?: boolean;
  status?: string;
}>();

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password');
    },
  });
};
</script>

<template>
  <Head title="Log in" />
  
  <div class="flex h-screen w-screen items-center justify-center relative overflow-hidden">
    <!-- Blurred background image -->
    <div
      class="absolute inset-0 w-full h-full bg-cover bg-center"
      style="background-image: url('/images/carpark2.jpg'); filter: blur(6px);"
    ></div>
    
    <!-- Dark overlay for better readability -->
    <div class="absolute inset-0 bg-black/40"></div>
    
    <!-- Centered login container -->
    <div class="w-full max-w-md px-8 py-10 bg-white/90 rounded-lg shadow-xl z-10">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-black">Welcome Back</h1>
        <p class="text-black mt-2">Sign in to access your parking account</p>
      </div>
      
      <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
      </div>
      
      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <InputLabel for="email" class ="!text-black" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full text-black"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        
        <div>
          <InputLabel for="password" class="!text-black" value="Password" />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full text-black"
            v-model="form.password"
            required
            autocomplete="current-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        
        <div class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <label class="ml-2 text-sm text-black">Remember me</label>
        </div>
        
        <div class="flex items-center justify-between pt-2">
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm text-blue-600 underline hover:text-blue-800"
          >
            Forgot your password?
          </Link>
          
          <PrimaryButton
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Log in
          </PrimaryButton>
        </div>
      </form>
      
      <div class="text-center mt-6 text-sm text-gray-600">
        Don't have an account? 
        <Link :href="route('register')" class="text-blue-600 hover:underline">
          Register here
        </Link>
      </div>
    </div>
  </div>
</template>