@component('mail::message')
# Daily Quote

@component('mail::panel')
{{ $dailyQuete }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
