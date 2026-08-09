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
    name: props.client?.name,

    tax_number: props.client?.tax_number,

    street: props.client?.street,

    postal_code: props.client?.postal_code,

    city: props.client?.city,

    country: props.client?.country,

    email: props.client?.email,

    phone: props.client?.phone,
});

const submit = () => {
    form.patch(
        // `/clients/${props.client.id}`
        update(props.client?.id).url,
    );
};

const remove = () => {
    if (!confirm('Remove client?')) {
        return;
    }

    form.delete(destroy(props.client?.id).url);
};
</script>

```html
<template>
    <Head title="Edit client" />

    <div class="space-y-6">
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <div
                    class="flex items-center gap-2 text-sm text-muted-foreground"
                >
                    <Users class="h-4 w-4" />

                    <span>Clients</span>
                </div>

                <h1 class="mt-1 text-3xl font-semibold tracking-tight">
                    Edit Client
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    Update client information and contact details.
                </p>
            </div>

            <Link
                :href="index()"
                class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
            >
                Cancel
            </Link>
        </div>

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
                            />
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
                            />
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
                            />
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
                            />
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
                            />
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
                            />
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
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Footer -->
                <div
                    class="mt-6 flex items-center justify-end gap-3 rounded-xl border bg-muted/20 p-4 shadow-sm"
                >
                    <Link
                        :href="index()"
                        class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="button"
                        @click="remove"
                        class="inline-flex h-9 items-center justify-center rounded-lg bg-red-600 px-4 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-600/90 disabled:pointer-events-none disabled:opacity-50"
                    >
                        Delete Client
                    </button>

                    <button
                        class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-600/90 disabled:pointer-events-none disabled:opacity-50"
                    >
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <!-- Bottom Information -->
        <div class="rounded-xl border bg-muted/30 p-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-background shadow-sm"
                >
                    <Users class="h-4 w-4 text-muted-foreground" />
                </div>

                <div>
                    <p class="text-sm font-medium">Client Information</p>

                    <p class="mt-1 text-sm text-muted-foreground">
                        These details are used for all invoices sent to this
                        client. Please ensure all information is accurate and
                        current.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
