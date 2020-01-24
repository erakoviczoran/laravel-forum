@component('mail::message')
# One last step

We just need you to verify your email address to prove that you are human. You get it, right? Cool.

@component('mail::button', ['url' => $url])
    Verify email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
