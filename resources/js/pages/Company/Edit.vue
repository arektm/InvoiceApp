<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import AlertError from '@/components/AlertError.vue';
import { updateCompany } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Company/Edit company details',
                // href: edit,
            },
        ],
    },
});

const props = defineProps({
    company: Object,
    errors: Object,
});

// Inertia Form Helper handles processing states and errors automatically
const form = useForm({
    name: props.company.name,
    tax_number: props.company.tax_number,
    email: props.company.email,
    phone: props.company.phone,
    street: props.company.street,
    city: props.company.city,
    postal_code: props.company.postal_code,
    country: props.company.country,
});

// Submit the form to the route (usually a PUT or PATCH request for updates)
const submit = () => {
    form.patch(updateCompany(props.company.id));
    // form.put(route('companyUpdate', props.company.id), {
    // form.patch((`/company/edit/${props.company.id}`),{
    // onSuccess: () => alert('Company updated successfully!'), // Optional redirect logic handled by Inertia
};
// };
</script>

<template>
    <Head title="Edit Company" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <!-- Form Container -->
        <div class="rounded p-6 shadow">
            <h1 class="mb-6 text-3xl font-bold">Edit</h1>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Name & Tax Number -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Company Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                            required
                        />
                        <div v-if="props.errors.name">
                            <AlertError
                                title=""
                                :errors="[props.errors.name]"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Tax Number</label
                        >
                        <input
                            v-model="form.tax_number"
                            type="text"
                            class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                            required
                        />
                        <div v-if="props.errors.tax_number">
                            <AlertError
                                title=""
                                :errors="[props.errors.tax_number]"
                            />
                        </div>
                    </div>
                </div>

                <!-- Email & Phone -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Phone</label
                        >
                        <input
                            v-model="form.phone"
                            type="text"
                            class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                        />
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mt-4">
                    <h2 class="mb-4 text-xl font-semibold">Address Details</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Street</label
                            >
                            <input
                                v-model="form.street"
                                type="text"
                                class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >City</label
                            >
                            <input
                                v-model="form.city"
                                type="text"
                                class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Postal Code</label
                            >
                            <input
                                v-model="form.postal_code"
                                type="text"
                                class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Country</label
                            >
                            <input
                                v-model="form.country"
                                type="text"
                                class="w-full rounded border border-gray-300 p-2 outline-none focus:ring-2 focus:ring-green-600"
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded bg-green-800 px-6 py-2 text-white transition-colors disabled:bg-gray-400"
                    >
                        {{
                            form.processing
                                ? 'Saving...'
                                : 'Update company details'
                        }}
                    </button>

                    <Link
                        href="/company"
                        class="rounded border bg-gray-100 px-6 py-2 text-gray-700 transition-colors hover:bg-gray-200"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
