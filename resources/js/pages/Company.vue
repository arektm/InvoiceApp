<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Company',
                href: 'company/',
            },
        ],
    },
});
const props = defineProps({
    company: Object,
    errors: Object,
    success: Object,
});
// const company={
//     name:'Creative Work',
//     tax_number:'23123123123',
//     email:'andy@domain.com',
//     phone:'02343440',
//     street:'44 East Drive',
//     city:'Dublin',
//     postal_code:'V2354R',
//     country:'Ireland'

// }
interface SharedProps {
    flash: {
        success?: string | null;
        error?: string | null;
    };
    [key: string]: any;
}
const page = usePage<SharedProps>();
</script>

```html
<template>
    <Head title="Company" />

    <div class="space-y-8">
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="mt-3 ml-3 text-3xl font-semibold tracking-tight">
                    Company Data
                </h1>

                <!-- Toast Notification -->
                <div
                    v-if="page.props.flash.success"
                    class="mt-4 inline-flex h-9 items-center justify-center rounded-lg border bg-muted px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted/60"
                >
                    {{ page.props.flash.success }}
                </div>
            </div>

            <!-- <Link
                href="/company/edit"
                class="inline-flex mr-3 h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
            >
                Edit Profile
            </Link> -->
        </div>

        <!-- Main Information Card -->
        <div
            class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
        >
            <div class="space-y-6">
                <!-- Contact Info -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 transition-colors hover:bg-muted/50 md:col-span-2"
                    >
                        <div class="flex flex-col">
                            <p class="mb-1 text-sm text-muted-foreground">
                                Company Name
                            </p>

                            <p>{{ props.company?.name }}</p>
                        </div>
                    </div>
                    <!-- Tax Number -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p class="mb-1 text-sm text-muted-foreground">
                                Tax number
                            </p>

                            <p class="font-semibold">
                                {{ props.company?.tax_number }}
                            </p>
                        </div>
                        <ChevronRight
                            class="h-4 w-4 text-muted-foreground opacity-50"
                        />
                    </div>

                    <!-- Phone -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p class="mb-1 text-sm text-muted-foreground">
                                Phone
                            </p>

                            <p>{{ props.company?.phone }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p class="mb-1 text-sm text-muted-foreground">
                                E-mail
                            </p>

                            <p>{{ props.company?.email }}</p>
                        </div>
                    </div>

                    <!-- City -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 transition-colors hover:bg-muted/50"
                    >
                        <div class="flex flex-col">
                            <p class="mb-1 text-sm text-muted-foreground">
                                City
                            </p>

                            <p>{{ props.company?.city }}</p>
                        </div>
                    </div>

                    <!-- Country -->
                    <div
                        class="flex items-center justify-between rounded-lg border bg-muted/30 p-3 transition-colors hover:bg-muted/50 md:col-span-2"
                    >
                        <div class="flex flex-col">
                            <p class="mb-1 text-sm text-muted-foreground">
                                Country
                            </p>

                            <p>{{ props.company?.country }}</p>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="border-t border-border/20 pt-4">
                    <div
                        class="mb-3 flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <MapPin class="h-4 w-4" />
                        <span>Address Details</span>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Street -->
                        <div
                            class="rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50"
                        >
                            <p
                                class="mb-1 text-xs font-medium tracking-wide text-muted-foreground uppercase"
                            >
                                Street
                            </p>

                            <p>{{ props.company?.street }}</p>
                        </div>

                        <!-- Postal Code -->
                        <div
                            class="rounded-lg border bg-muted/30 p-3 shadow-sm transition-colors hover:bg-muted/50 md:col-span-2"
                        >
                            <p
                                class="mb-1 text-xs font-medium tracking-wide text-muted-foreground uppercase"
                            >
                                Postal Code
                            </p>

                            <p>{{ props.company?.postal_code }}</p>
                        </div>
                    </div>
                </div>

                <!-- Edit Link Footer -->
                <div
                    class="mt-6 flex items-center justify-end gap-3 rounded-xl border bg-muted/20 p-4 shadow-sm"
                >
                    <Link
                        href="/company/edit"
                        class="inline-flex h-9 items-center justify-center rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground text-secondary shadow-sm transition-colors hover:bg-primary/80 disabled:pointer-events-none disabled:opacity-50"
                    >
                        Edit Profile
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
