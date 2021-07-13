@component('mail::message', ['sendBy' => $sendBy,'document_id' => $document_id, 'message' => $message])
# DOCUMENT #{{$document_id}}

@component('mail::panel', ['message' => $message])
{{$message}}
@endcomponent

@component('mail::footer', ['company' => 'vista'])
{{$company}}
@endcomponent


Thank You,<br>
From: {{ $sendBy }}
@endcomponent
