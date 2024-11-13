<script setup>
import {isArray} from "lodash";

defineProps({
    message: {
        type: [String, Array],
    },
});
</script>

<template>
    <div v-show="message">
        <div class="text-sm text-red-600">
            <ul v-if="isArray(message)">
                <li v-for="line in message" v-html="line"></li>
            </ul>
            <p v-else v-html="message"></p>
        </div>
    </div>
</template>
