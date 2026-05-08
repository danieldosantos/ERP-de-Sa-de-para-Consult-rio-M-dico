<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Painel de Exames</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold mb-3">Cadastrar exame</h3>
            <form method="POST" action="{{ route('exames.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                @csrf
                <input name="codigo" value="{{ old('codigo') }}" placeholder="Código (ex.: CTCRANIO01)" class="w-full" required>
                <input name="descricao" value="{{ old('descricao') }}" placeholder="Descrição" class="w-full md:col-span-2" required>
                <select name="modalidade" class="w-full" required>
                    <option value="">Modalidade</option>
                    @foreach(['CR' => 'Raio-X', 'CT' => 'Tomografia', 'MR' => 'Ressonância', 'US' => 'Ultrassom', 'MG' => 'Mamografia'] as $sigla => $nome)
                        <option value="{{ $sigla }}" @selected(old('modalidade') === $sigla)>{{ $sigla }} - {{ $nome }}</option>
                    @endforeach
                </select>
                <div class="md:col-span-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Cadastrar exame</button>
                </div>
            </form>
            @if($errors->any())
                <ul class="text-red-600 text-sm mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold mb-3">Exames cadastrados</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Código</th>
                            <th class="py-2">Descrição</th>
                            <th class="py-2">Modalidade</th>
                            <th class="py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exames as $exame)
                            <tr class="border-b">
                                <td class="py-2">{{ $exame->codigo }}</td>
                                <td class="py-2">{{ $exame->descricao }}</td>
                                <td class="py-2">{{ $exame->modalidade }}</td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('exames.destroy', $exame) }}" onsubmit="return confirm('Remover exame?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-3 text-gray-500">Nenhum exame cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
