<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Usuários</h2>
            <a href="{{ route('usuarios.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">Novo usuário</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2">Nome</th>
                                <th class="border-b py-2">E-mail</th>
                                <th class="border-b py-2">Telefone</th>
                                <th class="border-b py-2">Status</th>
                                <th class="border-b py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <td class="py-3">{{ $usuario->nome }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->telefone ?? '-' }}</td>
                                    <td>{{ $usuario->ativo ? 'Ativo' : 'Inativo' }}</td>
                                    <td class="space-x-2">
                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="text-indigo-600 hover:underline">Editar</a>
                                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Deseja remover este usuário?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">Nenhum usuário cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $usuarios->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
