<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayPal Purchase: Success</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var time = 3;
            function updateTimer(){
                document.getElementById("redirect").innerText = `${time} seconds`;
                time--;
                if(time < 0)
                    window.location.href = "..\\Event\\event.php";
            }
            updateTimer();
            window.setInterval(updateTimer, 1000);
        });
    </script>
</head>
<body>
        <?php include("../Dashboard/dashboard.php") ?>

	<h1>Successful Payment</h1>
    <p>Redirecting in: <span id='redirect'></span></p>
    <p>Or click here: <a href="..\\Event\\event.php">Back to Events</p>
</body>
</html>