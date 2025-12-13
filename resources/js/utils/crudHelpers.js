import { router } from '@inertiajs/vue3';

export const createRecord = ( route_prefix ) => {
    router.visit ( route ( route_prefix + '.create' ) );
};

export const editRecord = ( route_prefix, id ) => {
    router.visit ( route ( route_prefix + '.edit', id ) );
};

export const deleteRecord = ( route_prefix, id ) => {
    router.delete ( route ( route_prefix + '.destroy', id ), {
        preserveScroll: false,
    } );
};
