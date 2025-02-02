// import { ref, computed } from 'vue'

import type Agenda from '../types/agenda'
import { defineStore } from 'pinia'

interface State {
    agendas: Agenda[]
}

export const useAgendasStore = defineStore('agendas', {
    state: ():State => {
        return {
            agendas: []
        }
    },
    actions: {
        defineAgendas(agenda: Agenda[]) {
            this.agendas = agenda;
        },
        addAgendas(agenda: Agenda) {
            this.agendas.push(agenda)
        },
        updateAgendas(agenda: Agenda) {
            const index = this.agendas.findIndex(c => c.id === agenda.id);
            if (index !== -1) {
                this.agendas[index] = agenda;
                return agenda;
            }
            
            return null; 
        },
        removeAgendas(agendaID: Agenda['id']) {
            this.agendas = this.agendas.filter(c => c.id!== agendaID);
        },
    },
    getters: {
        getAllAgendas: (state) => state.agendas,
        AgendasById: (state) => (id: number) => state.agendas.find(a => a.id === id),
        findAgendas: (state) => (searchValue: string) => {
            return state.agendas.find(a => {
                a.nome.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase()) ||
                a.email?.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase()) ||
                a.telefone?.includes(searchValue) ||
                a.endereco?.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase())
            })
        }
    }
})
