<template>
    <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Введите домены</label>
            <div class="flex">
        <textarea
            v-model="input"
            rows="4"
            class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary transition"
            placeholder="one.com, two.net или с новой строки"
        ></textarea>
                <button
                    @click="startCheck"
                    :disabled="parseDomains().length === 0"
                    class="px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-r-lg shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed transition-transform transform hover:scale-105"
                >
                    Проверить
                </button>
            </div>
        </div>

        <ul v-if="results.length" class="space-y-4">
            <li
                v-for="r in results"
                :key="r.domain"
                class="bg-gray-50 p-4 rounded-lg shadow-md flex justify-between items-center"
            >
                <span class="font-medium text-gray-800">{{ r.domain }}</span>
                <span v-if="r.loading" class="text-gray-500">⏳ Проверка...</span>
                <span v-else-if="r.error" class="text-red-500">{{ r.error }}</span>
                <span v-else-if="r.available" class="text-green-600">✔️ Доступен</span>
                <span v-else class="text-gray-700">❌ Занят до {{ r.expires_at }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['token'],
    data() {
        return {
            input: '',
            results: []
        };
    },
    methods: {
        parseDomains() {
            return Array.from(
                new Set(
                    this.input
                        .split(/[^a-z0-9\.]+/i)
                        .map(d => d.trim().toLowerCase())
                        .filter(d => d)
                )
            );
        },
        async startCheck() {
            const domains = this.parseDomains();
            this.results = domains.map(domain => ({
                domain,
                loading: true,
                error: null,
                available: null,
                expires_at: null
            }));

            await Promise.all(
                domains.map(async domain => {
                    const idx = this.results.findIndex(r => r.domain === domain);
                    try {
                        const { data } = await axios.post(
                            '/api/check-domain',
                            { domain },
                            { headers: { Authorization: `Bearer ${this.token}` } }
                        );
                        Object.assign(this.results[idx], {
                            loading: false,
                            available: data.available,
                            expires_at: data.expires_at
                        });
                    } catch (e) {
                        const isValidationError = e.response?.status === 422;
                        Object.assign(this.results[idx], {
                            loading: false,
                            error: isValidationError
                                ? 'Неверный формат домена'
                                : e.response?.data?.error || 'Ошибка'
                        });
                    }
                })
            );
        }
    }
};
</script>
