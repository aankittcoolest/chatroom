
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style media="screen" href="{{ URL::asset('assets/css/chat.css') }}"></style>
    <script>var URL = "{{ URL::to('/') }}";</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/sendMessage.js') }}"></script>
    <style>.online-icon{color: #66B266}
          .offline-icon{color: #666666}
          span.tab{

          padding: 0px 10px; /* Or desired space*/
          font-size: 20px;
          text-align: center;
          color: black;
      }
     </style>
  </head>
  <body>



  </body>
</html>


<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-nav-fixed affix">
                <div class="well">
                    <ul class="nav ">
                        <li class="nav-header"><h3><span class="label label-success">Online Chat Members</span></h3></li>
                        <div class="online"></div>

                        <li class="nav-header"><h3><span class="label label-warning">Offline Chat Members</span></h3></li>
                        <div class="offline"></div>

                    </ul>
                </div>
                <!--/.well -->
            </div>
            <!--/sidebar-nav-fixed -->
        </div>
        <!--/span-->
        <div class="col-md-6">
            <div class="jumbotron">
                 <h2>{{ $room_details->name }}</h2>

                 <iframe src="{{ URL::route('join-chatroom', array('id' => $room_details->id )) }}" width="400" height="900" scrolling="yes" id="chat-frame">
                 </iframe>
            </div>

            <div class="jumbotron">
              <input id="message" type="text" class="form-control input-sm" placeholder="Type your message here..." autocomplete="off" />
              <br><p>
                <input type="hidden" id="chat_room_id" value="{{ $room_details->id }}">
                <button class="btn btn-primary btn-lg" id="btn-chat" onclick="sendMessage()">
                    Send</button>
              </p>
            </div>
        </div>
        <!--/span-->
        <div class="col-md-3">
            <div class="sidebar-nav-fixed pull-right affix">
                <div class="well">
                    <ul class="nav ">
                        <li class="nav-header"><h3><span class="label label-success">Online Non chat Members</span></h3></li>
                        <table class="table table-striped online-non-members"></table>
                        <li class="nav-header"><h3><span class="label label-warning">Offline Non chat Members</span></h3></li>
                        <table class="table table-striped offline-non-members"></table>

                    </ul>
                </div>
                <!--/.well -->
            </div>
            <!--/sidebar-nav-fixed -->
        </div>
        <!--/span-->
    </div>
    <!--/row-->

    <footer>
        <p>© Ankit Chat World 2015</p>
    </footer>
</div>
<!--/.fluid-container-->
