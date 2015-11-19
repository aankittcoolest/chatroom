<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/messages.js') }}"></script>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
  </head>
  <body>

<div id="messages">
        @foreach($messages as $message)
          <ul>{{ $message }}</ul>
        @endforeach
</div>

<!--
    @if($messages)
        @foreach($messages as $message)
          {{ $message }}<br>
        @endforeach
    @endif
-->



<input type="text" id="message">
<button type="button" class="btn btn-success" onclick="myFunction()">Send</button>


<form onsubmit="myFunction()">
  


  </body>
</html>
