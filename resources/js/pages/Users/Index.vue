<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Plus,
    Search,
    Trash2,
    Pencil,
    ShieldCheck,
    UserRound,
} from '@lucide/vue';
import { ref, watch } from 'vue';
import ModalAlert from '@/components/ModalAlert.vue';
import UserRoleBadge from '@/components/users/UserRoleBadge.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { create, edit, destroy } from '@/routes/users';
import Pagination from '../Shared/Pagination.vue';

defineOptions({
    layout: AppLayout,
});

interface UserItem {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'accountant' | 'user';
    created_at: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

const props = defineProps<{
    users: {
        data: UserItem[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters?.search ?? '');

let searchTimeout: ReturnType<typeof setTimeout> | null = null;

watch(search, (value) => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(() => {
        router.get(
            '/users',
            {
                search: value || undefined,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            },
        );
    }, 300);
});


const isConfirmOpen = ref(false);

const selectedUser = ref<UserItem | null>(null);

const openConfirmModal = (user: UserItem) => {
    selectedUser.value = user;
    isConfirmOpen.value = true;
};
const confirmRemove = () => {
    if (!selectedUser.value) {
        return;
    }

    router.delete(destroy(selectedUser.value.id).url, {
        onFinish: () => {
            isConfirmOpen.value = false;
            selectedUser.value = null;
        },
    });
};
</script>

<template>
    <Head title="Users" />

    <div class="space-y-6">
        <!-- Header -->
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm font-medium text-muted-foreground">
                    Administration
                </p>

                <h1 class="mt-1 text-3xl font-bold tracking-tight">Users</h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    Manage application users and their roles.
                </p>
            </div>

            <Link
                :href="create().url"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground transition hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />
                Add user
            </Link>
        </div>

        <!-- Search -->
        <div class="rounded-xl border bg-card p-5 shadow-sm">
            <div class="relative max-w-xl">
                <Search
                    class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                />

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search by name or email..."
                    class="w-full rounded-lg border bg-background py-2.5 pr-4 pl-9 text-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            class="border-b bg-muted/40 text-xs tracking-wider text-muted-foreground uppercase"
                        >
                            <th class="px-6 py-4 text-left">User</th>

                            <th class="px-6 py-4 text-left">Role</th>

                            <th class="px-6 py-4 text-left">Created</th>

                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="transition hover:bg-muted/30"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary"
                                    >
                                        <UserRound class="h-4 w-4" />
                                    </div>

                                    <div>
                                        <p class="font-medium">
                                            {{ user.name }}
                                        </p>

                                        <p
                                            class="text-xs text-muted-foreground"
                                        >
                                            {{ user.email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <UserRoleBadge :role="user.role" />
                            </td>

                            <td class="px-6 py-4 text-muted-foreground">
                                {{ user.created_at }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="edit(user.id).url"
                                        class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium hover:bg-muted"
                                    >
                                        <Pencil class="h-3.5 w-3.5" />
                                        Edit
                                    </Link>

                                    <button
                                        type="button"
                                        :disabled="user.role === 'admin'"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-40 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400"
                                        @click="openConfirmModal(user)"
                                    >
                                        <Trash2 class="h-3.5 w-3.5" />
                                        Delete
                                    </button>

                                    <ModalAlert
                                        :show="isConfirmOpen"
                                        :item="selectedUser?.name"
                                        title="Delete user"
                                        message="Are you sure you want to delete user"
                                        confirm="Delete"
                                        @close="isConfirmOpen = false"
                                        @confirm="confirmRemove"
                                    />
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tbody v-if="users.data.length === 0">
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <ShieldCheck
                                    class="mx-auto h-8 w-8 text-muted-foreground"
                                />

                                <p class="mt-3 font-medium">No users found</p>

                                <p class="mt-1 text-sm text-muted-foreground">
                                    Try changing your search.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

           
                <Pagination :links="users.links" />
           
        </div>
    </div>
</template>
