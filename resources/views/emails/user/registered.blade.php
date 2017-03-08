@component('mail::message')
# Hola {{$user->first_name}} {{$user->last_name}}, Bienvenido a Etrack

Se ha registrado exitosamente en la plataforma de etrack, a continuación se muestran sus credenciales de acceso:.

@component('mail::panel')
Email: {{$user->email}}.
Password: {{$password}}.
@endcomponent

@component('mail::button', ['url' => ''])
Ir a Etrack
@endcomponent

Muchas Gracias,<br>
{{ config('app.name') }}
@endcomponent
