<?php
namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AgendamentoController extends Controller
{
    public function index(Request $request): View
    {
        $filtros = $request->validate([
            'medico_id' => ['nullable', 'integer', 'exists:medicos,id'],
            'dia' => ['nullable', 'date'],
            'paciente' => ['nullable', 'string', 'max:255'],
        ]);

        $query = Agendamento::query()->with(['medico.especialidade', 'medico.unidadeConsultorio', 'paciente']);

        if (!empty($filtros['medico_id'])) {
            $query->where('medico_id', $filtros['medico_id']);
        }

        if (!empty($filtros['dia'])) {
            $query->whereDate('data_hora', $filtros['dia']);
        }

        if (!empty($filtros['paciente'])) {
            $query->whereHas('paciente', function ($q) use ($filtros) {
                $q->where('nome', 'like', '%' . $filtros['paciente'] . '%');
            });
        }

        $items = $query->orderBy('data_hora')->paginate(10)->withQueryString();
        $medicos = Medico::orderBy('nome')->get();

        $diaSelecionado = $filtros['dia'] ?? now()->toDateString();
        $calendarioDia = Agendamento::with(['medico', 'paciente'])
            ->whereDate('data_hora', $diaSelecionado)
            ->orderBy('data_hora')
            ->get();

        return view('agendamentos.index', compact('items', 'medicos', 'filtros', 'diaSelecionado', 'calendarioDia'));
    }

    public function create(): View
    {
        $medicos = Medico::with(['especialidade', 'unidadeConsultorio'])->orderBy('nome')->get();
        $especialidades = Especialidade::orderBy('nome')->get();
        $pacientes = Paciente::orderBy('nome')->get();
        $statusOpcoes = Agendamento::STATUS_OPCOES;

        return view('agendamentos.create', compact('medicos', 'especialidades', 'pacientes', 'statusOpcoes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'data_hora' => 'required|date',
            'medico_id' => [
                'required',
                'exists:medicos,id',
                Rule::unique('agendamentos')->where(fn ($q) => $q
                    ->where('medico_id', $request->input('medico_id'))
                    ->where('data_hora', $request->input('data_hora'))),
            ],
            'paciente_id' => 'required|exists:pacientes,id',
            'status' => 'required|in:agendada,confirmada,atendida,cancelada',
            'observacoes' => 'nullable|string',
        ], [
            'medico_id.unique' => 'Este médico já possui agendamento neste horário.',
        ]);

        Agendamento::create($data);

        return redirect()->route('agendamentos.index')->with('status', 'Agendamento criado com sucesso.');
    }

    public function edit(Agendamento $agendamento): View
    {
        $medicos = Medico::with(['especialidade', 'unidadeConsultorio'])->orderBy('nome')->get();
        $especialidades = Especialidade::orderBy('nome')->get();
        $pacientes = Paciente::orderBy('nome')->get();
        $statusOpcoes = Agendamento::STATUS_OPCOES;

        return view('agendamentos.edit', compact('agendamento', 'medicos', 'especialidades', 'pacientes', 'statusOpcoes'));
    }

    public function update(Request $request, Agendamento $agendamento): RedirectResponse
    {
        $data = $request->validate([
            'data_hora' => 'required|date',
            'medico_id' => [
                'required',
                'exists:medicos,id',
                Rule::unique('agendamentos')->ignore($agendamento->id)->where(fn ($q) => $q
                    ->where('medico_id', $request->input('medico_id'))
                    ->where('data_hora', $request->input('data_hora'))),
            ],
            'paciente_id' => 'required|exists:pacientes,id',
            'status' => 'required|in:agendada,confirmada,atendida,cancelada',
            'observacoes' => 'nullable|string',
        ], [
            'medico_id.unique' => 'Este médico já possui agendamento neste horário.',
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
