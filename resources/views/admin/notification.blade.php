@foreach($tickets as $ticket)
    <div>
        <h3>{{ $ticket->title }}</h3>
        <p>{{ $ticket->description }}</p>
        <!-- Display other ticket details -->
    </div>
@endforeach
