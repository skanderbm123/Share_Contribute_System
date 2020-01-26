<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
            
            </style>
        </head>
        <body>
        <?php include("../Dashboard/navbar.php") ?>
        <div id="main">
        <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span>
            <h3>Welcome <span id="username" style="color: red"> </span> to Share Contribute System</h3>
        </div>

            <script>
                $(document).ready(function() {

                    $.post('../../Controller/UserController/getCurrentUserInformation.php',{},function(data) {
                        var info = JSON.parse(data);
                        if (info[0]) {
                            $('#username').text(info[1]['name']);
                        }
                    });
                });
            </script>
        </body>
    </html>