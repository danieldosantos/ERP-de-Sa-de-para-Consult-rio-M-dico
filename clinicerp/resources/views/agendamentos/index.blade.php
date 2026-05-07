<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Agendamentos</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="flex justify-between items-center gap-4">
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div>
                    <x-input-label for="medico_id" value="Médico" />
                    <select id="medico_id" name="medico_id" class="mt-1 block w-56 rounded-md border-gray-300">
                        <option value="">Todos</option>
                        @foreach($medicos as $medico)
                            <option value="{{ $medico->id }}" @selected(($filtros['medico_id'] ?? null) == $medico->id)>{{ $medico->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="dia" value="Dia" />
                    <x-text-input id="dia" name="dia" type="date" class="mt-1 block" :value="$filtros['dia'] ?? ''" />
                </div>
                <div>
                    <x-input-label for="paciente" value="Paciente" />
                    <x-text-input id="paciente" name="paciente" type="text" class="mt-1 block" :value="$filtros['paciente'] ?? ''" placeholder="Buscar por nome" />
                </div>
                <x-primary-button>Filtrar</x-primary-button>
            </form>
            <a href="{{ route('agendamentos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-indigo-300 rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200">Novo agendamento</a>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"><div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="font-semibold mb-3">Calendário simples — {{ \Illuminate\Support\Carbon::parse($diaSelecionado)->format('d/m/Y') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 text-sm">
                @forelse($calendarioDia as $agenda)
                    <div class="border border-gray-200 dark:border-gray-700 rounded p-3">
                        <p class="font-semibold">{{ $agenda->data_hora?->format('H:i') }}</p>
                        <p>Médico: {{ $agenda->medico->nome }}</p>
                        <p>Paciente: {{ $agenda->paciente->nome }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">Sem consultas para o dia selecionado.</p>
                @endforelse
            </div>
        </div></div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"><div class="p-6 text-gray-900 dark:text-gray-100">
            <table class="w-full text-left border-collapse"><thead><tr><th class="border-b py-2">Data e hora</th><th class="border-b py-2">Médico</th><th class="border-b py-2">Paciente</th><th class="border-b py-2">Status</th><th class="border-b py-2 text-right">Ações</th></tr></thead><tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="py-3">{{ $item->data_hora?->format('d/m/Y H:i') }}</td><td class="py-3">{{ $item->medico->nome }}</td><td class="py-3">{{ $item->paciente->nome }}</td><td class="py-3 capitalize">{{ $item->status }}</td><td class="py-3 text-right"><a href="{{ route('agendamentos.edit', $item) }}" class="text-indigo-600 hover:underline">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-500">Nenhum agendamento cadastrado.</td></tr>
                @endforelse
            </tbody></table>
            <div class="mt-4">{{ $items->links() }}</div>
        </div></div>
    </div></div>
</x-app-layout>
