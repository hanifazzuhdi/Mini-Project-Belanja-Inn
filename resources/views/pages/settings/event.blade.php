@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

<div class="container mt-5">

    <div class="card">
        <div class="card-header py-3">
            <h4 class="font-weight-bold text-primary d-inline">
                List Event
            </h4>
            <div class="btn btn-primary btn-sm float-right" role="button" data-toggle="modal" data-target="#store">
                <i class="fas fa-plus text-black"></i>
            </div>
        </div>

        <div class="card-body p-4 d-flex flex-wrap justify-content-around">

            @foreach ($events as $event)
                <div class="card card-event p-1 my-4">
                    <img src="{{$event->image}}" width="100%" height="250px" alt="Event Image">
                    <h4 class="font-weight-bold text-primary p-1 pb-2 mt-2">
                        {{$event->event_name}}
                    </h4>

                    <span class="status">
                        <strong>
                            @if ($event->end_event <= date('d-m-Y H:i'))
                                Status : End
                            @else
                                Status : Active
                            @endif
                        </strong>
                    </span>

                    <div class="date pl-2 pt-4 pb-1">
                        <p> Event Start : {{$event->created_at}} </p>
                        <p> Event End &nbsp;&nbsp;: {{$event->end_event}} </p>
                    </div>

                    <form class="p-2" action="{{'/settings/destroyEvent/' . $event->id}}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm float-right" type="submit" onclick="return confirm ('Yakin ?')">
                            <i class="fas fa-trash text-black"></i>
                        </button>

                        <a class="btn btn-warning btn-sm float-right mr-2" type="submit">
                            <i class="fas fa-edit text-white"></i>
                        </a>
                    </form>
                </div>
            @endforeach

        </div>
    </div>

</div>

<div class="modal fade" id="store" tabindex="-1" role="dialog" aria-labelledby="store" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header store_account">
                <h5 class="modal-title text-center"> CREATE NEW EVENT </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('storeEvent')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label>Event Name :</label>
                            <input type="text" class="form-control" name="event_name" placeholder="Event Name">
                        </div>

                        <div class="form-group">
                            <label>End Event :</label>
                            <input type="date" class="form-control" name="end_event">
                        </div>

                        {{-- min="{{ date('Y-m-d', time() + (60 * 60 * 24)) }}" --}}

                        <div class="form-group">
                            <label>Image :</label>
                            <br>
                            <input type="file" name="image">
                        </div>

                        <div class="float-right mt-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
