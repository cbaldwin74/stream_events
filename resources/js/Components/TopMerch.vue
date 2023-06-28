<script setup>
import axios from 'axios';
import { ref } from 'vue';

const topMerch = ref([]);

axios.get('merch/top').then(function (response) {
    topMerch.value = response.data;
});
</script>

<template>
    <div class="flex-auto" style="border-style: solid; border-color: grey; border-width: 2px;">
        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
            <li v-for="item in topMerch"> {{ item.item }} ({{  item.count }})</li>
        </div>
        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
            <div>Top Merch</div>
            <div> (last 30 days) </div>
        </div>
        </div>
</template>