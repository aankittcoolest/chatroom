
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <style media="screen" href="{{ URL::asset('assets/css/chat.css') }}"></style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/sendMessage.js') }}"></script>
  </head>
  <body>

  </body>
</html>

<iframe src="{{ URL::route('join-chatroom', array('id' => $chatroom_id )) }}" width="400" height="900" scrolling="yes">
</iframe>

<div class="panel-footer">
    <div class="input-group">
        <input id="message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
        <span class="input-group-btn">
            <button class="btn btn-warning btn-sm" id="btn-chat" onclick="myFunction()">
                Send</button>
        </span>
    </div>
</div>
