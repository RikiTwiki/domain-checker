<template>
    <div class="min-h-screen bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center p-4">
        <div class="w-full max-w-lg">
            <div v-if="!token" class="animate-fade-in">
                <Login @logged-in="setToken" />
            </div>
            <div v-else class="bg-white rounded-xl shadow-xl p-6 animate-fade-in">
                <div class="flex justify-end mb-4">
                    <button
                        @click="logout"
                        class="text-primary hover:text-primary-dark font-medium"
                    >Выйти</button>
                </div>
                <DomainChecker :token="token" />
            </div>
        </div>
    </div>
</template>

<script>
import Login from './Login.vue';
import DomainChecker from './DomainChecker.vue';

export default {
    components: { Login, DomainChecker },
    data() {
        return { token: localStorage.getItem('api_token') };
    },
    methods: {
        setToken(token) {
            this.token = token;
            localStorage.setItem('api_token', token);
        },
        logout() {
            localStorage.removeItem('api_token');
            this.token = null;
        },
    },
};
</script>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
.animate-fade-in { animation: fade-in 0.5s ease-in-out; }
</style>
