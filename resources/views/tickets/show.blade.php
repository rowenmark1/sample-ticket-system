<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-600 leading-tight">
            {{ __('Tickets / Edit') }}
        </h2>
    </x-slot>
<style>
    body {
    background-color: #f7f6f6
}

.card {
    border: none;
    box-shadow: 5px 6px 6px 2px #e9ecef;
    border-radius: 4px
}


.badge {
    padding: 7px;
    padding-right: 9px;
    padding-left: 16px;
    box-shadow: 5px 6px 6px 2px #e9ecef
}


.check-icon {
    font-size: 17px;
    color: #c3bfbf;
    top: 1px;
    position: relative;
    margin-left: 3px
}

.form-check-input {
    margin-top: 6px;
    margin-left: -24px !important;
    cursor: pointer
}

.form-check-input:focus {
    box-shadow: none
}

.icons i {
    margin-left: 8px
}


</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form  method="POST" action="/my/tickets/{{$ticket->id}}">
                @method('PUT')
                @csrf

                <div>
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$ticket->name}}">
                </div>

                <div>
                    <label for="subject" class="form-label">Subjects</label>
                    <input type="text" class="form-control" id="subject" name="subject" value="{{$ticket->subject}}">
                </div>

                <div>
                    <label for="label" class="form-label">Label</label>
                    <input type="text" class="form-control" id="label" name="label" value="{{$ticket->label}}">
                </div>

                @if (Auth::user()->role == 'Admin' )
                <div>
                    <label for="assignee_id" class="form-label">Assignee ID</label>
                    <select class="form-select" aria-label="Default select example" id="assignee_id"  name="assignee_id" value="{{$ticket->assignee_id}}" >
                    @foreach ($users as $user)
                    <option value="{{$user->id}}" {{($ticket->assignee_id==$user->id) ?"selected" :"''"}}>{{$user->name}}</option>
                    @endforeach
                    </select>
                </div>

                <div>
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select" aria-label="Default select example" id="priority"  name="priority" value="{{$ticket->priority}}">
                    <option value="High" {{($ticket->priority=='High') ?"selected" :"''"}}>High</option>
                    <option value="Low"  {{($ticket->priority=='Low') ?"selected" :"''"}}>Low</option>
                    <option value="Mid"  {{($ticket->priority=='Mid') ?"selected" :"''"}}>Mid</option>
                    </select>
                </div>



                <div>
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" aria-label="Default select example" id="status"  name="status" value="{{$ticket->status}}">
                    <option value="Rejected" {{($ticket->status=='Rejected') ?"selected" :"''"}}>Rejected</option>
                    <option value="Resolve" {{($ticket->status=='Resolve') ?"selected" :"''"}}>Resolve</option>
                    </select>
                </div>

                @endif



                <div>

                    Submitted by: {{$ticket->submitter->name}} <br>
                    Submitted at: {{$ticket->created_at}}
                </div>

                <input type="hidden" id="id" name="id" value="{{$ticket->id}}">

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="btn btn-dark">Update Ticket</button>
                </div>

                </form>

                <form method="POST" action="/comments">
                @csrf
                <div>
                    <label for="messages" class="form-label">Comments</label>
                    <textarea class="form-control" rows="7" placeholder="Message" class="form-control" id="messages" name="messages"></textarea>
                </div>

                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="btn btn-dark">Submit Comment Ticket</button>
                </div>


                </form>

                    <hr>


                <div>
                @foreach($ticket->comments as $comment)
                <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="user d-flex flex-row align-items-center"><span><small class="font-weight-bold text-primary"> {{$comment->user->name}}</small> <small class="font-weight-bold">{{$comment->messages}}</small></span> </div> <small>{{$comment->created_at}}
                        <form method="POST" action="/comments/{{$comment->id}}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form></small>
                </div>

                </div>
<br>
                @endforeach
                </div>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
