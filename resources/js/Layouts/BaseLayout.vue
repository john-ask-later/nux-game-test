<script setup>
import {usePage, Link} from '@inertiajs/vue3';
import NavLink from "@/Components/NavLink.vue";
import {computed, ref} from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

const showingNavigationDropdown = ref(false);
const page = usePage();

let hash = computed(() => page.props.hashId);
let playerN = computed(() => page.props.playerN);
</script>

<template>
    <div class="min-h-screen bg-purple-200">
        <nav class="border-b border-gray-100 bg-white">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex w-full overflow-hidden">
                        <!-- Logo -->
                        <div class="flex shrink-0 items-center">
                            <Link :href="'/'" class="hidden lg:block">Nux Gaming</Link>
                            <Link :href="'/'" class="block lg:hidden">N.G.</Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px lg:ms-10 lg:flex">
                            <NavLink
                                :href="route('home', {hash})"
                                :active="route().current('home')"
                            >
                                <span v-if="hash && playerN">Welcome, {{ playerN }}</span>
                                <span v-else>Registration</span>
                            </NavLink>

                            <NavLink
                                :href="hash ? route('landing.show', [hash]) : ''"
                                :active="hash ? route().current('landing.show') : false"
                                :disabled="!hash"
                            >
                                <span v-if="hash">
                                    <span class="me-1">Lucky page:</span>
                                    <span class="font-semibold underline underline-offset-2">{{ hash }}</span>
                                </span>
                                <span v-else>
                                    Lucky page
                                </span>
                            </NavLink>
                        </div>
                        <div class="flex shrink truncate mx-3 lg:hidden">
                            <NavLink
                                :href="hash ? route('landing.show', [hash]) : ''"
                                :active="hash ? route().current('landing.show') : false"
                                :disabled="!hash"
                            >
                                <span v-if="hash">
                                    <span class="font-semibold underline underline-offset-2 text-xs">
                                        Page: {{ hash }}
                                    </span>
                                </span>
                            </NavLink>
                        </div>

                        <div class="ms-auto hidden space-x-3 lg:-my-px lg:flex">
                            <slot name="history"></slot>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center lg:hidden">
                        <button
                            @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                class="lg:hidden"
            >
                <div class="space-y-3 pb-3 pt-3">
                    <ResponsiveNavLink
                        :href="route('home', {hash})"
                        :active="route().current('home')"
                    >
                        <span v-if="hash && playerN">Welcome, {{ playerN }}</span>
                        <span v-else>Registration</span>
                    </ResponsiveNavLink>
                    <div class="ms-auto space-x-2 ps-3 pe-4 py-2 ">
                        <slot name="history"></slot>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <slot/>

        </div>

    </div>
</template>
