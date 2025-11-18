<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TarefaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // Só irá conseguir logar caso passe pela rota de autenticação
        // Podemos implementar nas rotas
   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(10);
        return view('tarefa.index', ['tarefas' => $tarefas]);
        // $id = auth()->user()->id;
        // $name = auth()->user()->name;
        // $email = auth()->user()->email;


        // return "ID $id | Nome: $name | Email: $email";
        /*
        if(auth()->check()) {
            $id = auth()->user()->id;
            $name = auth()->user()->name;
            $email = auth()->user()->email;

            return "ID $id | Nome: $name | Email: $email";
        } else {
            return 'Você não está logado no sistema';
        }
        */
        /*
        if(Auth::check()) {
            $id = Auth::user()->id;
            $name = Auth::user()->name;
            $email = Auth::user()->email;

            return "ID $id | Nome: $name | Email: $email";
        } else {
            return 'Você não está logado no sistema';
        }
            */
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($tarefa->user_id == $user_id){
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id){
            return view('acesso-negado');
        }
        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id){
            return view('acesso-negado');
        }
        $tarefa->delete();
        return redirect()->route('tarefa.index', ['tarefa' => $tarefa->id]);

    }
}
