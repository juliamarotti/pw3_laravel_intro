<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index()
    {
        $livros = Livro::all();

        return view('livros.index', compact('livros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|min:3|max:150',
            'autor' => 'required|min:3|max:120',
            'ano_publicacao' => 'required|integer|min:1|max:' . date('Y')
        ]);

        Livro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'ano_publicacao' => $request->ano_publicacao
        ]);

        return redirect('/livros');
    }
}