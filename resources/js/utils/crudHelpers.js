import { router } from '@inertiajs/vue3';
import { useConfirm } from "primevue/useconfirm";

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

export function useConfirmDelete () {
    const confirm = useConfirm ();

    const confirmDelete = ( id, message, prefix, onSuccess = null ) => {
        confirm.require ( {
            message: `Are you sure you want to delete ${ message }?`,
            header: 'Confirm Deletion',
            icon: 'pi pi-exclamation-triangle',
            rejectLabel: 'Cancel',
            acceptLabel: 'Delete',
            rejectClass: 'p-button-secondary p-button-outlined',
            acceptClass: 'p-button-danger',
            accept: async () => {

                const { deleteRecord } = await import('./crudHelpers.js');
                await deleteRecord ( prefix, id );

                // Call optional success callback
                if ( onSuccess && typeof onSuccess === 'function' ) {
                    onSuccess ();
                }
            }
        } );
    };

    return {
        confirmDelete
    };
}
