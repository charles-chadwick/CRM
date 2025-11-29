import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function usePermissions() {
    const page = usePage();

    const permissions = computed(() => page.props.auth.permissions || []);

    const can = (permission) => {
        if (!permission) return false;

        // Support checking multiple permissions (OR logic)
        if (Array.isArray(permission)) {
            return permission.some(p => permissions.value.includes(p));
        }

        return permissions.value.includes(permission);
    };

    const canAll = (permissionsArray) => {
        if (!Array.isArray(permissionsArray)) return false;
        return permissionsArray.every(p => permissions.value.includes(p));
    };

    const canAny = (permissionsArray) => {
        if (!Array.isArray(permissionsArray)) return false;
        return permissionsArray.some(p => permissions.value.includes(p));
    };

    const hasRole = (role) => {
        const user = page.props.auth.user;
        if (!user || !user.attributes.roles) return false;

        if (Array.isArray(role)) {
            return role.some(r => user.attributes.roles.includes(r));
        }

        return user.attributes.roles.includes(role);
    };

    const hasAllRoles = (rolesArray) => {
        const user = page.props.auth.user;
        if (!user || !user.attributes.roles) return false;
        if (!Array.isArray(rolesArray)) return false;

        return rolesArray.every(r => user.attributes.roles.includes(r));
    };

    return {
        permissions,
        can,
        canAll,
        canAny,
        hasRole,
        hasAllRoles
    };
}
