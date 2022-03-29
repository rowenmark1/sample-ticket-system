<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <a href="{{ route('my.tickets.create') }}" class="btn btn-primary btn-sm">Submit a Ticket</a>
                <hr>
                <form action="">
                       <input type="text" class="form-control" id="searchbox" name="searchbox">
                       <button type="submit" class="btn btn-warning btn-sm">Search</button>
                </form>
                <hr>
                <br>
                <table class="table table-striped">



                @foreach ($tickets as $ticket)
                    <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <a>{{ $ticket->name }}</a> <br>
                        <a>{{ $ticket->priority }}</a>
                    </div> <hr>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ $ticket->subject }} </h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <form method="POST" action="/my/tickets/{{$ticket->id}}">
                        @method('DELETE')
                        @csrf
                        <a href ='/my/tickets/{{$ticket->id}}' ><button type="button" class="btn btn-primary btn-sm">Edit</button></a>
                        <a href = ''><button type="submit" class="btn btn-danger btn-sm" >Delete</button></a>
                        </form>
                        <div class="card-footer">
                        {{ $ticket->status }}
                       <hr>
                        {{ date('M d, Y h:i',strtotime($ticket->created_at)) }}
                        <br>
                        {{ date('M d, Y h:i',strtotime($ticket->updated_at)) }}
                        </div>
                    </div>
                    </div>
                    <br>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
