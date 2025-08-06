<template>
  <div id="app">
    <h1>Система учета молока</h1>

    <FillingForm @milk-filled="fetchStats" />

    <div class="stats-container">
      <TankStats :tanks="tanks" />
      <FillingHistory :history="fillingHistory" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import FillingForm from "./components/FillingForm.vue";
import TankStats from "./components/TankStats.vue";
import FillingHistory from "./components/FillingHistory.vue";

// Состояния для хранения данных о цистернах и истории заполнений
const tanks = ref([]);
const fillingHistory = ref([]);

// Базовый URL API и конечные точки
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const ENDPOINTS = {
  TANKS_STATS: `${API_BASE_URL}/tanks/tanks-stats`,
  FILLINGS_HISTORY: `${API_BASE_URL}/tanks/fillings-history`,
};
// Функция для получения статистики цистерн и истории заполнений
const fetchStats = async () => {
  try {
    // Выполняем запросы параллельно с помощью Promise.all
    const [tanksResponse, historyResponse] = await Promise.all([
      fetch(ENDPOINTS.TANKS_STATS),
      fetch(ENDPOINTS.FILLINGS_HISTORY),
    ]);

    const tanksData = await tanksResponse.json();
    const historyData = await historyResponse.json();

    tanks.value = tanksData.tanks_stats;
    fillingHistory.value = historyData.fillings_history;
  } catch (error) {
    console.error("Ошибка при получении данных:", error);
  }
};

// Вызываем fetchStats при монтировании компонента и при событии milk-filled
onMounted(fetchStats);
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.stats-container {
  display: flex;
  justify-content: space-around;
  margin-top: 40px;
}
</style>
