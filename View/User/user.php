<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
            #searchUserInput {
                width: 50%;
                padding: 12px 20px;
                margin: 8px 0;
                margin-left:15%;
                margin-top:5%;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 12px;
                box-sizing: border-box;
                }
                #userProfileBox {
                margin-top :10%;
                margin-left : 25%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 30%;
                }
                #searchUserButton {
                width: 5%;
                background-color: #1F11F7;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                margin-left:1%;
                }

                #searchUserButton:hover {
                background-color: #1006A6;
                }
                #createUserButton {
                width: 5%;
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                margin-left:1%;
                }

                #createUserButton:hover {
                background-color: #45a049;
                }
                .userGroup{
                margin-top :2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 90%;
                
                }
                .userButton{
                    float:right;
                }
                #UserSearched{
                    width : 45%;
                    margin-left:20%
                }
                input[type=text], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                }

                input[type=date], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                }
            </style>
        </head>
        <body>
        <?php include("../Dashboard/navbar.php") ?>
        <div id="main">
        <div id="mainUserPge">
        <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span><br>
        <input type="text" id="searchUserInput" placeholder="Search User...">
        <button id="searchUserButton">Search</button>
        <button id="createUserButton" data-toggle="modal", data-target = "#createUserModal">Create</button>
        </div>
            <div id="UserSearched">

            </div>

        <div id ="UserProfile">
            <button id="backToSearchUser" style="margin-left:40%">Back</button><br>
            <div id ="userProfileBox" >
                <p> Name : <span id="userName"></span></p>
                <p> Email  : <span id="userEmail"></span></p>
                <p> Birthday  : <span id="userBirthday"></span></p>
            </div>
        </div>
            <!--MODAL SECTION -->

            <div class="modal fade" id="createUserModal">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">Create A New User</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <span> Name :</span><br> <input type="text" id="uName" ><br>
                            <span> Date Of Birth :</span><br> <input type="date" id="userDOB"><br>
                            <span> Email :</span><br> <input type="text" id="userEmail"> <br>
                            <span> UserName :</span><br><input type="text" id="userName"><br>
                            <span> Password :</span><br><input type="text" id="userPassword"><br>
                            <span> Is Admin :</span><br><input type="checkbox" id="isAdmin"><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="saveUser" class="btn btn-default" data-dismiss="modal">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <script>

                $(document).ready(function() {
                    $("#UserProfile").hide();

                    addUserButton();
                    // This function checks the current user if admin then he can add a new user
                    function addUserButton() {
                        $.post('../../Controller/isAdmin.php',{},function (data) {
                            // data == 0 means the current user is not an admin
                            if (data == 0) {
                                $("#createUserButton").hide();
                            }
                        })
                    }
                    function createUserBox(arrayofUser, isAdmin){
                        $("#UserSearched").empty();

                        // If the logged in user is an Admin he can see all three buttons.
                        if(isAdmin) {
                            for(var x = 0; x<arrayofUser.length;x++ ){
                                var userHtmlBox = "<div class = 'userGroup', id='UserBox'> "+
                                    "<span> User Name : "+arrayofUser[x]['name']+"</span>"+
                                    "<button id= \"DeleteUserId"+arrayofUser[x]['ID']+"\" class='userButton'>Delete</button>"+
                                    "<button id= \"EditUserId"+arrayofUser[x]['ID']+"\" class='userButton'>Edit</button>"+
                                    "<button id= \"MessageUserId"+arrayofUser[x]['ID']+"\" class='userButton'>Message</button>"+
                                    "<button id= \"ViewUserId"+arrayofUser[x]['ID']+"\" class='userButton'>User Details</button>"
                                userHtmlBox += "</div>"

                                $("#UserSearched").append(userHtmlBox);
                            }
                        } else {
                            for(var x = 0; x<arrayofUser.length;x++ ){
                                var userHtmlBox = "<div class = 'userGroup'> "+
                                    "<span> User Name : "+arrayofUser[x]['name']+"</span>"+
                                    "<button id= \"MessageUserId"+x+"\" class='userButton'>Message</button>"
                                userHtmlBox += "</div>"

                                $("#UserSearched").append(userHtmlBox);
                            }
                        }
                    }

                    $("#searchUserButton").click(function(){
                        if($("#searchUserInput").val() != ""){
                            $.post('../../Controller/UserController/searchUser.php',{name:$("#searchUserInput").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createUserBox(info[1], info[2]);
                                }else{
                                }
                            });
                        }else{
                            alert("You need to enter a user name to search for!");
                        }
                    });

                    $("#saveUser").click(function(){
                        var isAdminVal;
                        if($("#uName").val() == ""||$("#userDOB").val() == ""||$("#userEmail").val() == ""||$("#userName").val() == "" || $("#userPassword").val() == ""){
                            alert("All fields must be field");
                        }else{
                            if ($("#isAdmin").is(":checked"))
                            {
                                isAdminVal = 1;
                            } else {
                                isAdminVal = 0;
                            }
                            $.post('../../Controller/UserController/addUser.php',{name:$("#uName").val(),userDOB:$("#userDOB").val(),email:$("#userEmail").val(),userName:$("#userName").val(),password:$("#userPassword").val(),isAdmin:isAdminVal},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    alert("User "+ info[1] +"Created Successfully ");
                                }else{
                                    alert("You need to be an admin to create a user");
                                }
                            });
                        }
                    });

                    $("#backToSearchUser").click(function(){
                        $("#UserProfile").hide();
                        $("#mainUserPge").show();
                        $("#UserSearched").show();

                    });

                    $(document).on("click","button",function () {
                        if(this.id.includes("ViewUserId")) {
                            var idOfUser = this.id.substring(10);
                            $("#UserProfile").show();
                            $("#mainUserPge").hide();
                            $("#UserSearched").hide();

                            $.post('../../Controller/UserController/getUserInformation.php',{userId:idOfUser},function (data) {
                                var info = JSON.parse(data);
                                if(info[0]){
                                    $("#userName").text(info[1]['name']);
                                    $("#userEmail").text(info[1]['email']);
                                    $("#userBirthday").text(info[1]['birth']);
                                }
                            })

                        }
                    })
                });
            </script>
        </body>
    </html>