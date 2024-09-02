@component('mail::message')
# Ticket Created

A new ticket has been created with the following details:

**Trace ID**: {{ $ticket->trace_id }}  
**Provider Name**: {{ $ticket->provider_name }}  
**Issue Category**: {{ $ticket->issue_category }}  
**Issue Description**: {{ $ticket->issue_description }}  
**Priority**: {{ $ticket->priority }}  
**Status**: {{ $ticket->status }}  
**Created By**: {{ $ticket->creator->name ?? 'Unknown' }} <!-- Display the user's name -->


@if ($ticket->attachments)
    **Attachments**:
    @foreach (json_decode($ticket->attachments) as $attachment)
        - [{{ basename($attachment) }}]({{ asset('storage/' . $attachment) }})
    @endforeach
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
