<script setup lang="ts">
import ModalCreateAgenda from './ModalCreateAgenda.vue';
import TableAgenda from './TableAgenda.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Card from 'primevue/card';

import { useAgendasStore } from '@/stores/agendas';
import { ref, computed } from 'vue';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";

const showModalCreateAgenda = ref(false);
const searchValue = ref('');
const toast = useToast();
const confirm = useConfirm();

const editAgenda = async (value: any) => {
    if (value.data.id) {
        axios.put(`agendas/${value.data.id}`, value.newData).then((res) => {
            switch (res.status) {
                case 200:
                    toast.add({
                        severity: 'success',
                        summary: 'Atualizado',
                        detail: 'A agenda foi atualizada com sucesso!',
                        life: 5000,
                    });
                    useAgendasStore().updateAgendas(res.data);
                    break;
                default:
                    toast.add({
                        severity: 'warn',
                        summary: 'Aconteceu um erro inesperado',
                        detail: 'Entre em contato com a T.I para receber o suporte necessario',
                        life: 5000,
                    });
                    break;
            }
        }).catch((err) => {
            switch (err.status) {
                case 409:
                    if (err.response?.data?.emailExistente) {
                        toast.add({
                            severity: 'warn',
                            summary: 'ERRO',
                            detail: 'Já existe uma agenda com este email cadastrado',
                            life: 5000,
                        });
                    }
                    if (err.response?.data?.telefoneExistente) {
                        toast.add({
                            severity: 'warn',
                            summary: 'ERRO',
                            detail: 'Já existe uma agenda com este telefone cadastrado',
                            life: 5000,
                        });
                    }
                    break;
                case 422:
                    toast.add({
                        severity: 'warn',
                        summary: 'ERRO',
                        detail: 'Preencha todos os campos corretamente',
                        life: 5000,
                    });
                    break;
                default:
                    toast.add({
                        severity: 'error',
                        summary: 'Ocorreu um erro inesperado',
                        detail: 'Tente novamente mais tarde',
                        life: 5000,
                    });
                    break;
            }
        });
    }
};

const deleteAgenda = async (value: any) => {
    axios.delete(`agendas/${value.id}`).then((res) => {
        switch (res.status) {
            case 200:
                toast.add({
                    severity: 'success',
                    summary: 'Excluída',
                    detail: 'A Agenda foi excluída com sucesso',
                    life: 5000,
                });
                useAgendasStore().removeAgendas(value.id);
                break;
            default:
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,
                });
                console.error('Error:', res.status);
                break;
        }
    }).catch((err) => {
        switch (err.status) {
            default:
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,
                });
                break;
        }
    });
};

const saveAgenda = async (value: any) => {
    axios.post("agendas", value).then((res) => {
        switch (res.status) {
            case 201:
                toast.add({
                    severity: 'success',
                    summary: 'Salvo',
                    detail: 'A agenda foi salva com sucesso!',
                    life: 5000,
                });
                useAgendasStore().addAgendas(res.data);
                break;
            default:
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,
                });
                break;
        }
    }).catch((err) => {
        switch (err.status) {
            case 409:
                if (err.response?.data?.emailExistente) {
                    toast.add({
                        severity: 'warn',
                        summary: 'ERRO',
                        detail: 'Já existe uma agenda cadastrada com este email',
                        life: 5000,
                    });
                }
                if (err.response?.data?.telephone_exists) {
                    toast.add({
                        severity: 'warn',
                        summary: 'ERRO',
                        detail: 'Já existe uma agenda cadastrada com este telefone',
                        life: 5000,
                    });
                }
                break;
            case 422:
                toast.add({
                    severity: 'warn',
                    summary: 'ERRO',
                    detail: 'Preencha todos os campos corretamente',
                    life: 5000,
                });
                break;
            default:
                toast.add({
                    severity: 'error',
                    summary: 'Aconteceu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,
                });
                break;
        }
    });
};

const filteredRows = computed(() => {
    if (!searchValue.value) {
        return useAgendasStore().getAllAgendas;
    }

    return useAgendasStore().getAllAgendas.filter((person) => {
        return Object.values(person).some((value) => {
            return String(value).toLowerCase().includes(searchValue.value.toLowerCase());
        });
    });
});
</script>
<template>
    <section style="background:#18181b; width: 100%; padding: 2rem;">
        <ModalCreateAgenda v-model="showModalCreateAgenda" @create-agenda="saveAgenda" />
        <Card style="background-color: #18181b; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); width: 100%;">
            <template #title>
                <div>
                    <h6 style="font-family: 'Arial', sans-serif; margin-bottom: 1rem; font-size: 2rem; font-weight: 600; color: #dbdadb;">AGENDAS</h6>
                </div>
                <div>
                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 100%">
                            <InputText 
                                style="width: 100%; padding: 0.5rem; border: 1px solid #555; border-radius: 4px; background-color:#18181b; color: #dbdadb;" 
                                v-model="searchValue" 
                                placeholder="Buscar..." 
                                class="custom-placeholder"
                            />
                        </div>
                        <div>
                            <Button 
                                @click="showModalCreateAgenda = true" 
                                label="Criar" 
                                style="background-color:#18181b; color: #dbdadb; border: none; padding: 0.5rem 1.5rem; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;" 
                                class="hover:bg-blue-600"
                            />
                        </div>
                    </div>
                </div>
            </template>
            <template #content>
                <TableAgenda 
                    v-if="filteredRows.length" 
                    v-model="filteredRows" 
                    @edit-save="editAgenda"  
                    @remove-item="data => {
                        confirm.require({
                            accept: () => deleteAgenda(data),
                            header: 'Confirmação de Exclusão',
                            icon: 'pi pi-question-circle',
                            acceptLabel: 'Sim',
                            rejectLabel: 'Não',
                            message: 'Você tem certeza que deseja excluir está agenda? Esta ação não pode ser desfeita e todos os dados associados serão perdidos.',
                            acceptClass: 'p-button-danger', 
                            rejectClass: 'p-button-secondary' 
                        });
                    }"
                />
                <div 
                    style="display: flex; justify-content: center; align-items: center; height: 10rem; background-color: #18181b; border-radius: 4px;" 
                    v-show="!filteredRows.length"
                >
                    <span style="font-weight: 600; font-size: 1rem; color: #f1f1f1;">Nenhuma agenda encontrada</span>
                </div>
            </template>
        </Card>
    </section>
</template>

<style scoped>
.custom-placeholder::placeholder {
    color: #dbdadb !important;
}
</style>