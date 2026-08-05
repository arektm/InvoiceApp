<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import AlertError from '@/components/AlertError.vue'
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
})

// Inertia Form Helper handles processing states and errors automatically
const form = useForm({
    name: props.company.name,
    tax_number: props.company.tax_number,
    email: props.company.email,
    phone: props.company.phone,
    street: props.company.street,
    city: props.company.city,
    postal_code: props.company.postal_code,
    country: props.company.country,
});

// Submit the form to the route (usually a PUT or PATCH request for updates)
const submit = () => {
    form.patch(updateCompany(props.company.id));
    // form.put(route('companyUpdate', props.company.id), {
    // form.patch((`/company/edit/${props.company.id}`),{
        // onSuccess: () => alert('Company updated successfully!'), // Optional redirect logic handled by Inertia
    };
// };
</script>

<template>
    <Head title="Edit Company" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <!-- Form Container -->
        <div class="p-6 rounded shadow">
            <h1 class="text-3xl font-bold mb-6">Edit</h1>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Name & Tax Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Company Name</label>
                        <input 
                            v-model="form.name" 
                            type="text" 
                            class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                            required
                        />
                        <div v-if="props.errors.name">
                            <AlertError title="" :errors="[props.errors.name]"  />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tax Number</label>
                        <input 
                            v-model="form.tax_number" 
                            type="text" 
                            class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                            required
                        />
                        <div v-if="props.errors.tax_number">
                            <AlertError title="" :errors="[props.errors.tax_number]"  />
                        </div>
                    </div>
                </div>

                <!-- Email & Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input 
                            v-model="form.email" 
                            type="email" 
                            class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Phone</label>
                        <input 
                            v-model="form.phone" 
                            type="text" 
                            class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                        />
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mt-4">
                    <h2 class="text-xl font-semibold mb-4">Address Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Street</label>
                            <input 
                                v-model="form.street" 
                                type="text" 
                                class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">City</label>
                            <input 
                                v-model="form.city" 
                                type="text" 
                                class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Postal Code</label>
                            <input 
                                v-model="form.postal_code" 
                                type="text" 
                                class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Country</label>
                            <input 
                                v-model="form.country" 
                                type="text" 
                                class="w-full rounded border border-gray-300 p-2 focus:ring-2 focus:ring-green-600 outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="bg-green-800 text-white px-6 py-2 rounded disabled:bg-gray-400 transition-colors"
                    >
                        {{ form.processing ? 'Saving...' : 'Update company details' }}
                    </button>
                    
                    <Link 
                        href="/company" 
                        class="bg-gray-100 text-gray-700 px-6 py-2 rounded border hover:bg-gray-200 transition-colors"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>

        
    </div>
     
</template>

