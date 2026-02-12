<script setup lang="ts">
import {useAuthStore} from "../stores/auth"
import {useRouter} from "vue-router"
import {ref} from "vue";

const auth = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')

const handleLogin = async () => {
  try {
    await auth.login({email: email.value, password: password.value})
    await router.push('/')
  } catch (error) {
    console.log('Ошибка проверьте данные');
  }
}

</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
      <h2 class="text-center text-3xl font-extrabold text-gray-900">Вход в Прыпынак</h2>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <input v-model="email" type="email" placeholder="Email"
               class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none"/>
        <input v-model="password" type="password" placeholder="Пароль"
               class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none"/>
        <button type="submit"
                class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
          ВОЙТИ
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>

</style>