<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SpinResult from '@/Components/SpinResult.vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {reactive} from "vue";
import {assign} from "lodash";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const page = usePage();

let props = defineProps({
    hashId: String,
    timeLeft: String,
    newHashId: [String, null]
});

const lastSpin = reactive({
    score: 0,
    amount: 0.0,
    amount_in_usd: '',
    is_win: true,
    landing_hash_id: '',
    num: 0,
    exists: false
});

let spin = () => {
    axios
        .post(route('spin.create', props.hashId))
        .then((response) => {
            assign(lastSpin, response.data.spin);
            lastSpin.exists = true;
            history.exists = false;
        });
}

let newLink = () => {
    router.post(route('landing.regenerate', props.hashId), {
        preserveState: true,
    })
}

const history = reactive({spins: [], exists: false});

let getHistory = () => {
    axios
        .get(route('spin.history', props.hashId))
        .then((response) => {
            history.spins = response.data.spins;
            history.exists = true;
        })
}

let exit = () => {
    router.delete(route('landing.deactivate', props.hashId));
}

</script>

<template>
    <BaseLayout>
        <Head title="Log in"/>

        <template v-slot:history>
            <SecondaryButton class="self-center" @click="getHistory">
                History
            </SecondaryButton>
            <SecondaryButton class="self-center" @click="newLink">
                Get new link
            </SecondaryButton>
            <DangerButton class="self-center normal-case" @click="exit">
                Exit
            </DangerButton>
        </template>

        <div
            class="flex flex-col mt-6 mx-auto w-full min-h-80 overflow-hidden bg-white px-6 pt-4 shadow-md shadow-gray-300 drop-shadow-lg sm:max-w-3xl sm:rounded-lg"
        >
            <div class="w-100 py-2 rounded-lg bg-gray-100 text-sm text-center mb-10">
                {{ timeLeft }} your lucky page gets expired, don't miss your chance!
            </div>

            <div class="w-full text-center mb-auto">
                <PrimaryButton class="py-7 px-12 text-xl w-full md:w-auto" @click="spin">
                    Imfeelinglucky
                </PrimaryButton>
            </div>

            <div v-if="lastSpin.exists" class="w-full mt-10">
                <SpinResult v-bind="lastSpin">

                </SpinResult>
            </div>
        </div>

        <div
            v-if="newHashId"
            class="mt-6 mx-auto w-full overflow-hidden bg-gray-50 px-6 py-4 shadow-sm shadow-gray-100 drop-shadow-md sm:max-w-3xl sm:rounded-lg"
        >
            You new lucky page just arrived:
            <Link :href="route('landing.show', newHashId)" class="underline text-gray-900">
                click here to start
            </Link>
        </div>

        <div
            v-if="history.exists"
            class="mt-6 mx-auto w-full overflow-hidden bg-white bg-opacity-60 shadow-sm shadow-gray-300 drop-shadow-sm sm:max-w-3xl sm:rounded-lg"
        >
            <div class="relative overflow-x-auto">
                <div class="px-6 py-4 text-sm text-gray-700 font-semibold bg-gray-100 border-b border-gray-200">
                    Small insights on your latest spins
                </div>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Try #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Score
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <slot v-if="history.spins.length > 0">
                        <tr v-for="spin in history.spins" class="border-b"
                            :class="{'bg-blue-50 text-blue-800': spin.is_win, 'bg-yellow-50 text-yellow-800': !spin.is_win}">
                            <td class="px-6 py-4">
                                {{ spin.num }}
                            </td>
                            <td class="px-6 py-4">
                                {{ spin.score }}
                            </td>
                            <td class="px-6 py-4" v-html="spin.is_win ? spin.amount_in_usd : 'Not today...'">

                            </td>
                        </tr>
                    </slot>
                    <slot v-else>
                        <tr>
                            <td colspan="3" class="bg-indigo-200 px-6 py-4">You must click "Imfeelinglucky" first</td>
                        </tr>
                    </slot>
                    </tbody>
                </table>
            </div>
        </div>
    </BaseLayout>
</template>

