<h3>Create new chatroom</h3>

{{ Form::open(array('url' => 'create-chatroom'))}}
  {{Form::label('name', 'Chatroom name')}}
  {{Form::text('name')}}
      @if($errors->has('name'))
        @foreach($errors->get('name') as $message)
        {{ $message }}
        @endforeach
      @endif
  {{Form::submit('Create')}}
{{ Form::close() }}
