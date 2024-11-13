<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import InputError from '@/Components/InputError.vue';
import FloatingLabel from '@/Components/FloatingLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {computed} from "vue";

const page = usePage();

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    name: '',
    phone: ''
});

const submit = () => {
    form.post(route('payer.create'), {
        preserveState: true,
        onSuccess: () => form.reset('phone'),
    });
};

let hashId = computed(() => page.props.hashId);
</script>

<template>
    <BaseLayout>
        <Head title="Log in"/>

        <div
            class="mt-6 mx-auto w-full overflow-hidden bg-white px-6 py-4 shadow-md shadow-gray-300 drop-shadow-lg sm:max-w-3xl sm:rounded-lg"
        >
            <form @submit.prevent="submit">
                <div>
                    <FloatingLabel v-model="form.name" :name="'name'">
                        Player name
                    </FloatingLabel>

                    <InputError class="mt-2" :message="form.errors.name"/>
                </div>

                <div class="mt-4">
                    <FloatingLabel v-model="form.phone" :name="'phone'" :id="'test'">
                        Phone number
                    </FloatingLabel>

                    <InputError class="mt-2" :message="form.errors.phone"/>
                </div>

                <div v-if="hashId" class="mt-4 flex flex-col items-start justify-between space-y-5 md:flex-row md:items-end">
                    <span class="text-blue-800 inline-block ">
                        Your link is ready, follow it in navigation bar
                        <i class="fa fa-hand-point-up"></i>
                    </span>
                    <PrimaryButton class="w-full md:w-auto">
                        Create another link
                    </PrimaryButton>
                </div>
                <div class="mt-4" v-else>
                    <PrimaryButton>
                        Get my lucky page
                    </PrimaryButton>
                </div>
            </form>

        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

    </BaseLayout>
</template>
