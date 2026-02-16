<script setup lang="ts">
import {computed, onMounted, ref} from 'vue'
import api from '../api'

import Button from 'primevue/button'
import ProgressSpinner from 'primevue/progressspinner'
import InputText from 'primevue/inputtext'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'

const stops = ref<any[]>([])
const loading = ref(true)
const searchQuery = ref('')

onMounted(async () => {
  try {
    const { data } = await api.get('stops')
    stops.value = data.data
  } catch (e) {
    console.error('Ошибка загрузки', e)
  } finally {
    loading.value = false
  }
})

const filteredStops = computed(() => {
  return stops.value.filter(stop =>
    stop.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})
</script>

<template>
  <div class="p-0 md:p-4 max-w-2xl mx-auto bg-white min-h-screen">
    <div class="p-4 space-y-4">
      <h1 class="text-2xl font-black text-slate-800 tracking-tight">Прыпынак 🚌</h1>

      <IconField>
        <InputIcon class="pi pi-search" />
        <InputText
          v-model="searchQuery"
          placeholder="Найти остановку..."
          class="w-full !rounded-xl !bg-slate-100 !border-none focus:!bg-white focus:!shadow-md transition-all"
        />
      </IconField>
    </div>

    <!-- Загрузка -->
    <div v-if="loading" class="flex justify-center p-12">
      <ProgressSpinner style="width: 40px; height: 40px" />
    </div>

    <div v-else class="flex flex-col">
      <div
        v-for="stop in filteredStops"
        :key="stop.id"
        class="group flex items-center justify-between p-4 hover:bg-slate-50 active:bg-slate-100 cursor-pointer transition-colors border-b border-slate-50"
      >
        <div class="flex items-center space-x-4">
          <div
            class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"
          >
            <i class="pi pi-map-marker text-sm"></i>
          </div>

          <div>
            <div class="text-base font-semibold text-slate-800">{{ stop.name }}</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider">Могилёв</div>
          </div>
        </div>

        <div class="flex items-center">
          <Button
            text
            rounded
            class="!w-10 !h-10 !p-0 !min-w-0 flex items-center justify-center !text-amber-400 cursor-pointer"
          >
            <i class="pi pi-star-fill text-lg"></i>
          </Button>

          <i class="pi pi-chevron-right text-slate-300 ml-1 text-[10px]"></i>
        </div>
      </div>

      <div v-if="filteredStops.length === 0" class="p-12 text-center text-slate-400">
        <p>Остановка не найдена. Попробуйте другое название.</p>
      </div>
    </div>
  </div>
</template>
