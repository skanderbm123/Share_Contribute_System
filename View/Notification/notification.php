<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
            #userProfilBox {
                margin-top :10%;
                margin-left : 25%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 30%;
                
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
                #editUser {background-color: #4CAF50; /* Green */
                            }
                            .userGroup {
                margin-top :2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 90%;
                }
                .userButton{
                    float:right;
                }
            </style>
        </head>
        <body>
        <?php include("../Dashboard/navbar.php") ?>
        <div id="main">
        <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span>
            <h2 style='margin-left:30%'>Notifications</h2>
            </div>
            <h3>GROUPS</h3>
            <div id='requestGroups'>
            </div>
            <br>
            <h3>EVENTS</h3>
            <div id='requestEvents'>
            </div>

            <script>
                $(document).ready(function() {
                    var groupNotif = new Array();
                    var EventsNotif = new Array();

                    $(document).on("click","button",function(){
                       if(this.id.includes("accepteGroupUserId")){
                           var idOfButtonClicked = this.id.substring(18);

                           $.post('../../Controller/NotificationController/acceptUserToGroup.php',{userId:groupNotif[idOfButtonClicked]['userID'],groupId:groupNotif[idOfButtonClicked]['groupID']},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    groupNotif = info[1];
                                    eventNotif = info[2];
                                    createGroupBox(info[1]);
                                    createEventBox(info[2]);
                                }
                            });
                       } else if(this.id.includes("refuseGroupUserId")){
                           var idOfButtonClicked = this.id.substring(17);

                           $.post('../../Controller/NotificationController/refuseUserToGroup.php',{userId:groupNotif[idOfButtonClicked]['userID'],groupId:groupNotif[idOfButtonClicked]['groupID']},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    groupNotif = info[1];
                                    eventNotif = info[2];
                                    createGroupBox(info[1]);
                                    createEventBox(info[2]);
                                }
                            });
                       } else if(this.id.includes("accepteEventUserId")){
                           var idOfButtonClicked = this.id.substring(18);

                           $.post('../../Controller/NotificationController/acceptUserToEvent.php',{userId:eventNotif[idOfButtonClicked]['userID'],eventId:eventNotif[idOfButtonClicked]['eventID']},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    groupNotif = info[1];
                                    eventNotif = info[2];
                                    createGroupBox(info[1]);
                                    createEventBox(info[2]);
                                }
                            });
                       } else if(this.id.includes("refuseEventUserId")){
                           var idOfButtonClicked = this.id.substring(17);
                           $.post('../../Controller/NotificationController/refuseUserToEvent.php',{userId:eventNotif[idOfButtonClicked]['userID'],eventId:eventNotif[idOfButtonClicked]['eventID']},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    groupNotif = info[1];
                                    eventNotif = info[2];
                                    createGroupBox(info[1]);
                                    createEventBox(info[2]);
                                }
                            });
                       }
                    
                
                    });

                    function createGroupBox(arrayofUser){
                        $("#requestGroups").empty();
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> User Name : "+arrayofUser[x]['name']+"</span><br>"+
                                                "<span> Group Name : "+arrayofUser[x]['groupname']+"</span>";
                                                    userHtmlBox +=  "<button id= \"accepteGroupUserId"+x+"\" class='userButton'>Accept</button>";
                                                    userHtmlBox +=  "<button id= \"refuseGroupUserId"+x+"\" class='userButton' style=\"background-color:red\" >Decline</button><br>";
                                                
                                                userHtmlBox += "</div>"
                                                
                            $("#requestGroups").append(userHtmlBox);
                        }
                    }
                    function createEventBox(arrayofUser){
                        $("#requestEvents").empty();
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> User Name : "+arrayofUser[x]['name']+"</span><br>"+
                                                "<span> Event Name : "+arrayofUser[x]['eventname']+"</span>";
                                                    userHtmlBox +=  "<button id= \"accepteEventUserId"+x+"\" class='userButton'>Accept</button>";
                                                    userHtmlBox +=  "<button id= \"refuseEventUserId"+x+"\" class='userButton' style=\"background-color:red\" >Decline</button><br>";
                                                
                                                userHtmlBox += "</div>"
                                                
                            $("#requestEvents").append(userHtmlBox);
                        }

                    }
                    function getNotif(){
                    $.post('../../Controller/NotificationController/getNotificationsRequest.php',function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    groupNotif = info[1];
                                    eventNotif = info[2];
                                    createGroupBox(info[1]);
                                    createEventBox(info[2]);
                                }else{
                                }
                            });
                    }
                    getNotif();
                    setTimeout(function(){ getNotif(); }, 10000);
                   
                });
            </script>
        </body>
    </html>