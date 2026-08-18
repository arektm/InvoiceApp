<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import FormActions from '@/components/invoices/FormActions.vue';
import AppLayout from '@/layouts/AppLayout.vue';

import { index, update } from '@/routes/users';

defineOptions({
    layout: AppLayout,
});

interface User {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'accountant' | 'user';
}

const props = defineProps<{
    user: User;
}>();

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role: props.user.role,
});

const submit = () => {
    form.put(update(props.user.id).url);
};
</script>

<template>
    <Head title="Edit user" />

    <div class="space-y-6">
        <div>
            <p class="text-sm font-medium text-muted-foreground">
                Administration / Users
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight">Edit user</h1>

            <p class="mt-1 text-sm text-muted-foreground">
                Update user information and permissions.
            </p>
        </div>

        <form
            class="rounded-xl border bg-card p-6 shadow-sm"
            @submit.prevent="submit"
        >
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium">
                        Name
                    </label>

                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />

                    <p
                        v-if="form.errors.name"
                        class="mt-1.5 text-sm text-red-500"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium">
                        Email
                    </label>

                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />

                    <p
                        v-if="form.errors.email"
                        class="mt-1.5 text-sm text-red-500"
                    >
                        {{ form.errors.email }}
                    </p>
                </div>

                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium"
                    >
                        New password
                    </label>

                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        placeholder="Leave empty to keep current password"
                        class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />

                    <p
                        v-if="form.errors.password"
                        class="mt-1.5 text-sm text-red-500"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-medium"
                    >
                        Confirm new password
                    </label>

                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />
                </div>

                <div class="md:col-span-2">
                    <label for="role" class="mb-2 block text-sm font-medium">
                        Role
                    </label>

                    <select
                        id="role"
                        v-model="form.role"
                        class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                    >
                        <option value="user">User</option>

                        <option value="accountant">Accountant</option>

                        <option value="admin">Administrator</option>
                    </select>

                    <p
                        v-if="form.errors.role"
                        class="mt-1.5 text-sm text-red-500"
                    >
                        {{ form.errors.role }}
                    </p>
                </div>
            </div>

            <FormActions
                :index-url="index().url"
                save-label="Save changes"
                :processing="form.processing"
            />
        </form>
    </div>
</template>
