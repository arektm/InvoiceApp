<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { edit, show } from '@/routes/clients';

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

```html
<template>
    <Head :title="client?.name || 'Client'" />

    <div class="space-y-8">
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
                    {{ client?.name }}
                </h1>

                <!-- Status Badge (if applicable) -->
                <div
                    v-if="client?.status"
                    class="mt-2 inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium shadow-sm"
                >
                    <span>{{ client?.status }}</span>
                </div>
            </div>

            <Link
                :href="edit(client?.id)"
                class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
            >
                Edit Client
            </Link>
        </div>

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
                <div
                    class="mt-6 flex items-center justify-end gap-3 rounded-xl border bg-muted/20 p-4 shadow-sm"
                >
                    <Link
                        :href="edit(client?.id)"
                        class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-600/90 disabled:pointer-events-none disabled:opacity-50"
                    >
                        Edit Client Details
                    </Link>
                </div>
            </div>
        </div>

        <!-- Bottom Information (same as Reports page) -->
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
                        Client details used for invoicing and business
                        communications. Ensure accuracy to maintain proper
                        customer records.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
