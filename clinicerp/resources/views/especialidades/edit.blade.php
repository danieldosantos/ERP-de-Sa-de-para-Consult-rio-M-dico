<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Editar especialidade</h2></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8"><div class="bg-white shadow-sm rounded-xl border border-slate-200"><form method="POST" action="{{ route('especialidades.update', $especialidade) }}" class="p-6 space-y-6">@csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700">Nome</label><input name="nome" value="{{ old('nome',$especialidade->nome) }}" required class="mt-1 w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500"></div>
            <div><label class="block text-sm font-medium text-slate-700">Status</label><select name="ativo" class="mt-1 w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500"><option value="1" @selected(old('ativo',$especialidade->ativo)==1)>Ativo</option><option value="0" @selected(old('ativo',1)==0)>Inativo</option></select></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-700">Descrição</label><textarea name="descricao" rows="3" class="mt-1 w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500">{{ old('descricao',$especialidade->descricao) }}</textarea></div>
        <div class="flex gap-3"><button class="px-5 py-2.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white">Salvar</button><a href="{{ route('especialidades.index') }}" class="px-5 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700">Cancelar</a></div>
    </form></div></div></div>
</x-app-layout>
