@component('mail::message')
# ¡Bienvenido a FitTracker!

**{{ $nombreEntrenador }}** te ha invitado a unirte a FitTracker.

Haz clic en el botón para crear tu cuenta:

@component('mail::button', ['url' => $urlInvitacion])
Crear mi cuenta
@endcomponent

Este enlace expirará en 48 horas.

Gracias,
FitTracker
@endcomponent