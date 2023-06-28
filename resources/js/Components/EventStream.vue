<script setup>
import { ref } from 'vue';
import axios from 'axios';

const events = ref([]);
let cursor;
axios.get('/events/stream').then(function(response) {
    events.value = response.data.data;
    cursor = response.data.next_cursor;
});
</script>

<template>
    <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25">
        <table>
            <caption class="text-gray-500 dark:text-gray-400 leading-relaxed">Recent Events</caption>
            <tr class="text-gray-500 dark:text-gray-400 leading-relaxed">
                <th>Name</th>
                <th>Donation Msg</th>
                <th>Donation/Sale Amount</th>
                <th>Donation/Sale Currency</th>
                <th>Sale Item</th>
                <th>Sale Item Count</th>
                <th>Read</th>
                <th>Event Time</th>
            </tr>
            <tr v-for="event in events" class="text-gray-500 dark:text-gray-400 leading-relaxed">
                <td>{{ event.name }}</td>
                <td>{{ event.message }}</td>
                <td>${{ event.amount / 100 }}</td>
                <td>{{ event.currency }}</td>
                <td>{{ event.item }}</td>
                <td>{{ event.count }}</td>
                <td><input type="checkbox" :model="event.read"></td>
                <td>{{ event.event_time }}</td>
            </tr>
        </table>
    </div>
</template>