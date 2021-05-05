@component('mail::message')
# Welcome To Meshkati
# Dear, {{$content['name']}}

Your account password is ***{{$content['plain_password']}}***, click the button below in order to login.

@component('mail::button', ['url' =>config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
