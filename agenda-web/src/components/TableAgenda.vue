<script setup lang="ts">
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputMask from 'primevue/inputmask';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

import { ref } from 'vue';

import type Agenda from '@/types/agenda';

const editingRows = ref([]);
defineEmits(['editSave','removeItem'])

const data = defineModel<Agenda[]>({required: true})
</script>
<template>
    <section style="width: 100%; padding: 2rem;">
        <DataTable v-model:editingRows="editingRows" :value="data" tableStyle="min-width: 50rem; border-radius: 4px;" editMode="row" dataKey="id" @row-edit-save="e => $emit('editSave', e)">
            <Column field="nome" header="Nome">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" class="custom-placeholder" required placeholder="Nome do contato da agenda" style="border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                </template>
            </Column>
            <Column field="email" header="Email">
                <template #editor="{ data, field }">
                    <InputText type="email" v-model="data[field]" class="custom-placeholder" placeholder="email@email.com" style="border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                </template>
            </Column>
            <Column field="endereco" header="Endereço">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" class="custom-placeholder" placeholder="Ex: Avenida Säo Joäo, 1800 - Santa Cecília, SP" style="border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                </template>
            </Column>
            <Column field="telefone" header="Telefone" >
                <template #editor="{ data, field }">
                    <InputMask v-model="data[field]" class="custom-placeholder" mask="(99) 99999-9999" placeholder="(99) 99999-9999" style="border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
            <Column>
                <template #body="{data}">
                    <Button severity="danger" @click="$emit('removeItem', data)" text type="button" icon="pi pi-trash" aria-label="Excluir" rounded style="border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;" />
                </template>
            </Column>
        </DataTable>
    </section>
</template>


<style lang="css" scoped>

.custom-placeholder::placeholder {
    color: #dbdadb !important;
}

</style>