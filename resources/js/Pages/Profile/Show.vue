<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProfileInformation from '@/Pages/Profile/Partials/ProfileInformation.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Profile
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <ProfileInformation :user="$page.props.auth.user" />

                    <SectionBorder />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
