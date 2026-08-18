<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PageHeader from '@/components/invoices/PageHeader.vue';
import ShowActions from '@/components/invoices/ShowActions.vue';
import { index, show } from '@/routes/clients';
// import FormActions from '@/components/invoices/FormActions.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Clients/Client view',
                href: show,
            },
        ],
    },
});
defineProps({
    client: Object,
});
</script>

<template>
    <Head :title="client?.name || 'Client'" />

    <div class="space-y-8">
        <!-- Header -->
        <PageHeader
            :item="client?.name"
            description="View client information."
            actionButton="← Back to clients"
            actionButtonAddress="/clients"
            variant="btnWhite"
        />

        <!-- Client Information Card -->
        <div
            class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
        >
            <div class="space-y-6">
                <!-- Contact Info Grid -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Tax Number -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p
                                class="mb-1 text-sm font-medium text-muted-foreground"
                            >
                                Tax Number
                            </p>

                            <p>{{ client?.tax_number }}</p>
                        </div>
                        <CheckCircle2
                            class="h-4 w-4 text-muted-foreground opacity-50"
                        />
                    </div>

                    <!-- Phone -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p
                                class="mb-1 text-sm font-medium text-muted-foreground"
                            >
                                Phone
                            </p>

                            <p>{{ client?.phone }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p
                                class="mb-1 text-sm font-medium text-muted-foreground"
                            >
                                E-mail
                            </p>

                            <p>{{ client?.email }}</p>
                        </div>
                    </div>

                    <!-- City -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p
                                class="mb-1 text-sm font-medium text-muted-foreground"
                            >
                                City
                            </p>

                            <p>{{ client?.city }}</p>
                        </div>
                    </div>

                    <!-- Country -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50 md:col-span-2"
                    >
                        <div class="flex flex-col">
                            <p
                                class="mb-1 text-sm font-medium text-muted-foreground"
                            >
                                Country
                            </p>

                            <p>{{ client?.country }}</p>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="border-t border-border/20 pt-4">
                    <div
                        class="mb-3 flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <MapPin class="h-4 w-4" />
                        <span>Address</span>
                    </div>

                    <p class="text-sm font-medium">
                        {{ client?.street }}
                    </p>

                    <p class="mt-1 text-sm text-muted-foreground">
                        {{ client?.postal_code }}
                    </p>
                </div>

                <!-- Edit Link Footer -->

                <ShowActions
                    :indexUrl="index().url"
                    showEdit
                    editLabel="Edit Client Details"
                    :edit-url="`/clients/${client?.id}/edit`"
                />
            </div>
        </div>
    </div>
</template>
