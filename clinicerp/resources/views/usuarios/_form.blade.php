@csrf

<div>
    <x-input-label for="nome" :value="__('Nome')" />
    <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome', $usuario->nome ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('nome')" />
</div>

<div class="mt-4">
    <x-input-label for="email" :value="__('E-mail (login)')" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $usuario->email ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('email')" />
</div>

<div class="mt-4">
    <x-input-label for="telefone" :value="__('Telefone')" />
    <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" :value="old('telefone', $usuario->telefone ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('telefone')" />
</div>

<div class="mt-4">
    <x-input-label for="password" :value="$modoEdicao ? __('Nova senha (opcional)') : __('Senha de acesso')" />
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :required="!$modoEdicao" />
    <x-input-error class="mt-2" :messages="$errors->get('password')" />
</div>

<div class="mt-4">
    <x-input-label for="password_confirmation" :value="$modoEdicao ? __('Confirmar nova senha') : __('Confirmar senha')" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" :required="!$modoEdicao" />
</div>

<div class="mt-4">
    <x-input-label for="ativo" :value="__('Status')" />
    <select id="ativo" name="ativo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="1" @selected(old('ativo', (int) ($usuario->ativo ?? 1)) === 1)>Ativo</option>
        <option value="0" @selected(old('ativo', (int) ($usuario->ativo ?? 1)) === 0)>Inativo</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('ativo')" />
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>{{ $botao }}</x-primary-button>
    <a href="{{ route('usuarios.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
</div>
