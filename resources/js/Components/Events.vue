<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import EventStream from './EventStream.vue';
import FollowersGained from './FollowersGained.vue';
import TopMerch from './TopMerch.vue';
import TotalRevenue from './TotalRevenue.vue';
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Welcome to your events dashboard!
            </h1>

            <!-- <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
                to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
                you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
                ecosystem to be a breath of fresh air. We hope you love it.
            </p> -->
            <div class="flex items-center space-x-4">
                <TotalRevenue />
                <FollowersGained />
                <TopMerch />
            </div>
        </div>

        <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            <EventStream />
        </div>
    </div>
</template>
