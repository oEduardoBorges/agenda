<script setup lang="ts">
import { reactive, watch } from 'vue';

import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';

import type Agenda from '@/types/agenda';


defineEmits(['createAgenda'])

const showModal = defineModel<boolean>({required: true});

const state = reactive<Omit<Agenda, 'id'>>({
    nome: '',
})

watch(showModal, (newValue) => {
    if (newValue) {
        state.nome = '';
        state.telefone = '';
        state.email = '';
        state.endereco = '';
    }
});

</script>
<template>
    <section style="background:#18181b; width: 100%; padding: 2rem;">
        <Dialog 
            v-model:visible="showModal"  
            modal 
            header="Criar Agenda" 
            :style="{ width: '45rem', color: '#dbdadb' }" 
            style="background-color: #18181b; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);"
        >
            <div style="width: 100%;">
                <form @submit.prevent="(e) => {$emit('createAgenda', state); showModal = false }" id="form">
                    <div>
                        <label for="nome" class="font-semibold w-24 custom-placeholder" style="color: #dbdadb;">Nome</label>
                        <InputText id="nome" class="flex-auto custom-placeholder" autocomplete="off" v-model="state.nome" required placeholder="Nome"  style="background-color:#18181b; color: #dbdadb; border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                    </div>
                    <div>
                        <label for="telefone" class="font-semibold w-24 custom-placeholder" style="color: #dbdadb;">Telefone</label>
                        <InputMask id="telefone" mask="(99) 99999-9999" class="custom-placeholder" placeholder="(47) 98877-6655" v-model="state.telefone" style="background-color:#18181b; color: #dbdadb; border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                    </div>
                    <div>
                        <label for="email" class="font-semibold w-24 custom-placeholder" style="color: #dbdadb;">E-mail</label>
                        <InputText id="email" class="flex-auto custom-placeholder" type="email" autocomplete="off" v-model="state.email" placeholder="email@email.com" style="background-color:#18181b; color: #dbdadb; border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                    </div>
                    <div>
                        <label for="endereco" class="font-semibold w-24 custom-placeholder" style="color: #dbdadb;">Endereço</label>
                        <InputText id="endereco" class="flex-auto custom-placeholder" autocomplete="off" v-model="state.endereco" placeholder="Ex: Avenida São João, 1800 - Santa Cecília, SP" style="background-color:#18181b; color: #dbdadb; border: 1px solid #555; border-radius: 4px; padding: 0.5rem;"/>
                    </div>
                    <div style="display: flex; flex-direction: row; gap: 0.5rem; margin-top: 1rem;">
                        <Button type="button" label="Cancelar" severity="secondary" @click="showModal = false" style="background-color: #2c3e50; color: #dbdadb; border: none; padding: 0.5rem 1.5rem; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;" />
                        <Button type="submit" label="Salvar" style="background-color:#18181b; color: #dbdadb; border: none; padding: 0.5rem 1.5rem; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease;" />
                    </div>
                </form>
            </div>
        </Dialog>
    </section>
</template>


<style lang="css" scoped>

#form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

#form > div {
    width: 100%;
    display: flex;
    flex-direction: column;
}

#form > div > label {
    margin-bottom: 0.5rem;
}

.custom-placeholder::placeholder {
    color: #dbdadb !important;
}

</style>