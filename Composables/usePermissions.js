import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function usePermissions() {
    const page = usePage();

    const user = computed(() => page.props.auth.user);
    const permissions = computed(() => page.props.auth.user?.permissions || []);
    const roles = computed(() => page.props.auth.user?.roles || []);

    const can = (permission) => {
        return permissions.value.includes(permission);
    };

    const canAny = (permissionArray) => {
        return permissionArray.some(permission => permissions.value.includes(permission));
    };

    const canAll = (permissionArray) => {
        return permissionArray.every(permission => permissions.value.includes(permission));
    };

    const hasRole = (role) => {
        return roles.value.includes(role);
    };

    const hasAnyRole = (roleArray) => {
        return roleArray.some(role => roles.value.includes(role));
    };

    const hasAllRoles = (roleArray) => {
        return roleArray.every(role => roles.value.includes(role));
    };

    const isAdmin = computed(() => hasRole('Admin'));

    return {
        user,
        permissions,
        roles,
        can,
        canAny,
        canAll,
        hasRole,
        hasAnyRole,
        hasAllRoles,
        isAdmin,
    };
}