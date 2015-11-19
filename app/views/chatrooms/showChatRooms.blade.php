<h2>Available chat Rooms</h2>
@foreach($chatrooms as $chatroom)
  <li>{{ $chatroom->name }}</li>
  {{ Form::open(array('url' => 'register-chatroom'))}}
       {{ Form::hidden('chatroom_id', $chatroom->id) }}
    {{Form::submit('Join')}}
  {{ Form::close() }}
@endforeach
