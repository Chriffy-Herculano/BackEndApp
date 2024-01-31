<?php

namespace App\Http\Controllers\Customer;

use App\Models\Agendamento;
use App\Models\Avaliacao;
use App\Models\Customer;
use Illuminate\Http\Request;
use ICustomerService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function response;

class AgendamentoController extends \App\Http\Controllers\Controller
{
    public function store(Request $request)
    {
        $autonomo = new Agendamento();

        $autonomo->id_cliente = $request->input('id_cliente');
        $autonomo->id_autonomo = $request->input('id_autonomo');
        $autonomo->data = $request->input('data');
        $autonomo->horario = $request->input('horario');
        $autonomo->descricao = $request->input('descricao');
        $autonomo->status = $request->input('status');
        $autonomo->servico_finalizado = $request->input('servico_finalizado');

        $autonomo->save();

        return response()->json(['success' => true, 'msg' => 'Salvo com sucesso.']);
    }

    public function avaliar(Request $request)
    {
        $avaliacao = new Avaliacao();

        $avaliacao->id_cliente = $request->input('idCliente');
        $avaliacao->id_autonomo = $request->input('idAutonomo');
        $avaliacao->avaliacao = $request->input('avaliacao');

        $avaliacao->save();

        return response()->json(['success' => true, 'msg' => 'Salvo com sucesso.']);
    }


    public function getNotificacao(Request $request)
    {
        $autonomoId = $request->input('idAutonomo');

        $count = Agendamento::where('id_autonomo', $autonomoId)
            ->where('status', 'pendente')
            ->count();

        if ($count === null) {
            $count = 0;
        }

        return response()->json($count);
    }

    public function getMeuServico(Request $request)
    {
        $autonomoId = $request->input('idAutonomo');
        $status = $request->input('statusFilter');
        $query = Agendamento::select('users.name', 'agendamento.id', 'agendamento.id_cliente', 'agendamento.id_autonomo', 'agendamento.data', 'agendamento.horario', 'agendamento.descricao', 'agendamento.status', 'agendamento.servico_finalizado', 'agendamento.created_at', 'agendamento.updated_at', 'agendamento.deleted_at')
            ->join('users', 'agendamento.id_cliente', '=', 'users.id')
            ->where('agendamento.id_autonomo', $autonomoId);

        if ($status) {
            $query->where('agendamento.status', $status);
        }

        $servicos = $query->get();

        return response()->json($servicos);
    }

    public function getMeuPedido(Request $request)
    {
        $clienteId = $request->input('idCliente');
        $status = $request->input('statusFilter');
        $query = Agendamento::query()
            ->join('customers', 'agendamento.id_autonomo', '=', 'customers.id')
            ->join('autonomo', 'customers.id', '=', 'autonomo.id_usuario')
            ->where('agendamento.id_cliente', $clienteId);

        if ($status) {
            $query->where('agendamento.status', $status);
        }

        $servicos = $query->select('autonomo.nome_completo', 'agendamento.id', 'agendamento.id_cliente',
            'agendamento.id_autonomo', 'agendamento.data', 'agendamento.horario', 'agendamento.descricao',
            'agendamento.status', 'agendamento.servico_finalizado', 'agendamento.created_at', 'agendamento.updated_at', 'agendamento.deleted_at')->get();

        return response()->json($servicos);
    }

    public function aceitarServico($id)
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json(['message' => 'Serviço não encontrado'], 404);
        }

        $agendamento->status = 'em_progresso';
        $agendamento->save();

        return response()->json(['message' => 'Serviço aceito com sucesso e está em progresso']);
    }

    public function concluirServico($id)
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json(['message' => 'Serviço não encontrado'], 404);
        }

        $agendamento->status = 'concluído';
        $agendamento->save();

        return response()->json(['message' => 'Serviço concluído com sucesso']);
    }


    public function deletarServico($id)
    {
        $agendamento = Agendamento::find($id);
        if ($agendamento) {
            $agendamento->delete();
            return true;
        } else {
            return false;
        }
    }
}
