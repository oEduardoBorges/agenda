<script setup lang="ts">
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';

import { ref } from 'vue';
import ModalEditAgenda from './ModalEditAgenda.vue';

import type Agenda from '@/types/agenda';

// Define the emits
const emit = defineEmits(['editSave', 'removeItem']);

const editingRows = ref([]);
const showEditModal = ref(false);
const selectedAgenda = ref<Agenda | null>(null);

const data = defineModel<Agenda[]>({ required: true });

const openEditModal = (agenda: Agenda) => {
    selectedAgenda.value = agenda;
    showEditModal.value = true;
};

// Correct way to emit the event
const saveEdit = (updatedAgenda: Agenda) => {
    emit('editSave', { data: selectedAgenda.value, newData: updatedAgenda });
    showEditModal.value = false;
};
</script>

<template>
    <section style="width: 100%; padding: 2rem;">
        <DataTable :value="data" tableStyle="min-width: 50rem; border-radius: 4px;" dataKey="id">
            <Column field="nome" header="Nome"></Column>
            <Column field="email" header="Email"></Column>
            <Column field="endereco" header="Endereço"></Column>
            <Column field="telefone" header="Telefone"></Column>
            <Column>
                <template #body="{ data }">
                    <Button severity="info" @click="openEditModal(data)" text type="button" icon="pi pi-pencil" aria-label="Editar" rounded style="border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;" />
                </template>
            </Column>
            <Column>
                <template #body="{ data }">
                    <Button severity="danger" @click="$emit('removeItem', data)" text type="button" icon="pi pi-trash" aria-label="Excluir" rounded style="border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;" />
                </template>
            </Column>
        </DataTable>

        <ModalEditAgenda v-model="showEditModal" :agenda="selectedAgenda" @save="saveEdit" />
    </section>
</template>

<style lang="css" scoped>
.custom-placeholder::placeholder {
    color: #dbdadb !important;
}
</style>
