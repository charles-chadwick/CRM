import { usePage } from '@inertiajs/vue3';

export const permissionDirective = {
    mounted(el, binding) {
        const page = usePage();
        const permissions = page.props.auth?.user?.permissions || [];

        const requiredPermission = binding.value;
        const hasPermission = permissions.includes(requiredPermission);

        if (!hasPermission) {
            // Remove element if user doesn't have permission
            el.style.display = 'none';

            // Optionally, remove from DOM completely
            if (binding.modifiers.remove) {
                el.parentNode?.removeChild(el);
            }
        }
    },

    updated(el, binding) {
        const page = usePage();
        const permissions = page.props.auth?.user?.permissions || [];

        const requiredPermission = binding.value;
        const hasPermission = permissions.includes(requiredPermission);

        if (hasPermission) {
            el.style.display = '';
        } else {
            el.style.display = 'none';
        }
    }
};

export const roleDirective = {
    mounted(el, binding) {
        const page = usePage();
        const roles = page.props.auth?.user?.roles || [];

        const requiredRole = binding.value;
        const hasRole = roles.includes(requiredRole);

        if (!hasRole) {
            // Remove element if user doesn't have role
            el.style.display = 'none';

            // Optionally, remove from DOM completely
            if (binding.modifiers.remove) {
                el.parentNode?.removeChild(el);
            }
        }
    },

    updated(el, binding) {
        const page = usePage();
        const roles = page.props.auth?.user?.roles || [];

        const requiredRole = binding.value;
        const hasRole = roles.includes(requiredRole);

        if (hasRole) {
            el.style.display = '';
        } else {
            el.style.display = 'none';
        }
    }
};
