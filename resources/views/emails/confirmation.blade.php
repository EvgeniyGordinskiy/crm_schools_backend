@component('mail::message')
# Introduction

Click on the button bellow, to approve your email.

@component('mail::button', ['url' => $url])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
