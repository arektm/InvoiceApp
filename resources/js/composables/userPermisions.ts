import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function usePermissions() {
    const page = usePage();

    const role = computed(() => page.props.auth.user?.role);

    const isAdmin = computed(() => role.value === 'admin');

    const isAccountant = computed(() => role.value === 'accountant');
    // Invoices
    const canEditInvoices = computed(() => isAdmin.value || isAccountant.value);

    const canDeleteInvoices = computed(
        () => isAdmin.value || isAccountant.value,
    );

    const canCreateInvoices = computed(
        () => isAdmin.value || isAccountant.value || role.value === 'user',
    );
    // Products
    const canEditProducts = computed(() => isAdmin.value || isAccountant.value);

    const canDeleteProducts = computed(
        () => isAdmin.value || isAccountant.value,
    );

    const canCreateProducts = computed(
        () => isAdmin.value || isAccountant.value || role.value === 'user',
    );
    // Clients
    const canEditClients = computed(() => isAdmin.value || isAccountant.value);

    const canDeleteClients = computed(
        () => isAdmin.value || isAccountant.value,
    );

    const canCreateClients = computed(
        () => isAdmin.value || isAccountant.value || role.value === 'user',
    );

    return {
        role,
        isAdmin,
        isAccountant,
        canEditInvoices,
        canDeleteInvoices,
        canCreateInvoices,

        canEditProducts,
        canDeleteProducts,
        canCreateProducts,

        canEditClients,
        canDeleteClients,
        canCreateClients,
    };
}
