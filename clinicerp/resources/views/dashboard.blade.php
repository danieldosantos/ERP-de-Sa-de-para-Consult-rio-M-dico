<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard inicial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            @if (session('status'))
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-md">{{ session('status') }}</div>
            @endif
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500">Acesso</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Login protegido ativo</p>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500">Módulo</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cadastro de usuários</p>
                <a href="{{ route('usuarios.index') }}" class="text-indigo-600 text-sm hover:underline">Acessar módulo</a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500">Status da fase</p>
                <p class="text-lg font-semibold text-green-600">Dias 1–3 concluídos</p>
            </div>
        </div>
    </div>
</x-app-layout>
