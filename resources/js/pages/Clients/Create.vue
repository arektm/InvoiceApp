<script setup>

import AppLayout from '../../layouts/AppLayout.vue';
import FormInput from '../Shared/FormInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3'
import { store } from '@/routes/clients';
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Create client',
                href: store(),
            },
        ],
    },
})

defineProps({
    errors: Object
})

const form = useForm({

    name: '',

    tax_number: '',

    street: '',

    postal_code: '',

    city: '',

    country: '',

    email: '',

    phone: '',
})

const submit = () => {
    form.post(store())
}

</script>

<template>

<Head title="New client" />
<div class="flex justify-between mb-6">
    <h1 class="text-3xl font-bold">
        New client
    </h1>
    
</div>
<form
    @submit.prevent="submit"
    class="p-6 rounded shadow"
>


   <div class="grid grid-cols-2 gap-4">

        <FormInput
            v-model="form.name"
            id="name"
            label="Company name"
            :error="errors.name"
        />

        <FormInput
            v-model="form.tax_number"
            id="tax_number"
            label="Tax number"
            :error="errors.tax_number"
        />
        <FormInput
            v-model="form.street"
            id="street"
            type="street"
            label="Street"
            :error="errors.street"
        />

        <FormInput
            v-model="form.postal_code"
            id="postal_code"
            type="postal_code"
            label="Postal code"
            :error="errors.postal_code"
        />

        <FormInput
            v-model="form.city"
            id="city"
            type="city"
            label="City"
            :error="errors.city"
        />
        <FormInput
            v-model="form.country"
            id="country"
            type="country"
            label="Country"
            :error="errors.country"
        />

        <FormInput
            v-model="form.email"
            id="email"
            type="email"
            label="E-mail"
            :error="errors.email"
        />
        <FormInput
            v-model="form.phone"
            id="phone"
            type="phone"
            label="Phone"
            :error="errors.phone"
        />


    
    </div>
  <div class="mt-6 flex gap-4">
    <button
        class="w-32 bg-blue-600 text-white py-2 rounded"
    >
        Save
    </button>

    <Link
        href="/clients"
        class="w-32 bg-gray-500 text-white py-2 rounded text-center"
    >
        Cancel
    </Link>
</div>

</form>
</template>