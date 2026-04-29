<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Editar usuário</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="p-6 text-gray-900 dark:text-gray-100">
                    @method('PUT')
                    @include('usuarios._form', ['botao' => 'Atualizar', 'modoEdicao' => true])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
