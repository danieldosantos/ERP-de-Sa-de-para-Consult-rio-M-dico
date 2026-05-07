<?php
namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendamentoController extends Controller
{
    public function index(): View
    {
        $items = Agendamento::with(['medico', 'paciente'])->latest('data_hora')->paginate(10);

        return view('agendamentos.index', compact('items'));
    }

    public function create(): View
    {
        $medicos = Medico::orderBy('nome')->get();
        $pacientes = Paciente::orderBy('nome')->get();
        $statusOpcoes = Agendamento::STATUS_OPCOES;

        return view('agendamentos.create', compact('medicos', 'pacientes', 'statusOpcoes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'data_hora' => 'required|date',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'status' => 'required|in:agendada,confirmada,atendida,cancelada',
            'observacoes' => 'nullable|string',
        ]);

        Agendamento::create($data);

        return redirect()->route('agendamentos.index')->with('status', 'Agendamento criado com sucesso.');
    }

    public function edit(Agendamento $agendamento): View
    {
        $medicos = Medico::orderBy('nome')->get();
        $pacientes = Paciente::orderBy('nome')->get();
        $statusOpcoes = Agendamento::STATUS_OPCOES;

        return view('agendamentos.edit', compact('agendamento', 'medicos', 'pacientes', 'statusOpcoes'));
    }

    public function update(Request $request, Agendamento $agendamento): RedirectResponse
    {
        $data = $request->validate([
            'data_hora' => 'required|date',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'status' => 'required|in:agendada,confirmada,atendida,cancelada',
            'observacoes' => 'nullable|string',
        ]);

        $agendamento->update($data);

        return redirect()->route('agendamentos.index')->with('status', 'Agendamento atualizado com sucesso.');
    }

    public function destroy(Agendamento $agendamento): RedirectResponse
    {
        $agendamento->delete();

        return redirect()->route('agendamentos.index')->with('status', 'Agendamento removido com sucesso.');
    }
}
