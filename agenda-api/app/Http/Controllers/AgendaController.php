<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agendas;

class AgendaController extends Controller
{
    public function findAll() {
        $contatos = Agendas
    ::all();
        return response()->json($contatos);
    }

    public function save(Request $request) {
        if (empty($request->all())) {
            return response()->json(['mensagem' => 'O corpo da requisição não pode estar vazio.'], 400);
        }
    
        $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'sometimes|nullable|email',
            'endereco' => 'sometimes|nullable|string',
            'telefone' => 'sometimes|nullable|string|max:15',
        ]);
    
        $emailExistente = !empty($dadosValidados['email']) && Agendas::where('email', $dadosValidados['email'])->exists();
        $telefoneExistente = !empty($dadosValidados['telefone']) && Agendas::where('telefone', $dadosValidados['telefone'])->exists();
    
        if ($emailExistente || $telefoneExistente) {
            return response()->json([
                'mensagem' => 'E-mail ou telefone já estão cadastrados.',
                'email_existente' => $emailExistente,
                'telefone_existente' => $telefoneExistente
            ], 409);
        }
    
        try {
            $novoContato = Agendas::create([
                'nome' => $dadosValidados['nome'],
                'email' => $dadosValidados['email'] ?? null,
                'endereco' => $dadosValidados['endereco'] ?? null,
                'telefone' => $dadosValidados['telefone'] ?? null,
            ]);
    
            return response()->json($novoContato, 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Ocorreu um erro ao salvar o contato no banco de dados.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    public function findById($id) {
        $contato = Agendas
    ::find($id);

        if (!$contato) {
            return response()->json(['mensagem' => 'Agenda não encontrada'], 404);
        }

        return response()->json($contato);
    }

    public function update(Request $request, $id) {
        $contato = Agendas
    ::find($id);

        if (!$contato) {
            return response()->json(['mensagem' => 'Agenda não encontrada'], 404);
        }

        // Verifica se o corpo da requisição está vazio
        if (empty($request->all())) {
            return response()->json(['mensagem' => 'O corpo da requisição não pode estar vazio.'], 400);
        }

        $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'sometimes|nullable|email',
            'endereco' => 'sometimes|nullable|string',
            'telefone' => 'sometimes|nullable|string|max:15',
        ]);

        $emailExistente = !empty($dadosValidados['email']) && Agendas
    ::where('email', $dadosValidados['email'])->where('id', '!=', $id)->exists();
        $telefoneExistente = !empty($dadosValidados['telefone']) && Agendas
    ::where('telefone', $dadosValidados['telefone'])->where('id', '!=', $id)->exists();

        if ($emailExistente || $telefoneExistente) {
            return response()->json([
                'mensagem' => 'E-mail ou telefone já estão cadastrados em outra agenda.',
                'email_existente' => $emailExistente,
                'telefone_existente' => $telefoneExistente
            ], 409);
        }

        $contato->update([
            'nome' => $dadosValidados['nome'] ?? $contato->nome,
            'email' => $dadosValidados['email'] ?? $contato->email,
            'endereco' => $dadosValidados['endereco'] ?? $contato->endereco,
            'telefone' => $dadosValidados['telefone'] ?? $contato->telefone,
        ]);

        return response()->json($contato);
    }

    public function delete($id) {
        $contato = Agendas
    ::find($id);

        if (!$contato) {
            return response()->json(['mensagem' => 'Agenda não encontrado'], 404);
        }

        $contato->delete();

        return response()->json(['mensagem' => 'Agenda deletada com sucesso']);
    }
}