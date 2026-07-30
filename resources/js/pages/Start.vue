<script setup >
import { Head, Link, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { start } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Company',
                href: start(),
            },
        ],
    },
});

const company={
    name:'Creative Work',
    tax_number:'23123123123',
    email:'andy@domain.com',
    phone:'02343440',
    street:'44 East Drive',
    city:'Oslo',
    postal_code:'V2354R',
    country:'Norway'

}
const page = usePage();
</script>

<template>
    <Head title="Company" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
       <div class=" p-6 rounded shadow">

            <h1 class="text-3xl font-bold mb-6">

                {{ company.name }}

            </h1>

            <div 
            class="p-5 relative aspect-[calc(4*3+1)/3 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
            <div class=" grid grid-cols-2 gap-4">

                <p><strong>Tax number:</strong> {{ company.tax_number }}</p>

                <p><strong>Phone:</strong> {{ company.phone }}</p>

                <p><strong>E-mail:</strong> {{ company.email }}</p>

                <p><strong>City:</strong> {{ company.city }}</p>

                <p><strong>Country:</strong> {{ company.country }}</p>

               
            </div>

            <div class="mt-4 grid grid-cols-2 gap-4">

                <p><strong>Address:</strong> {{ company.street }}</p>

                <p><strong>Postal code:</strong> {{ company.postal_code }}</p>

                <p><strong>Country:</strong> {{ company.country }}</p>

            </div>
            
            

                
            </div>
            
        </div>
    </div>
   
</template>
