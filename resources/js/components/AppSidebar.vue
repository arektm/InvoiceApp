<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    FolderGit2,
    LayoutGrid,
    UserLock,
    ShoppingBasket,
    Box,
    LucideSquareChartGantt,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { company } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Company',
        href: company(),
        icon: LayoutGrid,
    },
    {
        title: 'Invoices',
        href: '/invoices',
        icon: ShoppingBasket,
    },
    {
        title: 'Clients',
        href: '/clients',
        icon: UserLock,
    },
    {
        title: 'Products',
        href: '/products',
        icon: Box,
    },
    {
        title: 'Reports',
        href: '/reports',
        icon: LucideSquareChartGantt,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/arektm/InvoiceApp',
        icon: FolderGit2,
    },
    // {
    //     title: 'Documentation',
    //     href: '#',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="company()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
