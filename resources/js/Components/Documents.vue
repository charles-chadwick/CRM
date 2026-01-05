<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { FileUpload, Button, DataTable, Column } from 'primevue';

const props = defineProps({
    documents: {
        type: Array,
        default: () => []
    },
    on_type: String,
    on_id: [String, Number],
    collection: {
        type: String,
        default: 'documents'
    }
});

const form = useForm({
    on_type: props.on_type,
    on_id: props.on_id,
    collection: props.collection,
    documents: []
});

const onSelect = (event) => {
    form.documents = event.files;
};

const uploadDocuments = () => {
    form.post(route('documents.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('documents');
        },
    });
};

const deleteDocument = (id) => {
    if (confirm('Are you sure you want to delete this document?')) {
        router.delete(route('documents.destroy', id), {
            preserveScroll: true
        });
    }
};

const formatSize = (bytes) => {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};
</script>

<template>
    <div class="space-y-6">
        <FileUpload
            name="documents[]"
            :multiple="true"
            @select="onSelect"
            :customUpload="true"
            @uploader="uploadDocuments"
            :auto="false"
            class="w-full"
        >
            <template #empty>
                <div class="flex flex-col items-center justify-center py-6">
                    <i class="pi pi-cloud-upload text-4xl text-gray-400 mb-2" />
                    <p>Drag and drop documents here to upload.</p>
                </div>
            </template>
        </FileUpload>

        <DataTable v-if="documents.length > 0" :value="documents" class="mt-4">
            <Column field="file_name" header="File Name"></Column>
            <Column header="Size">
                <template #body="slotProps">
                    {{ formatSize(slotProps.data.size) }}
                </template>
            </Column>
            <Column header="Actions" class="text-right">
                <template #body="slotProps">
                    <div class="flex justify-end gap-2">
                        <a :href="slotProps.data.original_url" target="_blank">
                            <Button icon="pi pi-download" severity="secondary" rounded />
                        </a>
                        <Button 
                            icon="pi pi-trash" 
                            severity="danger" 
                            rounded 
                            @click="deleteDocument(slotProps.data.id)" 
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
