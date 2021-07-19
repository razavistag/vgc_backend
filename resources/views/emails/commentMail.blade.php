@component('mail::message', ['sendBy' => $sendBy,'document_id' => $document_id, 'message' => $message])
# DOCUMENT #{{$document_id}}

@component('mail::panel', ['message' => $message])
{{$message}}
@endcomponent


Thank You,<br>
From: {{ $sendBy }}
@endcomponent
