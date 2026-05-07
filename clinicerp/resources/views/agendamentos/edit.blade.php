<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Editar agendamento</h2></x-slot>
<div class="py-12"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8"><div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"><form method="POST" action="{{ route('agendamentos.update', $agendamento) }}" class="p-6 space-y-6 text-gray-900 dark:text-gray-100">@csrf @method('PUT')
<div><x-input-label for="data_hora" value="Data e hora" /><x-text-input id="data_hora" name="data_hora" type="datetime-local" class="mt-1 block w-full" :value="old('data_hora', $agendamento->data_hora?->format('Y-m-d\TH:i'))" required /></div>
<div><x-input-label for="especialidade_id" value="Especialidade" /><select id="especialidade_id" class="mt-1 block w-full rounded-md border-gray-300"><option value="">Selecione (opcional)</option>@foreach($especialidades as $especialidade)<option value="{{ $especialidade->id }}" @selected(old('especialidade_id')==$especialidade->id)>{{ $especialidade->nome }}</option>@endforeach</select></div>
<div><x-input-label for="medico_id" value="Médico" /><select id="medico_id" name="medico_id" class="mt-1 block w-full rounded-md border-gray-300" required>@foreach($medicos as $medico)<option value="{{ $medico->id }}" data-especialidade-id="{{ $medico->especialidade_id }}" @selected(old('medico_id', $agendamento->medico_id)==$medico->id)>{{ $medico->nome }} - {{ $medico->especialidade?->nome ?? 'Sem especialidade' }} - {{ $medico->unidadeConsultorio?->nome ?? 'Sem unidade' }}</option>@endforeach</select></div>
<div><x-input-label for="paciente_id" value="Paciente" /><select id="paciente_id" name="paciente_id" class="mt-1 block w-full rounded-md border-gray-300" required>@foreach($pacientes as $paciente)<option value="{{ $paciente->id }}" @selected(old('paciente_id', $agendamento->paciente_id)==$paciente->id)>{{ $paciente->nome }}</option>@endforeach</select></div>
<div><x-input-label for="status" value="Status" /><select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300" required>@foreach($statusOpcoes as $status)<option value="{{ $status }}" @selected(old('status', $agendamento->status)===$status)>{{ ucfirst($status) }}</option>@endforeach</select></div>
<div><x-input-label for="observacoes" value="Observações" /><textarea id="observacoes" name="observacoes" class="mt-1 block w-full rounded-md border-gray-300">{{ old('observacoes', $agendamento->observacoes) }}</textarea></div>
<div class="flex gap-3"><button class="px-5 py-2.5 rounded-lg bg-teal-100 hover:bg-teal-200 text-teal-900 border border-teal-300">Salvar</button><a href="{{ route('agendamentos.index') }}" class="px-5 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700">Cancelar</a></div>
</form></div></div></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const especialidadeSelect = document.getElementById('especialidade_id');
    const medicoSelect = document.getElementById('medico_id');
    const options = Array.from(medicoSelect.options);

    especialidadeSelect.addEventListener('change', function () {
        const especialidadeId = this.value;
        const medicoAtual = medicoSelect.value;
        medicoSelect.innerHTML = '';
        options.forEach(option => {
            if (!especialidadeId || option.dataset.especialidadeId === especialidadeId) {
                medicoSelect.appendChild(option.cloneNode(true));
            }
        });
        if ([...medicoSelect.options].some(opt => opt.value === medicoAtual)) {
            medicoSelect.value = medicoAtual;
        }
    });
});
</script>
</x-app-layout>
