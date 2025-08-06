<template>
  <div class="filling-form">
    <h2>Залить молоко</h2>
    <div v-if="errorMessage" class="error-message">
      {{ errorMessage }}
    </div>

    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="username">Кто залил:</label>
        <input
          type="text"
          id="username"
          v-model="form.username"
          required
          :disabled="isSubmitting"
        />
      </div>
      <div class="form-group">
        <label for="volume">Количество (л):</label>
        <input
          type="number"
          id="volume"
          v-model="form.volume"
          required
          min="1"
          max="300"
          :disabled="isSubmitting"
        />
      </div>
      <button type="submit" :disabled="isSubmitting">
        {{ isSubmitting ? "Заливаю..." : "Залить" }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, defineEmits } from "vue";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Определяем реактивные переменные и события
const emits = defineEmits(["milk-filled"]);

const form = ref({
  username: "",
  volume: 1,
});

// Новые реактивные переменные для состояния
const isSubmitting = ref(false);
const errorMessage = ref("");

const submitForm = async () => {
  // Перед отправкой запроса
  isSubmitting.value = true;
  errorMessage.value = ""; // Очищаем старые ошибки

  try {
    // Отправляем POST-запрос на сервер
    const response = await fetch(API_BASE_URL + "/tanks/fill", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(form.value),
    });
    const data = await response.json();

    if (response.ok) {
      // Успешно залили молоко, очищаем форму
      form.value.username = "";
      form.value.volume = 1;
      // Вызываем событие milk-filled для обновления статистики
      emits("milk-filled");
    } else {
      // Ошибка от сервера
      errorMessage.value = data.error || "Неизвестная ошибка на сервере.";
    }
  } catch (error) {
    // Ошибка сети или другая техническая ошибка
    console.error("Ошибка при отправке данных:", error);
    errorMessage.value =
      "Произошла ошибка при отправке данных. Проверьте соединение.";
  } finally {
    // После завершения запроса, вне зависимости от результата
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
.filling-form {
  width: 25%;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}
.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}
label {
  margin-bottom: 5px;
  font-weight: bold;
}
input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
button {
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:disabled {
  background-color: #a5d6a7;
  cursor: not-allowed;
}

.error-message {
  margin-bottom: 15px;
  padding: 10px;
  background-color: #f44336;
  color: white;
  border-radius: 4px;
  text-align: left;
}
</style>
