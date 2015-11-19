@extends('layout.main')

@section('seo')
<title>Welcome</title>
@stop

@section('content')

@if(Auth::check())
Welcome, {{ Auth::user()->name }}
<h3>Available chatrooms</h3>

<li><a href="{{ URL::route('show-chatrooms') }}">Show chat rooms</a></li>

<h3>Your chatrooms</h3>

  @for ($i = 0; $i<count($chatrooms); $i++)
    <li><a href="{{ URL::route('join-room', array('id' => $chatrooms[$i]->id)) }}">{{ $chatrooms[$i]->name }}</a>&nbsp;{{ $online_members[$i] }}</li>


  @endfor

  <h3>Create new chatroom</h3>

  {{ Form::open(array('url' => 'create-chatroom'))}}
    {{Form::label('name', 'Chatroom name')}}
    {{Form::text('name')}}
        @if($errors->has('name'))
          @foreach($errors->get('name') as $message)
          {{ $message }}
          @endforeach
        @endif
    <p>
      {{Form::submit('Create', array('class' => 'btn btn-success'))}}
    </p>
  {{ Form::close() }}


  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-info">Online Users</div>
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
        <div class="alert alert-info">Available Chatrooms<strong id="whoami"></strong></div>
        <div class="panel panel-default">

          <div class="list-group" id="online-users">
            @foreach($chatrooms as $chatroom)
            <table class="table table-striped">
              {{ Form::open(array('url' => 'register-chatroom'))}}
              {{ Form::hidden('chatroom_id', $chatroom->id) }}
              <tbody>
                  <tr>
                    <td>{{ $chatroom->name }}</td>
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
                    @if($errors->has('name'))
                      @foreach($errors->get('name') as $message)
                      {{ $message }}
                      @endforeach
                    @endif

                  {{Form::submit('Create', array('class' => 'btn btn-success'))}}

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
                  <td>{{ $online_members[$i] }}</td>
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
