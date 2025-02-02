<script setup lang="ts">
import axios from 'axios';
import AgendaView from './components/AgendaView.vue';
import { useAgendasStore } from './stores/agendas';

import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';


(async() => {
  axios.get('agendas').then(res => {
    switch(res.status){
      case 200:
        useAgendasStore().defineAgendas(res.data)
        break;
      default:
        console.error('Erro ao encontrar agendas', res.status);
    }
  });
})();
</script>
<template>
  <ConfirmDialog></ConfirmDialog>
  <Toast></Toast>
  <main>
    <AgendaView />
  </main>
</template>
