<?php

namespace App\Http\Controllers\Autonomo;

use App\Models\Autonomo;
use App\Models\Customer;
use Illuminate\Http\Request;
use ICustomerService;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Log;
use function response;

class AutonomoController extends \App\Http\Controllers\Controller
{
    public function store(Request $request)
    {
        $autonomo = new Autonomo();

        if ($request->id) {
            $autonomo = Autonomo::find($request->id);
        }

        $autonomo->id_usuario = $request->input('id_usuario');
        $autonomo->nome_completo = $request->input('nome_completo');
        $autonomo->idade = $request->input('idade');
        $autonomo->profissao = $request->input('profissao');
        $autonomo->genero = $request->input('genero');
        $autonomo->telefone = $request->input('telefone');
        $autonomo->estado = $request->input('estado');
        $autonomo->cidade = $request->input('cidade');
        $autonomo->descricao = $request->input('descricao');
        $autonomo->foto = $request->input('foto');

        $autonomo->save();

        return response()->json(['success' => true, 'msg' => 'Salvo com sucesso.']);

    }

    public function getAutonomo(Request $request)
    {
        // Obtenha os parâmetros da solicitação
        $profession = $request->input('profession');
        $name = $request->input('name');
        $orderBy = $request->input('orderBy');

        // Inicialize a consulta
        $query = Autonomo::query()
            ->leftJoin('customers as c', 'autonomo.id_usuario', '=', 'c.id')
            ->leftJoin('avaliacao as av', 'c.id', '=', 'av.id_autonomo')
            ->select('autonomo.*', DB::raw('AVG(av.avaliacao) as media_avaliacao'))
            ->groupBy('autonomo.id');

        // Aplicar filtros com base nos parâmetros fornecidos
        if ($profession) {
            $query->where('profissao', $profession);
        }

        if ($name) {
            $query->where('nome_completo', 'LIKE', '%' . $name . '%');
        }

        if ($orderBy === 'maior') {
            $query->orderBy('media_avaliacao', 'desc');
        } elseif ($orderBy === 'menor') {
            $query->orderBy('media_avaliacao', 'asc');
        }

        // Execute a consulta e obtenha os resultados
        $autonomos = $query->get();
        Log::info('========================================');
        Log::info($autonomos);
        return response()->json($autonomos);
    }

    public function getAutonomoPerfil(Request $request)
    {
        $customerId = $request->input('customerId');

        $profileData =  Autonomo::leftJoin('avaliacao as av', 'autonomo.id', '=', 'av.id_autonomo')
            ->select('autonomo.*', DB::raw('AVG(av.avaliacao) as media_avaliacao'))
            ->groupBy('autonomo.id')
            ->where('id_usuario', $customerId)->first();

        if ($profileData) {
            return response()->json($profileData);
        } else {
            return response()->json(['error' => 'Profile data not found'], 404);
        }
    }


}
