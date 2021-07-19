@component('mail::message', ['object' => $object])
# Hello {{$object->name}},

A request has been received to change the password for your
Vista Global Consult account. Please click on the CHANGE PASSWORD button to reset your password

@component('mail::button', ['url' => $password_url, 'color' => 'success'])
CHANGE PASSWORD
@endcomponent

if you not initiate this request,
please contact us immediately at support@vistagconsult.com

Thanks.<br>
@endcomponent
