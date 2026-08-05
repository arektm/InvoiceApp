<script setup lang="ts">

import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array
})

</script>

<template>

<div class="flex gap-2 mt-6">

    <template
        v-for="link in links"
        :key="link.label"
    >

        <span
            v-if="!link.url"
            class="px-3 py-2 border rounded text-gray-400"
            v-html="link.label"
        />

        <!-- <Link
            v-else
            :href="link.url"
            class="px-3 py-2 border rounded"
            :class="{
                'bg-blue-600 text-white': link.active
            }"
            v-html="link.label"
        /> -->
        <Link
            v-else
            :href="link.url"
            class="px-3 py-2 border rounded"
            :class="{
                'bg-blue-600 text-white': link.active
            }"
        >
            <span v-html="link.label"></span>
        </Link>



    </template>

</div>

</template>