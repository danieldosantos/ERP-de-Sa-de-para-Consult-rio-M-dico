<x-app-layout><div class='p-6'><a href='{{ route("pacientes.create") }}'>Novo</a>@foreach(
$items as $i)<div>{{ $i->nome }}</div>@endforeach</div></x-app-layout>
