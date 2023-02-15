@component('mail::message')
# {{$mailData['title']}}

{{$mailData['bodyMessage']}}

@component('mail::button', ['url' => url('/')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
