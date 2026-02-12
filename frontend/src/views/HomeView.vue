<script setup lang="ts">
import {useAuthStore} from '../stores/auth'
import {useRouter} from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

const handleLogout = () => {
  auth.logout()
  router.push('/login')
}
</script>

<template>
  <div class="p-6 max-w-md mx-auto">
    <div v-if="auth.isLoggedIn" class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
      <h1 class="text-xl font-bold mb-2">С возвращением, {{ auth.user?.name || 'Друг' }}!</h1>
      <p class="text-gray-600 mb-6 text-sm">Ты успешно авторизован в системе Прыпынак.</p>

      <button @click="handleLogout"
              class="w-full py-3 bg-red-50 text-red-600 rounded-xl font-medium hover:bg-red-100 transition">
        ВЫЙТИ ИЗ АККАУНТА
      </button>
    </div>

    <div v-else class="text-center">
      <h1 class="text-2xl font-bold mb-4">Главная страница</h1>
      <router-link to="/login" class="text-blue-600 font-medium">Войти, чтобы добавить остановки</router-link>
    </div>
  </div>
</template>

<style scoped>

</style>