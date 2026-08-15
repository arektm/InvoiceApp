<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store } from '@/routes/clients';
import FormInput from '../Shared/FormInput.vue';
import PageHeader from '@/components/invoices/PageHeader.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Create client',
                href: store(),
            },
        ],
    },
});

defineProps({
    errors: Object,
});

const form = useForm({
    name: '',

    tax_number: '',

    street: '',

    postal_code: '',

    city: '',

    country: '',

    email: '',

    phone: '',
});

const submit = () => {
    form.post(store().url);
};
</script>

```html
<template>
    <Head title="New client" />

    <div class="space-y-8">
        <!-- Header -->

        <PageHeader
            title="New Client"
            description="Add a new client to your business directory."
            actionButton="← Back to clients"
            actionButtonAddress="/clients"
            variant="btnWhite"
        />

        <!-- Form Container -->
        <form
            @submit.prevent="submit"
            class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
        >
            <div class="space-y-6">
                <!-- Basic Information Section -->
                <div class="mb-6">
                    <h2
                        class="mb-4 flex items-center gap-2 text-sm font-medium text-muted-foreground"
                    >
                        <Briefcase class="h-4 w-4" />
                        Basic Information
                    </h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Company Name -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Company name</label
                            >

                            <FormInput
                                v-model="form.name"
                                id="name"
                                label="Company name"
                                :error="errors?.name"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.name"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.name }}
                            </div>
                        </div>

                        <!-- Tax Number -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Tax number</label
                            >

                            <FormInput
                                v-model="form.tax_number"
                                id="tax_number"
                                label="Tax number"
                                :error="errors?.tax_number"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.tax_number"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.tax_number }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mb-6">
                    <h2
                        class="mb-4 flex items-center gap-2 text-sm font-medium text-muted-foreground"
                    >
                        <MapPin class="h-4 w-4" />
                        Address Details
                    </h2>

                    <div
                        class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
                    >
                        <!-- Street -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Street</label
                            >

                            <FormInput
                                v-model="form.street"
                                id="street"
                                type="street"
                                label="Street"
                                :error="errors?.street"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.street"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.street }}
                            </div>
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Postal code</label
                            >

                            <FormInput
                                v-model="form.postal_code"
                                id="postal_code"
                                type="postal_code"
                                label="Postal code"
                                :error="errors?.postal_code"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.postal_code"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.postal_code }}
                            </div>
                        </div>

                        <!-- City -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >City</label
                            >

                            <FormInput
                                v-model="form.city"
                                id="city"
                                type="city"
                                label="City"
                                :error="errors?.city"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.city"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.city }}
                            </div>
                        </div>

                        <!-- Country -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Country</label
                            >

                            <FormInput
                                v-model="form.country"
                                id="country"
                                type="country"
                                label="Country"
                                :error="errors?.country"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.country"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.country }}
                            </div>
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >E-mail</label
                            >

                            <FormInput
                                v-model="form.email"
                                id="email"
                                type="email"
                                label="E-mail"
                                :error="errors?.email"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.email"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.email }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Phone</label
                            >

                            <FormInput
                                v-model="form.phone"
                                id="phone"
                                type="phone"
                                label="Phone"
                                :error="errors?.phone"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <div
                                v-if="errors?.phone"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errors?.phone }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Footer -->
                <div
                    class="flex items-center justify-end gap-3 rounded-xl border bg-muted/20 p-4 shadow-sm"
                >
                    <Link
                        href="/clients"
                        :aria-label="'Cancel'"
                        class="inline-flex h-9 w-auto min-w-[108px] items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50 md:w-auto"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="hover:/90 inline-flex h-9 w-auto min-w-[108px] items-center justify-center rounded-lg bg-primary px-4 text-sm font-medium text-white shadow-sm transition-colors disabled:pointer-events-none disabled:opacity-50 md:w-auto"
                    >
                        {{ form.processing ? 'Saving...' : 'Save Client' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
