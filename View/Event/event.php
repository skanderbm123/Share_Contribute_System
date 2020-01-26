<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
                #searchEventInput {
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

                #searchEventButton {
                width: 5%;
                background-color: #1F11F7;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                margin-left:1%;
                }

                #searchEventButton:hover {
                background-color: #1006A6;
                }

                #createEventButton {
                width: 5%;
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                margin-left:1%;
                }

                #createEventButton:hover {
                background-color: #45a049;
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

                .eventGroup {
                margin-top :2%;
                margin-left : 25%;
                margin-bottom : 1%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 30%;
                box-shadow: 5px 10px #888888;
                }

                .userGroup {
                margin-top :2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 90%;
                }

                .allParticipantGroup {
                    margin-top :2%;
                    border-radius: 5px;
                    background-color: #f2f2f2;
                    width: 100%;
                }

                .eventButton, .userButton{
                    float:right;
                }

                .eventHeader {
                margin-top :2%;
                margin-left : 1%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 20%;
                height:50%;
                float:left;
                
                }
                .eventBody {
                margin-top :2%;
                margin-left : 3%;
                margin-bottom:2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 35%;
                float:left;
                
                }
                #eventPostBody {
                margin-top :5%;
                margin-left : 25%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 35%;
                }

                .flexBox {
                display : flex;
                flex-direction : column;
                }

                .eventRightSideInfo {
                margin-top :5%;
                margin-left : 3%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 40%;
                float:left; 
                justify-content : flex-start;               
                }

                .groupRightSideInfo {
                margin-top :2%;
                margin-left : 3%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 40%;
                float:left; 
                justify-content : flex-end;   
                }
                .eventBoxPost {
                margin-top :2%;
                margin-left : 3%;
                border-radius: 5px;
                padding: 10px;
                width: 40%;
                float:left;  
                }

                #mainSpecificEvent {
                    position:relative;
                    padding:0;
                    margin:0;
                    overflow-x:hidden;
                    overflow-y : hidden;
                    height:110%;
                    width :110%;
                    transition: background-color .5s;
                }

                #event {
                    overflow-y:auto;
                }
                
                #deleteEventButton {
                    background-color : red;
                    border-radius : 5px ;
                    border : 1px solid black;
                }


            </style>
        </head>
        <body style="overflow-x:hidden">
        <?php include("../Dashboard/navbar.php") ?>
        
        <div id="main" >
        <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span><br>
            <div id="mainGenericEvent">
                <input type="text" id="searchEventInput" placeholder="Search Event...">
                <button id="searchEventButton">Search</button>
                <button id="createEventButton" data-toggle="modal" data-target="#createEventModal">Create</button>
                <div id="event" ></div>
            </div>
            <div id="mainSpecificEvent" >
            <button id="backToSearchEvent" style="margin-left:40%">Back</button><br>
                <div class ="eventHeader">
                    <h3><span id="eventChoseName"></span></h3>
                    <input id="storeEventId" hidden />
                    <button id="inviteParticipantH" data-toggle="modal" data-target="#inviteUserModal">Invite</button>
                    <button id="editParticipantH" data-toggle="modal" data-target="#editParticipantM">Edit</button>
                    <button id="deleteEventButton">Delete</button>
                    <button id="archiveEventButton">Archive</button><br><br>
                    <button id="addNewGroupToEvent" data-toggle="modal" data-target="#addNewGroup">Invite</button>
                    <button id="leaveEventModals" data-toggle="modal" data-target="#leaveEventModal" style="background-color: red">Leave Event</button>
                    <br>
                    <span>Nb of participants : </span><span id="nbParticipantEvent"></span><br>
                    <span>Nb of groups : </span><span id="nbGroupEvent"></span><br>
                    <span>Number of post : </span><span id="nbPostEvent"></span><br>
                    <span>Number of Image : </span><span id="nbImageEvent"></span><br>
                    <span>Number of Video : </span><span id="nbVideoEvent"></span><br>
                </div>
                <div id="postForUser" class="eventBody">
                    <input type="text" id="postText" placeholder="Write Post..." />
                    <button id="eventPostText" >Post</button><button id="displayUploadFunctionalities" >Upload</button>
                    <div id="divUpload">
                        <br>
                        <input id="uploadFile" type="file"  name="uploadFile" />
                        <button id="upload">Upload</button>
                    </div>
                    
                    
                </div>
                <div id="postContentDiv" class="eventBoxPost">

                    </div>
                <div class="flexBox">
                <div class="eventRightSideInfo">
                    <h3>All Participants</h3>
                    <div id="eventAllParticipants"></div>
                    <br>
                </div><br>
                <div class="groupRightSideInfo" style="float:right">
                    <h3>All Groups</h3>
                    <div id="eventAllGroups"></div>
                    <br>
                </div>
                </div><br><br>
            </div>
            
        </div>

        <!--MODAL SECTION -->
        <div class="modal fade" id="inviteUserModal">
                <div class="modal-dialog">
                
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                   
                        <h4 class="modal-title">Invite User</h4>
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

        <div class="modal fade" id="editParticipantM">
                <div class="modal-dialog">
                
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                   
                        <h4 class="modal-title">Edit Event</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <span> Name :</span><br> <input type="text" id="editNameEvent" disabled ><br>
                    <span> Creation Date :</span><br> <input type="text" id="editDateEvent" disabled><br>
                    <span> Adress :</span><br> <input type="text" id="editAdresseEvent"><br>
                    <span> Phone Number :</span><br> <input type="text" id="editphoneNumberEvent" ><br>
                    <span> Type of organization :</span><br> <input type="text" id="editTypeOfOrgEvent" ><br>
                    </div>
                    <div class="modal-footer">
                    <button type="button" id="editSaveEvent" class="btn btn-default" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
                </div>
        </div>

        <div class="modal fade" id="addNewGroup">
            <div class="modal-dialog">
                
                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Name of the group</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                   
                        <span> Group Name :</span> <input type="text" id="groupName" placeholder="Name">
                            <div id="userEventList"> </div>
                            <br>
                            <button id="addGroupButton" data-dismiss="modal">Create Group</button>
                    </div>
                </div>    
           
            </div>
                
        </div>
        </div>
    
        <div class="modal fade" id="createEventModal">
                <div class="modal-dialog">
                
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                   
                    <h4 class="modal-title">Create Event</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <span> Name :</span><br> <input type="text" id="nameEvent" ><br>
                    <span> Address :</span><br> <input type="text" id="addressEvent" ><br>
                    <span> Phone Number :</span><br> <input type="text" id="phoneNumberEvent" ><br>
                    <span> Type of organization :</span><br> <input type="text" id="typeOfOrgEvent" ><br>
                    </div>
                    <div class="modal-footer">
                    <button type="button" id="saveEvent" class="btn btn-default" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
                </div>
        </div>

        <div class="modal fade" id="accessControlModal">
                <div class="modal-dialog">
                
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                   
                    <h4 class="modal-title">Access Participant</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <span> Name :</span><br> <input type="text" id="nameParticipantAccess" disabled ><br>
                    <input id="storeUserID" hidden></input>
                    <span> Current Access :</span><br> <input type="text" id="currentAccessParticipants" disabled><br>
                    <span> New Access :</span>
                    <div id="changeAccess"><!--All Access possible-->
                    <select id="accessSelected">
                    <option value="View_Only" value> View Only </option>
                    <option value="View_and_Post"> View and Post </option>
                    <option value="View_and_Comment"> View and Comment </option>
                    <option value="All"> All </option>
                    </select>
                    </div>

                    </div>
                    <div class="modal-footer">
                    <button type="button" id="saveAccess" class="btn btn-default" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
                </div>
        </div>

        <div class="modal fade" id="removeUserModal">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Are you sure you want to remove the following user from the group?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="nameParticipantRemove" disabled ><br>
                        <input id="storeUserID" hidden></input>
                        </div>

                    <div class="modal-footer">
                        <button type="button" id="removeUser" class="btn btn-default" data-dismiss="modal" style="background-color: red; border : 1px solid black">YES</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="leaveEventModal">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Are you sure you want to leave the event?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input id="storeUserID" hidden></input>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="leaveEvent" class="btn btn-default" data-dismiss="modal" style="background-color: red; border : 1px solid black">YES</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                    </div>
                </div>

            </div>
        </div>

            <script>
                $(document).ready(function() {
                    $("#mainSpecificEvent").hide();
                    $("#deleteEventButton").hide();
                    $("#archiveEventButton").hide();
                    $("#divUpload").hide();

                    $("#saveAccess").click(function(){
                        $.post('../../Controller/EventController/updateParticipantAccess.php',{userID:$("#storeUserID").val(),eventId:$("#storeEventId").val(),access:$("#accessSelected").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    alert("UPDATED SUCCESSFULLY")
                                }else{
                                }
                            });
                    });
                    $("#displayUploadFunctionalities").click(function(){
                        $("#divUpload").show();
                    });
                    $("#upload").on("click", function() {

                        var file_data = $("#uploadFile").prop("files")[0];   
                        var form_data = new FormData();
                        form_data.append("file", file_data);
                        form_data.append("eventId", $("#storeEventId").val());
                        $.ajax({
                            url: "<?php 
                                include_once('../../Utils/Utils.php');
                                echo Utils::getWebsiteAbsolute();
                                ?>Controller/EventController/uploadFile.php",
                            dataType: 'script',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,              
                            type: 'post',
                            success: function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createPostBox(info[1],info[2]); 
                                }
                            }
                        });
                    });

                    $("#removeUser").click(function(){
                        $.post('../../Controller/EventController/removeParticipant.php',{userID:$("#storeUserID").val(),eventId:$("#storeEventId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                alert("REMOVED SUCCESSFULLY");
                                createRightAllParticipantsBox(info[2],info[3]['canEdit'][0]['canEdit']);
                            }else{
                            }
                        });
                    });

                    $("#leaveEvent").click(function(){
                        $.post('../../Controller/EventController/leaveEvent.php',{eventId:$("#storeEventId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                alert("You SUCCESSFULLY left the event");
                                $("#mainSpecificEvent").hide();
                                $("#mainGenericEvent").show();
                                $.post('../../Controller/EventController/searchUserEvent.php',{},function(data){
                                    var info = JSON.parse(data);
                                    if(info[0]){
                                        createEventBox("All Events you are registered for!",info[1]);
                                    }else{

                                    }
                                });
                            }else{
                            }
                        });
                    });

                    $(document).on("click","button",function(){
                       if(this.id.includes("eventOpen")){
                           var idOfButtonClicked = this.id.substring(9);
                           $.post('../../Controller/EventController/getEventInfoById.php',{id:idOfButtonClicked},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){

                                    $("#mainSpecificEvent").show();
                                    $("#mainGenericEvent").hide();
                                    if(info[1]['access'][0]['access'] == "All" || info[1]['access'][0]['access'] == "View_and_Post" ){
                                        $("#postForUser").show();
                                    }else{
                                        $("#postForUser").hide();
                                    }
                                    $("#eventChoseName").text(info[1]['eventheader'][0]['name']);
                                    $("#storeEventId").val(idOfButtonClicked);

                                    if(info[1]['canEdit'][0]['canEdit'] == 1){
                                        $("#inviteParticipantH").show();
                                        $("#editParticipantH").show();
                                        $("#deleteEventButton").show();
                                        $("#archiveEventButton").show();
                                    }else{
                                        $("#inviteParticipantH").hide();
                                        $("#editParticipantH").hide();
                                        $("#deleteEventButton").hide();
                                        $("#archiveEventButton").hide();
                                    }

                                    createRightAllParticipantsBox(info[1]['eventParticipant'],info[1]['canEdit'][0]['canEdit']);
                                    createRightAllGroupsBox(info[1]['eventGroup']);
                                    createPostBox(info[1]['eventPostContent'],info[1]['access']);
                                }
                            });
                       }else if(this.id.includes("completePayment")){
                           var idOfButtonClicked = this.id.substring(15);
                            form_data.append("eventID", idOfButtonClicked);
                           $.ajax({
                                url: "<?php 
                                include_once('../../Utils/Utils.php');
                                echo Utils::getWebsiteAbsolute();
                                ?>Controller/PayPalController/request.php",
                                data: { eventID: idOfButtonClicked },              
                                method: 'post',
                                success: function(data){
                                    console.log(data);
                                }
                            });
                        //    ,function(data){
                        //         var info = JSON.parse(data);){
                       
                       }else if(this.id.includes("commentPostIdButton")){
                        var idOfButtonClicked = this.id.substring(19);
                        if($("commentPostId"+idOfButtonClicked).val() != ""){
                            var saliha ="#commentPostId"+idOfButtonClicked;
                            var yanis = $("#commentPostId"+idOfButtonClicked).val();

                            $.post('../../Controller/EventController/saveComment.php',{id:idOfButtonClicked,comment:$("#commentPostId"+idOfButtonClicked).val(),eventId:$("#storeEventId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createPostBox(info[1]['eventPostContent'],info[1]['access']);
                                }else{
                                }
                            });
                        }
                       }else if(this.id.includes("addUserId")){
                        var idOfButtonClicked = this.id.substring(9);
                            $.post('../../Controller/EventController/addUserToEvent.php',{id:idOfButtonClicked,eventId:$("#storeEventId").val(),name:$("#searchUserToInvite").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createUserBox(info[1]);
                                    createRightAllParticipantsBox(info[2],info[3]['canEdit'][0]['canEdit']);
                                }else{
                                }
                            });
                       }else if(this.id.includes("eventRegister")){
                        var idOfButtonClicked = this.id.substring(13);
                            $.post('../../Controller/EventController/RequestToEvent.php',{eventId:idOfButtonClicked,name:$("#searchEventInput").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createEventBox("All Events you searched for!",info[1]);
                                }else{
                                }
                            });
                       }else if(this.id.includes("participantsAccess")){
                        var idOfButtonClicked = this.id.substring(18);

                            $.post('../../Controller/EventController/getAccessUser.php',{eventId:$("#storeEventId").val(),userId:idOfButtonClicked},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    $("#nameParticipantAccess").val(info[1][0]['name']);
                                    $("#storeUserID").val(info[1][0]['userID']);
                                    $("#currentAccessParticipants").val(info[1][0]['Type']);
                                }else{
                                }
                            });
                       }else if(this.id.includes("removeParticipants")){
                           var idOfButtonClicked = this.id.substring(18);

                           $.post('../../Controller/EventController/getUserByID.php',{eventId:$("#storeEventId").val(),userId:idOfButtonClicked},function(data){
                               var info = JSON.parse(data);
                               if(info[0]){
                                   $("#nameParticipantRemove").val(info[1][0]['name']);
                                   $("#storeUserID").val(idOfButtonClicked);
                               }else{
                               }
                           });
                       }
                
                    });


                    function createEventBox(triggerAction,arrayofEvent){
                        $("#event").empty();
                        $("#event").append("<h3 style='margin-left:25%'> "+triggerAction+" </h3>");
                        for(var x = 0; x<arrayofEvent.length;x++ ){
                            var eventHtmlBox = "<div class = 'eventGroup' > "+
                                                "<span> Event Name : "+arrayofEvent[x]['name']+"</span>";
                                                if(arrayofEvent[x]['isRegistered'] == 0){
                                                    eventHtmlBox +=  "<button id= \"eventRegister"+arrayofEvent[x]['ID']+"\" class='eventButton'  >Request</button><br>";
                                                }else if(arrayofEvent[x]['isRegistered'] == 1 && arrayofEvent[x]['paid'] == 0){
                                                    // eventHtmlBox +=  "<button id= \"completePayment"+arrayofEvent[x]['ID']+"\" class='eventButton'>Complete payment</button><br>";
                                                    eventHtmlBox += "<form action='../../Controller/PayPalController/request.php' method='post' id='paypal_form'>" +
                                                    "<input type='hidden' name='eventID' value='" + arrayofEvent[x]['ID'] + "'/>" +
                                                    "<input class='eventButton' type='submit' name='submit' value='Complete Payment'/></form>";
                                                }else if(arrayofEvent[x]['isRegistered'] == 1 && arrayofEvent[x]['paid'] == 1){
                                                    eventHtmlBox +=  "<button id= \"eventOpen"+arrayofEvent[x]['ID']+"\" class='eventButton'>Open</button><br>";
                                                }else{
                                                    eventHtmlBox +=  "<button  class='eventButton' disabled>Pending request</button><br>";
                                                }
                                                
                                                eventHtmlBox +=  "</div>"
                                                
                            $("#event").append(eventHtmlBox);
                        }
                    }


                    $("#editParticipantH").click(function(){
                        $.post('../../Controller/EventController/getEventInfoForEdit.php',{eventID:$("#storeEventId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    $("#editNameEvent").val(info[1][0]['name']);
                                    $("#editDateEvent").val(info[1][0]['creationDate']);
                                    $("#editAdresseEvent").val(info[1][0]['address']);
                                    $("#editphoneNumberEvent").val(info[1][0]['phoneNumber']);
                                    $("#editTypeOfOrgEvent").val(info[1][0]['typeOfOrg']);
                                }else{
                                }
                            });
                    });
                    $("#editSaveEvent").click(function(){
                        $.post('../../Controller/EventController/saveEditEvent.php',{
                                                                                eventID:$("#storeEventId").val(),
                                                                                eventAddress:$("#editAdresseEvent").val(),
                                                                                eventPhoneNumber:$("#editphoneNumberEvent").val(),
                                                                                eventOrg: $("#editTypeOfOrgEvent").val()
                                                                                },function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    alert("Edit Event Succesfully!");
                                }else{
                                }
                            });
                    });
                    function createRightAllParticipantsBox(arrayofAllParticipant,canEdit){
                        $("#eventAllParticipants").empty();

                        $("#nbParticipantEvent").text(arrayofAllParticipant.length);
                        for(var x = 0; x<arrayofAllParticipant.length;x++ ){
                            var participantHtmlBox = "<div class = 'allParticipantGroup' > "+
                                                "<span> "+(x+1)+") "+arrayofAllParticipant[x]['name']+"</span>";
                                                if(canEdit == 1){
                                                    participantHtmlBox+= "<button id=\"removeParticipants"+arrayofAllParticipant[x]['userID']+"\" style=\"float:right; background-color: red\" data-toggle=\"modal\" data-target=\"#removeUserModal\" > - </button>";
                                                    participantHtmlBox+= "<button id=\"participantsAccess"+arrayofAllParticipant[x]['userID']+"\" style=\"float:right\" data-toggle=\"modal\" data-target=\"#accessControlModal\"> Edit </button>";
                                                    
                                                }
                                                participantHtmlBox +=  "</div><br>"
                                                
                            $("#eventAllParticipants").append(participantHtmlBox);
                        }
                    }
                    function createRightAllGroupsBox(arrayofAllGroup){
                        $("#eventAllGroups").empty();

                        $("#nbGroupEvent").text(arrayofAllGroup.length);
                        for(var x = 0; x<arrayofAllGroup.length;x++ ){
                            var groupHtmlBox = "<div class = 'allGroup' > "+
                                                "<span> "+(x+1)+") "+arrayofAllGroup[x]['name']+"</span>";
                                                
                                                groupHtmlBox +=  "</div>"
                                                
                            $("#eventAllGroups").append(groupHtmlBox);
                        }
                    }
                    function createUserBox(arrayofUser){
                        $("#UserSearched").empty();
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> User Name : "+arrayofUser[x]['name']+"</span>";
                                                if(arrayofUser[x]['isRegistered'] == 0){
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser[x]['ID']+"\" class='userButton'>Add</button><br>";
                                                }else{
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser[x]['ID']+"\" class='userButton' style =\"background-color:green\" disabled>Registered</button><br>";
                                                }
                                                userHtmlBox += "</div>"
                                                
                            $("#UserSearched").append(userHtmlBox);
                        }
                    }
                    function createCommentBox(arrayofComment){
                        //$("#nbPostEvent").text(arrayofComment.length);
                        var commentHtmlBox = "<br><br>";
                        for(var x = 0; x<arrayofComment.length;x++ ){
                             commentHtmlBox += "<div style = 'border-top: 1px black solid;margin-left:2%'>" +
                                                "<span style=\"margin-right:5%\">"+arrayofComment[x]['name']+"</span> "+
                                                "<span> "+arrayofComment[x]['date']+"</span>"+
                                                "<h6>"+arrayofComment[x]['comment']+"</h6>"+
                                                "</div><br>"
                                                
                            
                        }
                        return commentHtmlBox;
                    }
                    function createPostBox(arrayofPost,access){
                        $("#postContentDiv").empty();
                        var images =0;
                        $("#nbPostEvent").text(arrayofPost.length);
                        for(var x = 0; x<arrayofPost.length;x++ ){
                            var postHtmlBox = "<div class = 'userGroup'>" +
                                                "<h5>"+arrayofPost[x]['name']+"</h4> "+
                                                "<span> "+arrayofPost[x]['date']+"</span><br><br>";
                                                if(arrayofPost[x]['type'] == 'Text'){
                                                    postHtmlBox+="<h4>"+arrayofPost[x]['content']+"</h4><br>";
                                                }
                                                if(arrayofPost[x]['type'] == 'Image'){
                                                    images++;
                                                    postHtmlBox+="<img src=\""+arrayofPost[x]['pathOfFile']+"\" alt=\"Image\" width=\"100%\" height=\"500\"><br>";
                                                }
                                                if(access[0]['access'] == 'All' || access[0]['access'] == 'View_and_Comment'){
                                                    postHtmlBox+="<input id=\"commentPostId"+arrayofPost[x]['ID']+"\" type=text placeholder=\"Comment...\" />"+
                                                "<button id=\"commentPostIdButton"+arrayofPost[x]['ID']+"\">Comment</button>";
                                                }
                                                postHtmlBox+= createCommentBox(arrayofPost[x]['children'])+
                                                "</div>"
                                                
                            $("#postContentDiv").append(postHtmlBox);
                        }
                        $("#nbImageEvent").text(images);
                    }
                    function displayUserList(arrayofUser){
                        $("#userEventList").empty();
                   
                        for(var x = 0; x<arrayofUser['allUsersOfEvent'].length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> "+arrayofUser['allUsersOfEvent'][x]['name']+"</span>";
                                                
                                                    userHtmlBox +=  "<input type='checkbox' name='addUserIdToGroup' id= \"addUserIdToGroup "+arrayofUser['allUsersOfEvent'][x]['id']+"\"class='userButton' value="+arrayofUser['allUsersOfEvent'][x]['id']+" ?> </input><br>";
                                                
                                                userHtmlBox += "</div>"
                                                
                            $("#userEventList").append(userHtmlBox);
                        }
                   
                    }

                    $("#eventPostText").click(function(){
                        if($("#postText").val() != ""){
                            $.post('../../Controller/EventController/postContent.php',{content:$("#postText").val(),type:"Text",eventID:$("#storeEventId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createPostBox(info[1],info[2]['access']);
                                }else{
                                }
                            });
                        }
                    });

                    $("#addNewGroupToEvent").click(function(){
                       $.post('../../Controller/EventController/getEventInfoById.php',{id:$("#storeEventId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    displayUserList(info[1]);
                                }else{
                                    alert("LOL");
                                }
                            });

                        
                    });

                    $("#backToSearchEvent").click(function(){
                        $("#mainSpecificEvent").hide();
                        $("#mainGenericEvent").show();
                    });

                    $("#searchUserToInviteButton").click(function(){
                        if($("#searchUserToInvite").val() != ""){
                            $.post('../../Controller/EventController/searchUserToEventId.php',{name:$("#searchUserToInvite").val(),id:$("#storeEventId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createUserBox(info[1]);
                                }else{
                                }
                            });
                        }else{
                            alert("You need to enter a user name to search for!");
                        }
                    });

                    $("#addGroupButton").click(function(){
                        var checked = []
                         $("input[name='addUserIdToGroup']:checked").each(function ()
                                    {checked.push(parseInt($(this).val())); });

                        if($("#groupName").val() != ""){
                            $.post('../../Controller/GroupController/addGroup.php',{name:$("#groupName").val(),id:$("#storeEventId").val(),userId:JSON.stringify(checked)},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                   alert("The group is created successfully !");
                                   $('#groupName').val('');
                                   createRightAllGroupsBox(info[2]);
                                }
                            });
                        }else{
                            alert("You need a name for the group!");
                        }


                    });

                    $("#searchEventButton").click(function(){
                        if($("#searchEventInput").val() != ""){
                            $.post('../../Controller/EventController/searchEvent.php',{name:$("#searchEventInput").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createEventBox("All Events you searched for!",info[1]);
                                }else{
                                    createEventBox("No Events for this search !",[]);
                                }
                            });
                        }else{
                            alert("You need to search for a specific event");
                        }
                    });

                    $.post('../../Controller/EventController/searchUserEvent.php',{},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                createEventBox("All Events you are registered for!",info[1]);
                            }else{
                                
                            }
                        });

                    $("#saveEvent").click(function(){
                        if($("#nameEvent").val() == ""||$("#addressEvent").val() == ""||$("#phoneNumberEvent").val() == ""||$("#typeOfOrgEvent").val() == ""){
                            alert("All fields must be field");
                        }else{
                            $.post('../../Controller/EventController/createEvent.php',{name:$("#nameEvent").val(),address:$("#addressEvent").val(),phone:$("#phoneNumberEvent").val(),type:$("#typeOfOrgEvent").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                createEventBox("All Events you are registered for!",info[1]);
                                alert("Event Created Successfully");
                            }else{
                                alert("You need to be an admin to create an event!");
                            }
                        });
                        }
                    });

                    $("#deleteEventButton").click(function(){
                        $.post('../../Controller/EventController/deleteEvent.php',{id:$("#storeEventId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                $("#mainSpecificEvent").hide();
                                $("#mainGenericEvent").show();
                                $.post('../../Controller/EventController/searchUserEvent.php',{},function(data){
                                    var info = JSON.parse(data);
                                    if(info[0]){
                                        createEventBox("All Events you are registered for!",info[1]);
                                    }else{
                                        
                                    }
                                });
                                alert("Event deleted Successfully");
                            }else{
                                alert("You need to be an admin to create an event!");
                            }
                        });
                    });

                });
            </script>
        </body>
    </html>