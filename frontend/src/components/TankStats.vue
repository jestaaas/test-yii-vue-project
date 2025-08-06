<template>
  <div class="tank-stats">
    <h2>Текущее состояние цистерн</h2>
    <div v-if="tanks.length > 0" class="tanks-grid">
      <div v-for="tank in tanks" :key="tank.id" class="tank-card">
        <!-- Отображаем информацию о каждой цистерне -->
        <h3>Цистерна #{{ tank.id }}</h3>
        <p>Заполнено: {{ tank.current_volume }} л</p>
        <p>Свободно: {{ 300 - tank.current_volume }} л</p>
        <div class="progress-bar-container">
          <div
            class="progress-bar"
            :style="{ width: (tank.current_volume / 300) * 100 + '%' }"
          ></div>
        </div>
      </div>
    </div>
    <p v-else>Данные о цистернах загружаются...</p>
  </div>
</template>

<script setup>
import { defineProps } from "vue";

// Определяем свойства, которые будут переданы в компонент
defineProps({
  tanks: {
    type: Array,
    required: true,
  },
});
</script>

<style scoped>
.tank-stats {
  width: 45%;
}
.tanks-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 20px;
}
.tank-card {
  border: 1px solid #ccc;
  padding: 15px;
  border-radius: 8px;
  background-color: #f9f9f9;
}
.progress-bar-container {
  width: 100%;
  height: 20px;
  background-color: #e0e0e0;
  border-radius: 5px;
  overflow: hidden;
  margin-top: 10px;
}
.progress-bar {
  height: 100%;
  background-color: #4caf50;
  transition: width 0.5s ease-in-out;
}
</style>
