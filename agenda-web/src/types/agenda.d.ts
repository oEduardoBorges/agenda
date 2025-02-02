interface Agenda {
    id: number;
    nome: string;
    email?: string | undefined;
    endereco?: string | undefined;
    telefone?: string | undefined;
}

export default Agenda;