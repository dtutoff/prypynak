<script setup lang="ts">
import {onMounted, ref} from 'vue'
import api from '../api'
import Card from 'primevue/card'
import Button from 'primevue/button'
import ProgressSpinner from 'primevue/progressspinner'

const stops = ref<any[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const { data } = await api.get('stops')
    console.log(data)
    stops.value = data.data
  } catch (e) {
    console.error('Ошибка загрузки', e)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="p-4 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">Остановки Могилёва 🚌</h1>
      <Button icon="pi pi-refresh" rounded aria-label="Filter" @click="location.reload()" />
    </div>

    <!-- Загрузка -->
    <div v-if="loading" class="flex justify-center p-12">
      <ProgressSpinner style="width: 50px; height: 50px" />
    </div>

    <!-- Список карточек -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <Card
        v-for="stop in stops"
        :key="stop.id"
        class="!rounded-2xl !shadow-none !border !border-gray-100 hover:!bg-gray-50 transition-colors cursor-pointer"
      >
        <template #title>
          <div class="text-lg font-semibold">{{ stop.name }}</div>
        </template>
        <template #content>
          <p class="text-sm text-slate-500 italic">Нажми, чтобы увидеть расписание</p>
        </template>
        <template #footer>
          <div class="flex gap-2 justify-end">
            <Button icon="pi pi-heart" severity="secondary" text rounded />
            <Button label="Открыть" outlined size="small" />
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>
