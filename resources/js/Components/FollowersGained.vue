<script setup>
import axios from 'axios';
import { ref } from 'vue';

const gained = ref(0);

axios.get('followers/gained').then(function (response) {
    gained.value = response.data;
});
</script>

<template>
    <div class="flex-auto" style="border-style: solid; border-color: grey; border-width: 2px;">
        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
            {{ gained }}
        </div>
        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
            <div>Followers Gained</div>
            <div> (last 30 days) </div>
        </div>
        </div>
</template>