@extends('layout.main')

@section('seo')
<title>Welcome</title>
@stop

@section('content')

@if(Auth::check())

<h2>Welcome, {{ Auth::user()->first_name }}</h2>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-info"><h4>Online Users</h4></div>
        <div class="panel panel-default">
          <div class="list-group" id="online-users">
            <table class="table table-striped">
                <tbody>
                  @if($user_names)
                    @foreach($user_names as $user_name)
                  <tr><td>  {{ $user_name }}</td></tr>
                  @endforeach
                @endif
                </tbody>
              </table>
          </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="alert alert-info"><h4>Chat Room Requests</h4></div>
        <div class="panel panel-default">
          <div class="list-group" id="online-users">
            <table class="table table-striped">
                <tbody>
                  @if($invited_chatrooms)
                    @foreach($invited_chatrooms as $invited_chatroom)
                  <tr><td>  {{ $invited_chatroom->name }}</td>
                    <td>  {{ $invited_chatroom->first_name }}</td>
                    <td>{{ HTML::linkRoute('register-chatroom', 'Accept', array('chatroom_id' => $invited_chatroom->chatroom_id, 'accept' => true), array('class' => 'btn btn-success')) }}</td>
                    <td>{{ HTML::linkRoute('register-chatroom', 'Deny', array('chatroom_id' => $invited_chatroom->chatroom_id, 'accept' => '0'), array('class' => 'btn btn-danger')) }}</td></tr>

                  @endforeach
                @endif
                </tbody>
              </table>
          </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="alert alert-info">Available Chatrooms<strong id="whoami"></strong></div>
        <div class="panel panel-default">

          <div class="list-group" id="online-users">
            @foreach($available_chat_rooms as $available_chat_room)
            <table class="table table-striped">
              <thead>
                <tr>
                  <td>Chatroom Name</td>
                  <td>Join</td>
                </tr>
              </thead>

              <tbody>


                {{ Form::open(array('class' => '', 'method' => 'post', 'action' => array('ChatRoomsController@registerChatroom', $available_chat_room->id, 1))) }}
                {{ Form::hidden('chatroom_id', $available_chat_room->id) }}
                  <tr>
                    <td>{{ $available_chat_room->name }}</td>
                    <td>{{Form::submit('Join', array('class' => 'btn btn-success'))}}</td>
                  </tr>
                </tbody>
              {{ Form::close() }}
            </table>

            @endforeach
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-info"><p>Create new chatroom</p> </div>
        <div class="panel panel-default">
          <div class="panel-heading">Online Users</div>
          <div class="list-group" id="online-users">


              {{ Form::open(array('url' => 'create-chatroom'))}}
                {{Form::label('name', 'Chatroom name')}}
                {{Form::text('name')}}
                  {{Form::submit('Create', array('class' => 'btn btn-success'))}}
                  @if($errors->has('name'))
                    @foreach($errors->get('name') as $message)
                    {{ $message }}
                    @endforeach
                  @endif

                  @if($message)
                    {{ $message }}
                  @endif
              {{ Form::close() }}
          </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="alert alert-info">Your chat rooms <strong id="whoami"></strong></div>
        <div class="panel panel-default">

          <div class="list-group" id="online-users">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <td>Chatroom Name</td>
                    <td>Number of users online</td>
                    <td>Unread messages Count</td>
                    <td>Enter</td>
                  </tr>
                </thead>
                <tbody>
                  @if($chatrooms)
                    @for ($i = 0; $i<count($chatrooms); $i++)
                  <tr><td>{{ $chatrooms[$i]->name }}</td>
                  <td>{{ $online_members[$i] }}</td>
                  <td>{{ $unread_messages_counts[$i] }}</td>
                  <td><a href="{{ URL::route('join-room', array('id' => $chatrooms[$i]->id)) }}" class="btn btn-primary">Enter</a></td></tr>
                  @endfor
                @endif
                </tbody>
              </table>

          </div>
        </div>
      </div>

    </div>
  </div>


@else
You are not logged in.
@endif

@stop
