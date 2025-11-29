import { usePage } from '@inertiajs/vue3';

export default {
    mounted(el, binding) {
        const page = usePage();
        const permissions = page.props.auth.permissions || [];

        let hasPermission = false;

        if (typeof binding.value === 'string') {
            // Single permission check
            hasPermission = permissions.includes(binding.value);
        } else if (Array.isArray(binding.value)) {
            // Multiple permissions check (OR logic by default)
            const mode = binding.arg || 'any'; // 'any' or 'all'

            if (mode === 'all') {
                hasPermission = binding.value.every(p => permissions.includes(p));
            } else {
                hasPermission = binding.value.some(p => permissions.includes(p));
            }
        }

        if (!hasPermission) {
            // Remove the element if user doesn't have permission
            el.style.display = 'none';
            el.setAttribute('data-hidden-by-permission', 'true');
        }
    },

    updated(el, binding) {
        const page = usePage();
        const permissions = page.props.auth.permissions || [];

        let hasPermission = false;

        if (typeof binding.value === 'string') {
            hasPermission = permissions.includes(binding.value);
        } else if (Array.isArray(binding.value)) {
            const mode = binding.arg || 'any';

            if (mode === 'all') {
                hasPermission = binding.value.every(p => permissions.includes(p));
            } else {
                hasPermission = binding.value.some(p => permissions.includes(p));
            }
        }

        if (hasPermission) {
            if (el.getAttribute('data-hidden-by-permission') === 'true') {
                el.style.display = '';
                el.removeAttribute('data-hidden-by-permission');
            }
        } else {
            el.style.display = 'none';
            el.setAttribute('data-hidden-by-permission', 'true');
        }
    }
};
