<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Painel do Médico - {{ $medico->nome }}</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold mb-2">Agenda e Agendamentos</h3>
            <ul class="text-sm">
                @foreach($agendamentos as $a)
                    <li>{{ $a->data_hora }} - {{ $a->paciente->nome }} ({{ $a->status }})</li>
                @endforeach
            </ul>
        </div>

        <div id="feedback-status" class="hidden p-3 rounded text-sm"></div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold mb-2">Prontuário</h3>
            <form id="form-prontuario" method="POST" action="{{ route('medico.prontuario.salvar') }}" class="space-y-2 ajax-save-form">
                @csrf
                <select name="agendamento_id" class="w-full">
                    @foreach($agendamentos as $a)
                        <option value="{{ $a->id }}">{{ $a->paciente->nome }} - {{ $a->data_hora }}</option>
                    @endforeach
                </select>
                <textarea name="queixa_principal" placeholder="Queixa principal" class="w-full"></textarea>
                <textarea name="historico" placeholder="Histórico" class="w-full"></textarea>
                <input name="sinais_vitais" placeholder="Sinais vitais" class="w-full"/>
                <textarea name="diagnostico" placeholder="Diagnóstico" class="w-full"></textarea>
                <textarea name="conduta" placeholder="Conduta" class="w-full"></textarea>
                <textarea name="observacoes" placeholder="Observações" class="w-full"></textarea>
                <button class="px-4 py-2 bg-blue-600 text-white">Salvar prontuário</button>
            </form>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold mb-2">Anamnese e Prescrição</h3>
            <form id="form-anamnese" method="POST" action="{{ route('medico.anamnese-prescricao.salvar') }}" class="space-y-2 ajax-save-form">
                @csrf
                <select name="agendamento_id" class="w-full">
                    @foreach($agendamentos as $a)
                        <option value="{{ $a->id }}">{{ $a->paciente->nome }} - {{ $a->data_hora }}</option>
                    @endforeach
                </select>
                <textarea name="dados" placeholder="Formulário de anamnese" class="w-full"></textarea>
                <textarea name="medicamentos" placeholder="Medicamentos prescritos" class="w-full"></textarea>
                <button class="px-4 py-2 bg-green-600 text-white">Salvar</button>
            </form>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold mb-2">Solicitar Exame (DCM4CHEE HL7/MLLP)</h3>
            <form id="form-exame" method="POST" action="{{ route('medico.exame.solicitar') }}" class="space-y-2 ajax-save-form">
                @csrf
                <select name="agendamento_id" class="w-full">
                    @foreach($agendamentos as $a)
                        <option value="{{ $a->id }}">{{ $a->paciente->nome }} - {{ $a->data_hora }}</option>
                    @endforeach
                </select>
                <label class="block text-sm font-medium">Exames de radiologia (20 itens, selecione um ou mais):</label>
                <select name="exame_ids[]" class="w-full" multiple size="10" required>
                    @foreach($exames as $e)
                        <option value="{{ $e->id }}">{{ $e->codigo }} - {{ $e->descricao }} ({{ $e->modalidade }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500">Use Ctrl/Cmd + clique para escolher múltiplos exames.</p>
                <input type="datetime-local" name="agendado_para" class="w-full"/>
                <button class="px-4 py-2 bg-purple-600 text-white">Enviar solicitação</button>
            </form>
            <h4 class="mt-3 font-semibold">Solicitações</h4>
            <ul class="text-sm">
                @foreach($solicitacoes as $s)
                    <li>{{ $s->numero_pedido }} - {{ $s->status }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        const statusBox = document.getElementById('feedback-status');

        function showStatus(message, success = true) {
            statusBox.textContent = message;
            statusBox.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
            statusBox.classList.add(success ? 'bg-green-100' : 'bg-red-100', success ? 'text-green-700' : 'text-red-700');
        }

        document.querySelectorAll('.ajax-save-form').forEach((form) => {
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData,
                    });

                    const result = await response.json();
                    if (!response.ok) {
                        const message = result.message || 'Erro ao salvar formulário.';
                        throw new Error(message);
                    }

                    showStatus(result.message || 'Salvo com sucesso.');
                } catch (error) {
                    showStatus(error.message || 'Erro inesperado ao salvar formulário.', false);
                }
            });
        });
    </script>
</x-app-layout>
