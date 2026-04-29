@csrf

<div>
    <x-input-label for="nome" :value="__('Nome')" />
    <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500" :value="old('nome', $usuario->nome ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('nome')" />
</div>

<div class="mt-4">
    <x-input-label for="email" :value="__('E-mail (login)')" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500" :value="old('email', $usuario->email ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('email')" />
</div>

<div class="mt-4">
    <x-input-label for="telefone" :value="__('Telefone')" />
    <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500" :value="old('telefone', $usuario->telefone ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('telefone')" />
</div>

<div class="mt-4">
    <x-input-label for="password" :value="$modoEdicao ? __('Nova senha (opcional)') : __('Senha de acesso')" />
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500" :required="!$modoEdicao" />
    <x-input-error class="mt-2" :messages="$errors->get('password')" />
</div>

<div class="mt-4">
    <x-input-label for="password_confirmation" :value="$modoEdicao ? __('Confirmar nova senha') : __('Confirmar senha')" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500" :required="!$modoEdicao" />
</div>

<div class="mt-4">
    <x-input-label for="ativo" :value="__('Status')" />
    <select id="ativo" name="ativo" class="mt-1 block w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500">
        <option value="1" @selected(old('ativo', (int) ($usuario->ativo ?? 1)) === 1)>Ativo</option>
        <option value="0" @selected(old('ativo', (int) ($usuario->ativo ?? 1)) === 0)>Inativo</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('ativo')" />
</div>

<div class="mt-6 flex items-center gap-3">
    <button class="px-5 py-2.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-medium">{{ $botao }}</button>
    <a href="{{ route('usuarios.index') }}" class="px-5 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium">Cancelar</a>
</div>
