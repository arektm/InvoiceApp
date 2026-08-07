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

<template>
    <Head title="Company" />
    <div v-if="page.props.flash.success" class="toast">
        {{ page.props.flash.success }}
    </div>

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="rounded p-6 shadow">
            <h1 class="mb-6 text-3xl font-bold">
                {{ props.company?.name }}
            </h1>

            <div
                class="aspect-[calc(4*3+1)/3 relative overflow-hidden rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border"
            >
                <div class="grid grid-cols-2 gap-4">
                    <p>
                        <strong>Tax number:</strong>
                        {{ props.company?.tax_number }}
                    </p>

                    <p><strong>Phone:</strong> {{ props.company?.phone }}</p>

                    <p><strong>E-mail:</strong> {{ props.company?.email }}</p>

                    <p><strong>City:</strong> {{ props.company?.city }}</p>

                    <p>
                        <strong>Country:</strong> {{ props.company?.country }}
                    </p>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <p><strong>Address:</strong> {{ props.company?.street }}</p>

                    <p>
                        <strong>Postal code:</strong>
                        {{ props.company?.postal_code }}
                    </p>

                    <p>
                        <strong>Country:</strong> {{ props.company?.country }}
                    </p>
                </div>

                <div class="mt-6">
                    <Link
                        href="/company/edit"
                        class="rounded bg-primary px-4 py-2 text-primary-foreground"
                    >
                        Edit
                    </Link>
                </div>
            </div>
        </div>
        <!-- <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
        >
            <PlaceholderPattern />
        </div> -->
    </div>
</template>
