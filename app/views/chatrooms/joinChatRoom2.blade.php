<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="10">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <style media="screen" href="{{ URL::asset('assets/css/chat.css') }}"></style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/messages.js') }}"></script>
  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-comment"></span> Chat

                    </div>
                    <div class="panel-body">
                        <ul class="chat">
                                @if($messages)
                                @foreach($messages as $message)
                                  @if($message->id == Auth::user()->id)
                                    <li class="right clearfix"><span class="chat-img pull-right">
                                        <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                                    </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>15 mins ago</small>
                                                <strong class="pull-right primary-font">{{ $message->first_name }}</strong>
                                            </div>
                                            <p>
                                                {{ $message->message }}
                                            </p>
                                        </div>
                                    </li>
                                  @else
                                        <li class="left clearfix"><span class="chat-img pull-left">
                                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                                        </span>
                                            <div class="chat-body clearfix">
                                                <div class="header">
                                                    <strong class="primary-font">{{ $message->first_name }}</strong> <small class="pull-right text-muted">
                                                        <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                                                </div>
                                                <p>
                                                    {{ $message->message }}
                                                </p>
                                            </div>
                                        </li>
                                  @endif

                                @endforeach
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </body>
</html>
