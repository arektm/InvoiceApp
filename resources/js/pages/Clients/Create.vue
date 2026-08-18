<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { MapPin } from '@lucide/vue';
import FormActions from '@/components/invoices/FormActions.vue';
import PageHeader from '@/components/invoices/PageHeader.vue';
import { index, store } from '@/routes/clients';
import FormInput from '../Shared/FormInput.vue';

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
                            <FormInput
                                v-model="form.tax_number"
                                id="tax_number"
                                label="Tax number"
                                :error="errors?.tax_number"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
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
                            <FormInput
                                v-model="form.street"
                                id="street"
                                type="street"
                                label="Street"
                                :error="errors?.street"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <FormInput
                                v-model="form.postal_code"
                                id="postal_code"
                                type="postal_code"
                                label="Postal code"
                                :error="errors?.postal_code"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <!-- City -->
                        <div>
                            <FormInput
                                v-model="form.city"
                                id="city"
                                type="city"
                                label="City"
                                :error="errors?.city"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <!-- Country -->
                        <div>
                            <FormInput
                                v-model="form.country"
                                id="country"
                                type="country"
                                label="Country"
                                :error="errors?.country"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <!-- E-mail -->
                        <div>
                            <FormInput
                                v-model="form.email"
                                id="email"
                                type="email"
                                label="E-mail"
                                :error="errors?.email"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>

                        <!-- Phone -->
                        <div>
                            <FormInput
                                v-model="form.phone"
                                id="phone"
                                type="phone"
                                label="Phone"
                                :error="errors?.phone"
                                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Footer -->
                <FormActions
                    :index-url="index().url"
                    save-label="Save Client"
                    :processing="form.processing"
                />
            </div>
        </form>
    </div>
</template>
