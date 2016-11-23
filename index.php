<?php
require_once ("src/classes/HangoutReader.php");

$hReader = new HangoutReader();

$output = "";
foreach($hReader->getConversations() as $c){
    $output .= "<a href='#' class='pointer' data-toggle='modal' data-target='#myModal'><li class='list-group-item' id='".$c->id."'>".$c->participant."</li></a>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link rel="stylesheet" href="src/css/styles.css">
    <title>HangoutReader</title>
</head>
<body>
<div class="container">
    <ul class="list-group conversations-box">
        <?php echo $output; ?>
    </ul>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
          <table class="table">
              <thead class="thead-default">
              <tr>
                  <th>Chatpartner</th>
                  <th>Du</th>
              </tr>
              </thead>
          </table>
          <div class="messages-box"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    $("a").click(function(event) {
        $('.messages-box').text(null);
        $.getJSON("json/built/conversations.json", function(data){

            var result = $.grep(data["conversations"], function(r){
                    return r.id == event.target.id; 
            });

            $("h4:first").text(result[0].participant);

            $('.messages-box').text(null);

            result[0].messages.forEach(function(message){
                if(message.sender_id === data['user_id']){
                    var text = "<h4><span class='tag tag-pill tag-primary' style='float: right;'>"+ message.text +"</span></h4><br>";
                }else{
                    var text = "<h4><span class='tag tag-pill tag-default'>"+ message.text +"</span></h4><br>";
                }
                $('.messages-box').append(text);
            });
        });
    });
});
</script>

</body>
</html>
