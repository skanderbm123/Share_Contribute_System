<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
                .messageContent {
                margin-top :2%;
                margin-left:5%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                height:600px;
                width: 50%;
                float:left;
                box-shadow: 2px 5px #888888;
                }
                .overallMessage {
                margin-top :2%;
                margin-left : 2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                height:100%;
                width: 15%;
                float:left;
                box-shadow: 2px 5px #888888;
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
                .userGroup {
                margin-top :2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 90%;
                }
                .userGroupAllConvo {
                margin-top :2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 10px;
                width: 90%;
                }
                .userGroup2 :hover{
                    background-color:lightgrey;
                    cursor:pointer;
                }
                .userButton{
                    float:right;
                }
                #inputMessage{
                    float: left;
                    bottom: 0;
                }
                #headerConversation{
                    height:50px;
                }
                #bodyConversation{
                    height:350px;
                }
            </style>
        </head>
        <body style="overflow-x:hidden">
        <?php include("../Dashboard/navbar.php") ?>
        
        <div id="main" >
            <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span><br>
            <div class ="overallMessage">
                <h3>Chats <button data-toggle="modal" data-target="#messageUserModal">+</button></h3>
                <div id="allConvo" style="border-top:1px solid black">
                </div>
            </div>
            <div class="messageContent">
                <div id="headerConversation" style="border-bottom : 1px solid black">
                <h3 id="toConversation"></h3>
                <input id="storeConvoID" hidden/>
                </div>
                <div id="bodyConversation">
                    <div id="actualConvo"></div>
                </div>
                <div id="footerConversation">
                <input type="text" id="inputMessage" />
                <button id="sendmMessageButton">Send</button>
                </div>
            </div>
            
        </div>
        <div class="modal fade" id="messageUserModal">
                <div class="modal-dialog">
                
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                   
                    <h4 class="modal-title">Message User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchUserToInvite" placeholder="Search User...">
                        <button id="searchUserToInviteButton">Search</button>
                        <div id="UserSearched">

                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
                </div>
        </div>
            <script>
                $(document).ready(function() {

                    // Get the password input field
                    var input = document.getElementById("inputMessage");

                    // add listener for key up
                    input.addEventListener("keyup", function(event) {
                      // Number 13 is the "Enter" key on the keyboard
                      if (event.keyCode === 13) {
                        // Cancel the default action, if needed
                        event.preventDefault();
                        // Trigger the button element with a click
                        document.getElementById("sendmMessageButton").click();
                      }
                    });

                    $(document).on("click","button",function(){
                       if(this.id.includes("userConvo")){
                           var idSelected = this.id.substring(9);
                           $.post('../../Controller/EventController/getConvoByID.php',{id:idSelected},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    $("#toConversation").text(info[2][0]['name']);
                                    $("#storeConvoID").val(idSelected);
                                    createConvoBox(info[1]);
                                }else{
                                }
                            });
                       }else if(this.id.includes("addUserId")){
                        var idSelected = this.id.substring(9);
                        $.post('../../Controller/EventController/createConvo.php',{id:idSelected},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createAllConvoBox(info[1]);
                                }else{
                                }
                            });
                       }
                    
                
                    });

                    $.post('../../Controller/EventController/getAllConversationForUser.php',function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createAllConvoBox(info[1]);
                                }else{
                                }
                            });
                    /**
                     * Resets the text to empty for the message input
                     */
                    function resetInput(){
                        $("#inputMessage").val("");
                    }

                    function createMessageBox(arrayofUser){
                        $("#UserSearched").empty();
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> User Name : "+arrayofUser[x]['name']+"</span>";
                                                if(arrayofUser[x]['alreadyConvo'] == 0){
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser[x]['ID']+"\" class='userButton' data-dismiss=\"modal\">Message</button><br>";
                                                }else{
                                                    userHtmlBox += "<br>"
                                                }
                                                userHtmlBox += "</div>"
                                                
                            $("#UserSearched").append(userHtmlBox);
                        }
                    }
                    function createConvoBox(arrayofUser){
                        $("#actualConvo").empty();
                        var convoHtml ="";
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            if(arrayofUser[x]['mine'] == 1){
                                convoHtml+= "<h3 style=\"float:right\">"+arrayofUser[x]['message']+"</h3><br><br>";
                            }else{
                                convoHtml+= "<h3 style=\"float:left\">"+arrayofUser[x]['message']+"</h3><br><br>";
                            }
                                                
                            
                        }$("#actualConvo").append(convoHtml);
                    }

                    
                    function createAllConvoBox(arrayofUser){
                        $("#allConvo").empty();
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            var userHtmlBox = "<div class = 'userGroupAllConvo userGroup2'> "+
                                                "<button id=userConvo"+arrayofUser[x]['ID']+"> "+arrayofUser[x]['name']+"</button>";
                                                userHtmlBox+="</div>";
                                                
                            $("#allConvo").append(userHtmlBox);
                        }
                    }


                    $("#searchUserToInviteButton").click(function(){
                        if($("#searchUserToInvite").val() != ""){
                            $.post('../../Controller/EventController/searchUserToMessage.php',{name:$("#searchUserToInvite").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createMessageBox(info[1]);
                                }else{
                                }
                            });
                        }else{
                            alert("You need to enter a user name to search for!");
                        }
                    });
                    $("#sendmMessageButton").click(function(){
                        if($("#inputMessage").val() != ""){
                            $.post('../../Controller/EventController/saveMessage.php',{message:$("#inputMessage").val(),id: $("#storeConvoID").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createConvoBox(info[1]);
                                    resetInput();
                                }else{
                                    alert("Sorry, message failed to send.");
                                }
                            });
                        }else{
                        }
                    });
                });
            </script>
        </body>
    </html>