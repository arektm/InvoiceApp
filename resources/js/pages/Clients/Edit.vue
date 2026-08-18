<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { Briefcase, MapPin } from '@lucide/vue';
import { ref } from 'vue';
import FormActions from '@/components/invoices/FormActions.vue';
import PageHeader from '@/components/invoices/PageHeader.vue';
import ModalAlert from '@/components/ModalAlert.vue';
import { usePermissions } from '@/composables/userPermisions.js';
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

const isConfirmOpen = ref(false);

const openConfirmModal = () => {
    isConfirmOpen.value = true;
};
const confirmRemove = () => {
    isConfirmOpen.value = false;

    if (props.client?.id) {
        router.delete(destroy(props.client.id).url);
    }
};
const { canDeleteClients } = usePermissions();
</script>

<template>
    <Head title="Edit client" />

    <div class="space-y-6">
        <!-- Header -->

        <PageHeader
            title="Edit client details"
            description="Update client information and contact details."
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
                            />
                        </div>

                        <!-- Tax Number -->
                        <div>
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

                <FormActions
                    :index-url="index().url"
                    delete-label="Delete Client"
                    save-label="Save Changes"
                    :processing="form.processing"
                    :show-delete="canDeleteClients"
                    @delete="openConfirmModal"
                    :error="$page.props.errors.delete"
                />
                <ModalAlert
                    :show="isConfirmOpen"
                    title="Delete confirmation"
                    message="Are you sure you want to delete"
                    :item="client?.name"
                    confirm="Delete"
                    @close="isConfirmOpen = false"
                    @confirm="confirmRemove"
                />
            </div>
        </form>
    </div>
</template>
