@component('mail::message')
# Introduction

Click on the button bellow, to continue resetting your password.

@component('mail::button', ['url' => $url])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
