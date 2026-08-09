<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
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
    name: props.company?.name,
    tax_number: props.company?.tax_number,
    email: props.company?.email,
    phone: props.company?.phone,
    street: props.company?.street,
    city: props.company?.city,
    postal_code: props.company?.postal_code,
    country: props.company?.country,
});

// Submit the form to the route (usually a PUT or PATCH request for updates)
const submit = () => {
    form.patch(updateCompany(props.company?.id).url);
    // form.put(route('companyUpdate', props.company.id), {
    // form.patch((`/company/edit/${props.company.id}`),{
    // onSuccess: () => alert('Company updated successfully!'), // Optional redirect logic handled by Inertia
};
// };
</script>

```html
<template>
    <Head title="Edit Company" />

    <div class="space-y-8">
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <div
                    class="flex items-center gap-2 text-sm text-muted-foreground"
                >
                    <Building class="h-4 w-4" />

                    <span>Companies</span>
                </div>

                <h1 class="mt-1 text-3xl font-semibold tracking-tight">
                    Edit Company Details
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    Update your company information and contact details.
                </p>
            </div>

            <Link
                href="/company"
                class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted"
            >
                Cancel
            </Link>
        </div>

        <!-- Form Container -->
        <div class="rounded-xl border bg-card p-5 shadow-sm">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Basic Information -->
                <div class="mb-6">
                    <h2
                        class="mb-4 flex items-center gap-2 text-sm font-medium text-muted-foreground"
                    >
                        <Briefcase class="h-4 w-4" />
                        Basic Information
                    </h2>

                    <!-- Name & Tax Number -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Company Name</label
                            >

                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="props.errors?.name"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ props.errors?.name }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Tax Number</label
                            >

                            <input
                                v-model="form.tax_number"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="props.errors?.tax_number"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ props.errors?.tax_number }}
                            </div>
                        </div>
                    </div>

                    <!-- Email & Phone -->
                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Email</label
                            >

                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Phone</label
                            >

                            <input
                                v-model="form.phone"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>
                    </div>
                </div>

                <!-- Address Details -->
                <div>
                    <h2
                        class="mb-4 flex items-center gap-2 text-sm font-medium text-muted-foreground"
                    >
                        <MapPin class="h-4 w-4" />
                        Address Details
                    </h2>

                    <!-- Street & City -->
                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Street</label
                            >

                            <input
                                v-model="form.street"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >City</label
                            >

                            <input
                                v-model="form.city"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>
                    </div>

                    <!-- Postal Code & Country -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Postal Code</label
                            >

                            <input
                                v-model="form.postal_code"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Country</label
                            >

                            <input
                                v-model="form.country"
                                type="text"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="mt-8 flex items-center justify-end gap-4 rounded-xl border bg-muted/20 p-4 shadow-sm"
                >
                    <Link
                        href="/company"
                        :aria-label="'Cancel'"
                        class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-600/90 disabled:pointer-events-none disabled:opacity-50"
                    >
                        {{
                            form.processing
                                ? 'Saving...'
                                : 'Update Company Details'
                        }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Bottom Information -->
        <div class="rounded-xl border bg-muted/30 p-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-background shadow-sm"
                >
                    <BarChart3 class="h-4 w-4 text-muted-foreground" />
                </div>

                <div>
                    <p class="text-sm font-medium">Company Information</p>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Your company details are used for invoices and business
                        communications. Please ensure all information is
                        accurate and up to date.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
```
