<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { update, index, destroy, edit } from '@/routes/clients';
import FormInput from '../Shared/FormInput.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Clients/Edit client',
                href: edit,
            },
        ],
    },
});

const props = defineProps({
    client: Object,
    errors: Object,
});

const form = useForm({
    name: props.client.name,

    tax_number: props.client.tax_number,

    street: props.client.street,

    postal_code: props.client.postal_code,

    city: props.client.city,

    country: props.client.country,

    email: props.client.email,

    phone: props.client.phone,
});

const submit = () => {
    form.patch(
        // `/clients/${props.client.id}`
        update(props.client.id),
    );
};

const remove = () => {
    if (!confirm('Remove client?')) {
        return;
    }

    form.delete(destroy(props.client.id));
};
</script>

<template>
    <Head title="Edit client" />

    <form @submit.prevent="submit" class="rounded p-6 shadow">
        <h1 class="mb-6 text-3xl font-bold">Edit client</h1>

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
            <button class="rounded bg-blue-600 px-6 py-2 text-white">
                Save
            </button>

            <button
                type="button"
                @click="remove"
                class="rounded bg-red-600 px-6 py-2 text-white"
            >
                Delete
            </button>

            <Link
                :href="index()"
                class="rounded bg-gray-600 px-6 py-2 text-white"
            >
                Cancel
            </Link>
        </div>
    </form>
</template>
