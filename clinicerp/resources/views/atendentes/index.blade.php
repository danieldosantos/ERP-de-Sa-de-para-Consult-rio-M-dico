<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800">Atendentes</h2>
            <a href="{{ route('atendentes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">+ Novo atendente</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr><th class="px-6 py-3 text-left">Nome</th><th class="px-6 py-3 text-left">Usuário</th><th class="px-6 py-3 text-right">Ações</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $i)
                            <tr>
                                <td class="px-6 py-4">{{ $i->nome }}</td><td class="px-6 py-4">{{ $i->user?->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-right"><a href="{{ route('atendentes.edit',$i) }}" class="text-indigo-600 hover:underline">Editar</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-6 text-center text-slate-500">Nenhum atendente cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $items->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
