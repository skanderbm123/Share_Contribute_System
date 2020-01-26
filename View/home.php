<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
                #main  {
                    position:fixed;
                    padding:0;
                    margin:0;

                    height:110%;
                    width :110%;
                    background-image: url("../Wallpaper/background_wallpaper.jpg");
                }
                #loginForm {
                border-radius: 5px;
                background-color: white;
                padding: 20px;
                width:25%;
                margin-left:30%;
                margin-top:12%
                }
                input[type=text], input[type=password], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                }

                #login {
                width: 100%;
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                }

                input:hover{
                    background-color: rgba(0,0,0,0.08);
                }

                #login:hover {
                background-color: #45a049;
                }

            </style>
        </head>
        <body>
            <div id = "main">
                <div id= "loginForm"> 
                <h3><strong>Share Contribute System</strong></h3>
                    <form action="">
                        <label >Username</label>
                        <input type="text" id="loginUsername" placeholder="Username...">

                        <label >Password</label>
                        <input type="password" id="loginPassword" placeholder="Password...">

                        <input type="button" id="login" value="Login">
                        <span >Forgot <a href="#">password?</a></span>
                    </form>
                </div>
            </div>


            <script>
                $(document).ready(function() {

                // Get the password input field
                var input = document.getElementById("loginPassword");

                // add listener for key up
                input.addEventListener("keyup", function(event) {
                  // Number 13 is the "Enter" key on the keyboard
                  if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
                    document.getElementById("login").click();
                  }
                });

                   $("#login").click(function(){

                    $.post('../Controller/LoginController/loginUser.php',{username:$("#loginUsername").val(),password:$("#loginPassword").val()},function(data){
                        var info = JSON.parse(data);
                        if(info != "false"){
                            if(info[0]){
                                window.location.href = "../View/Dashboard/dashboard.php"
                            }
                            else{
                                alert("Error, wrong credentials.");
                            }
                        }else{
                            alert("You need to enter good credentials!")
                        }
                    });

                   });


                });
            </script>
        </body>
    </html>
