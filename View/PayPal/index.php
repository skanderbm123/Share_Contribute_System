<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>PayPal REST API Example</title>
            <style>
            
            </style>
        </head>
        <body>
            <?php include("../Dashboard/navbar.php") ?>
            <div id="main">
                <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span>
            </div>
            <form class="paypal" action="../../Controller/PayPalController/request.php" method="post" id="paypal_form">
                <input type="hidden" name="item_number" value="123456" / >
                <input type="submit" name="submit" value="Submit Payment"/>
            </form>

            <script>
                $(document).ready(function() {
                    

                });
            </script>
        </body>
    </html>