<template>
  <div class="filling-history">
    <h2>История заливов</h2>
    <div v-if="history.length > 0">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Кто залил</th>
            <th>Номер цистерны</th>
            <th>Объем (л)</th>
          </tr>
        </thead>
        <tbody>
          <!-- выводим данные из базы данных -->
          <tr v-for="historyItem in history" :key="historyItem.id">
            <td>{{ historyItem.id }}</td>
            <td>{{ historyItem.username }}</td>
            <td>{{ historyItem.tank_id }}</td>
            <td>{{ historyItem.volume }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p v-else>История заливов пуста.</p>
  </div>
</template>

<script setup>
import { defineProps } from "vue";

// Определяем свойства, которые будут переданы в компонент
defineProps({
  history: {
    type: Array,
    required: true,
  },
});
</script>

<style scoped>
.filling-history {
  width: 45%;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th,
td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
th {
  background-color: #f2f2f2;
}
</style>
