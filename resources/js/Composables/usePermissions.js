import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function usePermissions () {
    const page = usePage ();

    const user = computed ( () => page.props.auth.user );
    const permissions = computed ( () => page.props.auth?.permissions || [] );
    const roles = computed ( () => page.props.auth?.roles || [] );

    const can = ( permission ) => {
        return permissions.value.includes ( permission );
    };

    const canAny = ( permissionArray ) => {
        return permissionArray.some ( permission => permissions.value.includes ( permission ) );
    };
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function usePermissions() {
    const page = usePage();

    const user = computed(() => page.props.auth?.user);
    const userPermissions = computed(() => user.value?.permissions || []);
    const userRoles = computed(() => user.value?.roles || []);

    /**
     * Check if user has a specific permission
     */
    const can = (permission) => {
        if (!user.value) return false;
        return userPermissions.value.includes(permission);
    };

    /**
     * Check if user has any of the specified permissions
     */
    const canAny = (permissions) => {
        if (!user.value) return false;
        return permissions.some(permission => userPermissions.value.includes(permission));
    };

    /**
     * Check if user has all of the specified permissions
     */
    const canAll = (permissions) => {
        if (!user.value) return false;
        return permissions.every(permission => userPermissions.value.includes(permission));
    };

    /**
     * Check if user has a specific role
     */
    const hasRole = (role) => {
        if (!user.value) return false;
        return userRoles.value.includes(role);
    };

    /**
     * Check if user has any of the specified roles
     */
    const hasAnyRole = (roles) => {
        if (!user.value) return false;
        return roles.some(role => userRoles.value.includes(role));
    };

    /**
     * Check if user has all of the specified roles
     */
    const hasAllRoles = (roles) => {
        if (!user.value) return false;
        return roles.every(role => userRoles.value.includes(role));
    };

    /**
     * Check if user is a super admin
     */
    const isSuperAdmin = () => {
        return hasRole('Super Admin');
    };

    return {
        can,
        canAny,
        canAll,
        hasRole,
        hasAnyRole,
        hasAllRoles,
        isSuperAdmin,
        userPermissions,
        userRoles,
    };
}
    const canAll = ( permissionArray ) => {
        return permissionArray.every ( permission => permissions.value.includes ( permission ) );
    };

    const hasRole = ( role ) => {
        return roles.value.includes ( role );
    };

    const hasAnyRole = ( roleArray ) => {
        return roleArray.some ( role => roles.value.includes ( role ) );
    };

    const hasAllRoles = ( roleArray ) => {
        return roleArray.every ( role => roles.value.includes ( role ) );
    };

    return {
        user,
        permissions,
        roles,
        can,
        canAny,
        canAll,
        hasRole,
        hasAnyRole,
        hasAllRoles
    };
}