<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation');
    },
  });
};
</script>

<template>
  <Head title="Register" />
  
  <div class="flex h-screen w-screen items-center justify-center relative overflow-hidden">
    <!-- Blurred background image -->
    <div
      class="absolute inset-0 w-full h-full bg-cover bg-center"
      style="background-image: url('/images/carpark2.jpg'); filter: blur(6px);"
    ></div>
    
    <!-- Dark overlay for better readability -->
    <div class="absolute inset-0 bg-black/40"></div>
    
    <!-- Centered registration container -->
    <div class="w-full max-w-md px-8 py-10 bg-white/90 rounded-lg shadow-xl z-10">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>
        <p class="text-gray-600 mt-2">Sign up to start managing your parking</p>
      </div>
      
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <InputLabel for="name" class="!text-black" value="Name" />
          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
          />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>
        
        <div>
          <InputLabel for="email" class ="!text-black" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        
        <div>
          <InputLabel class="!text-black" for="password" value="Password" />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        
        <div>
          <InputLabel class="!text-black" for="password_confirmation" value="Confirm Password" />
          <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>
        
        <div class="flex items-center justify-between pt-4">
          <Link
            :href="route('login')"
            class="text-sm text-blue-600 underline hover:text-blue-800"
          >
            Already registered?
          </Link>
          
          <PrimaryButton
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Register
          </PrimaryButton>
        </div>
      </form>
    </div>
  </div>
</template>