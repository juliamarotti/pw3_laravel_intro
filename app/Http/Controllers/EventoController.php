<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Exibe a listagem de usuários com suporte a filtro de busca.
     */
    public function index(Request $request)
    {
        // Captura o termo de busca enviado pelo formulário GET
        $busca = $request->input('busca');

        if ($busca) {
            $eventos = Evento::where('titulo', 'like', "%{$busca}%", 'and')
                ->orderBy('titulo', 'asc')
                ->get();
        } else {
            $eventos = Evento::orderBy('titulo', 'asc')->get();
        }

        // Retorna a view do painel 
        return view('eventos.index', compact('eventos', 'busca'));
    }

    /**
     * Exibe o formulário de cadastro de usuários.
     */
    public function create()
    {
        return view('eventos.create');
    }

    /**
     * Salva o novo usuário no banco de dados com validação.
     */
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'titulo' => 'required|min:3',
            'local' => 'required|min:2',
            'vagas' => 'required|integer|min:1',
            'preco_inscricao' => 'required|numeric|min:0',
        ]);

        Evento::create($dadosValidados);

        return redirect('/eventos')->with('sucesso', 'Evento cadastrado com sucesso');
    }
}