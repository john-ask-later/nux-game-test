<script setup>
defineProps({
    is_win: Boolean,
    num: Number,
    score: Number,
    amount: Number,
    landing_hash_id: String,
    amount_in_usd: String,
})
</script>

<template>
    <div class="p-4 mb-4 text-lg rounded-lg"
         :class="[is_win ? 'bg-blue-50 text-blue-800' : 'bg-yellow-50 text-yellow-800']" role="alert">
        <template v-if="is_win">
            You won <span class="font-medium">{{ amount_in_usd }}</span> within {{ score }} score
        </template>
        <template v-else>
            Your score <span class="underline">{{ score }}</span>. Good luck next time...
        </template>
    </div>
</template>
