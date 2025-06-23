<template>
    <div class="bg-white rounded-xl shadow-lg p-8 space-y-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-800">Вход в систему</h2>
        <form @submit.prevent="login" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    v-model="email"
                    type="email"
                    placeholder="you@example.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-light transition"
                />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Пароль</label>
                <input
                    v-model="password"
                    type="password"
                    placeholder="••••••••"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-light transition"
                />
            </div>
            <button
                type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105"
            >
                Войти
            </button>
        </form>
        <p v-if="error" class="text-center text-red-500">{{ error }}</p>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return { email: '', password: '', error: null };
    },
    methods: {
        async login() {
            this.error = null;
            try {
                const { data } = await axios.post('/api/login', { email: this.email, password: this.password });
                this.$emit('logged-in', data.token);
            } catch (e) {
                this.error = e.response?.data?.message || 'Ошибка входа';
            }
        },
    },
};
</script>
