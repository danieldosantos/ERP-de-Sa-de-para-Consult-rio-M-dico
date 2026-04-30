<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pacientes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="flex justify-end">
                <a href="{{ route('pacientes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-indigo-300 rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200 focus:bg-indigo-200 active:bg-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cadastrar paciente
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2">Nome</th>
                                <th class="border-b py-2 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="py-3">{{ $item->nome }}</td>
                                    <td class="py-3 text-right"><a href="{{ route('pacientes.edit', $item) }}" class="text-indigo-600 hover:underline">Editar</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-6 text-center text-gray-500">
                                        Nenhum paciente cadastrado.
                                        <div class="mt-3">
                                            <a href="{{ route('pacientes.create') }}" class="text-indigo-600 hover:underline font-semibold">Clique aqui para cadastrar o primeiro paciente.</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
