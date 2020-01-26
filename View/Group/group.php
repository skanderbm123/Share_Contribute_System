<!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <title>Soul Society</title>
            <style>
            body {
                overflow-x: hidden; 
            }

            #searchGroupInput {
                width: 50%;
                padding: 12px 20px;
                margin: 2% 0;
                margin-left:15%;
                margin-top:2%;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 12px;
                box-sizing: border-box;
            }
            
            #searchGroupButton {
                background-color: #1F11F7;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                margin-left:1%;
                }

            #searchGroupButton:hover {
                background-color: #1006A6;
            }
            
            #clearButton {
                width: 5%;
                background-color: #FF5252;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                margin-left:1%;
            }

            #clearButton:hover {
                background-color:  #FF2929;
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

            .listOfGroups {
                margin-top :2%;
                margin-left : 35%;
                margin-bottom : 4%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 60%;
                box-shadow: 5px 10px #888888;
            }

            .row2 {
                display: flex;
                flex-direction: row;
                justify-content: center;
            }

            .groupButton{
                float:right;
            }
               
            .groupBody {
                margin-top :2%;
                margin-left : 3%;
                margin-bottom:2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 35%;
                float:left;
            }
            
            .groupRightSideInfo {
                margin-top :5%;
                margin-left : 3%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 40%;
                float:left; 
                justify-content : flex-start;      
            }
            
            .myGroupClass {
                margin-top :5%;
                margin-left : 3%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 10px;
                width: 100%;
                float:left; 
                justify-content : flex-start;      
            }
            
            .groupHeader {
                margin-top :2%;
                margin-left : 1%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 20%;
                height:50%;
                float:left;
            }
            
            .groupBoxPost {
                margin-top :2%;
                margin-left : 3%;
                border-radius: 5px;
                width: 40%;
                float:left;
                padding-bottom : 10px;  
            }
            
            .flexBox {
                display : flex;
                flex-direction : column;
            }
            
            .column {
                float: left;
                width: 50%;
            }

            .userGroupPost {
                margin-top :2%;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                width: 88%;
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
            <div id="mainGenericGroup">
            <span style="font-size:30px;cursor:pointer" id="openNav">&#9776; Menu</span><br>
            <div class="row2">
                <div id="group2"></div>
            </div>
            <input type="text" id="searchGroupInput" placeholder="Search Group...">
            <button id="searchGroupButton">Search</button>
            <button id="clearButton">Clear</button>
            <div class="row">
                <div class="column" id="group" ></div>
                <div>
                    <div class="myGroupClass">
                        <h3>Groups I am in</h3>
                        <div id="groupsParticipating"></div>
                        <br>
                    </div><br>
                    <div class="myGroupClass">
                        <h3>My groups (as manager)</h3>
                        <div id="myGroups"></div>
                        <br>
                    </div><br>
                </div><br><br>
            </div> 
        </div>

         <div id="mainSpecificGroup" >
            <button id="backToSearchGroup" style="margin-left:40%">Back</button><br>
                <div class ="groupHeader">
                    <h3><span id="groupName"></span></h3>
                    <input id="storeGroupId" hidden />
                    <input id="storeEventId" hidden />
                    <button id="inviteUsersToGroup" data-toggle="modal" data-target="#inviteUserModal">Invite</button>
                    <button id="deleteGroupButton">Delete</button>
                    <button id="archiveGroupButton">Archive</button>    
                    <br>
                    <span>Nb of participants : </span><span id="nbParticipantGroup"></span><br>
                    <span>Number of post : </span><span id="nbPostGroup"></span><br>
                    <span>Number of Image : </span><span id="nbImageGroup"></span><br>
                    <span>Number of Video : </span><span id="nbVideoGroup"></span><br>
                </div>

            <div class="modal fade" id="inviteUserModal">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Invite event participants to group</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                            <div id="userGroupList"></div>
                    </div>
                </div>    
                </div>
            </div>
                <div id="postForUser" class="groupBody">
                    <input type="text" id="postText" placeholder="Write Post..." />
                    <button id="groupPostText" >Post</button><button >Image</button><button >Video</button>
                    
                    
                </div>

             <div class="modal fade" id="accessControlModal">
                 <div class="modal-dialog">

                     <!-- Modal content-->
                     <div class="modal-content">
                         <div class="modal-header">

                             <h4 class="modal-title">Access Player</h4>
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
                             <span> Name :</span><br> <input type="text" id="nameParticipantRemove" disabled ><br>
                             <input id="storeUserID" hidden></input>
                         </div>

                         <div class="modal-footer">
                             <button type="button" id="removeUser" class="btn btn-default" data-dismiss="modal" style="background-color: red; border : 1px solid black">YES</button>
                             <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                         </div>
                     </div>

                 </div>
             </div>

                <div id="postContentDiv" class="groupBoxPost">

                    </div>
                <div class="flexBox">
                <div class="groupRightSideInfo">
                    <h3>All Participants</h3>
                    <div id="groupAllParticipants"></div>
                    <br>
                </div><br>
                </div><br><br>
            </div>
   

            <script>
                $(document).ready(function() {
                    $("#mainSpecificGroup").hide();
                    $('#searchGroupInput').val('');
                    $("#deleteGroupButton").hide();
                    $("#archiveGroupButton").hide();

                    $(document).on("click","button",function(){
                        if(this.id.includes("groupOpen")){
                            var idOfButtonClicked = ($(this).attr('value'));
                            $.post('../../Controller/GroupController/getGroupInfoById.php',{id:idOfButtonClicked},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    $("#mainSpecificGroup").show();
                                    $("#mainGenericGroup").hide();
                                    if(!((info[1]['access'] === undefined || info[1]['access'].length == 0))){ 
                                    if(info[1]['access'][0]['access'] == "All" || info[1]['access'][0]['access'] == "View_and_Post"  ){
                                        $("#postForUser").show();
                                    }else{
                                        $("#postForUser").hide();
                                    }}
                                    $("#groupName").text(info[1]['groupheader'][0]['name']);
                                    $("#storeGroupId").val(idOfButtonClicked);
                                    createRightAllParticipantsBox(info[1]['groupParticipant'],info[1]['canEdit'][0]['canEdit']);
                                    createPostBox(info[1]['groupPostContent'],info[1]['access']);
                                    //this is for now only, Emile when you add access to groups delete following lines...
                                     if(info[1]['canEdit'][0]['canEdit'] == 1) {
                                         $("#deleteGroupButton").show();
                                         $("#archiveGroupButton").show();
                                     }
                                }
                            });
                        }else if(this.id.includes("commentPostIdButton")){
                            var idOfButtonClicked = this.id.substring(19);
                            if($("commentPostId"+idOfButtonClicked).val() != ""){
                                var saliha ="#commentPostId"+idOfButtonClicked;
                                var yanis = $("#commentPostId"+idOfButtonClicked).val();

                                $.post('../../Controller/GroupController/saveComment.php',{id:idOfButtonClicked,comment:$("#commentPostId"+idOfButtonClicked).val(),groupId:$("#storeGroupId").val()},function(data){
                                    var info = JSON.parse(data);
                                    if(info[0]){
                                        createPostBox(info[1]['groupPostContent'],info[1]['access']);
                                    }else{
                                    }
                                });
                            }
                        }else if(this.id.includes("addUserId")){
                            var idOfButtonClicked = this.id.substring(9);
                            $.post('../../Controller/GroupController/addUserToGroup.php',{id:idOfButtonClicked,groupId:$("#storeGroupId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createUserBox(info[1]);
                                    createRightAllParticipantsBox(info[2],info[3]['canEdit'][0]['canEdit']);
                                }else{
                                }
                            });
                        }else if(this.id.includes("groupRegister")){
                            var idOfButtonClicked = this.id.substring(13);
                            $.post('../../Controller/GroupController/requestToGroup.php',{groupId:idOfButtonClicked,name:$("#searchGroupInput").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createGroupBox("All Groups you searched for!",info[1]);
                           
                                }else{
                                }
                            });
                        }else if(this.id.includes("participantsAccess")){
                            var idOfButtonClicked = this.id.substring(18);

                            $.post('../../Controller/GroupController/getAccessUser.php',{groupId:$("#storeGroupId").val(),userId:idOfButtonClicked},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    $("#nameParticipantAccess").val(info[1][0]['name']);
                                    $("#storeUserID").val(info[1][0]['userID']);
                                    $("#currentAccessParticipants").val(info[1][0]['Type']);
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


                    function createGroupBox(triggerAction,arrayofEvent){
                        $("#group").empty();
                        $("#group2").empty();
                        if(triggerAction === "") {
                        }
                        else {
                            $("#group2").append("<h3 style='text-align:center'> "+triggerAction+" </h3>");
                        }
                        
                        for(var x = 0; x<arrayofEvent.length;x++ ){
                            var eventHtmlBox = "<div class = 'listOfGroups' > "+
                                                "<span id= #manne> Group Name : "+arrayofEvent[x]['name']+"</span><br>"+
                                                "<span> Event Name : "+arrayofEvent[x]['eventName']+"</span>";
                                                if(arrayofEvent[x]['isRegistered'] == 0){
                                                    eventHtmlBox +=  "<button id= \"groupRegister"+arrayofEvent[x]['ID']+"\" class='groupButton' value='"+arrayofEvent[x]['ID']+"' >Request Access</button><br>";
                                                }else if(arrayofEvent[x]['isRegistered'] == 1){
                                                    eventHtmlBox +=  "<button id= 'groupOpen' class='groupButton' value='"+arrayofEvent[x]['ID']+"'>Open</button><br>";
                                                }else{
                                                    eventHtmlBox +=  "<button  class='groupButton' disabled>Pending request</button><br>";
                                                }
                                                
                                                eventHtmlBox +=  "</div>"
                                                
                            $("#group").append(eventHtmlBox);
                        }
                    }

                    function createRightAllParticipantsBox(arrayofAllParticipant,canEdit){
                        $("#groupAllParticipants").empty();

                        $("#nbParticipantGroup").text(arrayofAllParticipant.length);
                        for(var x = 0; x<arrayofAllParticipant.length;x++ ){
                            var participantHtmlBox = "<div class = 'allParticipantGroup' > "+
                                                "<span> "+(x+1)+") "+arrayofAllParticipant[x]['name']+"</span>";
                            if(canEdit == 1){
                                participantHtmlBox+= "<button id=\"removeParticipants"+arrayofAllParticipant[x]['userID']+"\" style=\"float:right; background-color: red\" data-toggle=\"modal\" data-target=\"#removeUserModal\" > - </button>";
                                participantHtmlBox+= "<button id=\"participantsAccess"+arrayofAllParticipant[x]['userID']+"\" style=\"float:right\" data-toggle=\"modal\" data-target=\"#accessControlModal\"> Edit </button>";
                                
                            }
                            participantHtmlBox +=  "</div>"
                            $("#groupAllParticipants").append(participantHtmlBox);
                        }
                    }

                    function MyGroupBox(arrayOfMyGroups){
                        $("#myGroups").empty();

                        for(var x = 0; x<arrayOfMyGroups.length;x++ ){
                            var groupHtmlBox = "<div class = 'allParticipantGroup' > "+
                                                "<span> "+(x+1)+") "+arrayOfMyGroups[x]['name']+"</span>";
                                                
                                                groupHtmlBox +=  "</div>"
                                                
                            $("#myGroups").append(groupHtmlBox);
                        }
                    }

                    function ParticipatingGroupBox(arrayOfMyGroups){
                        $("#groupsParticipating").empty();

                        for(var x = 0; x<arrayOfMyGroups.length;x++ ){
                            var groupHtmlBox = "<div class = 'allParticipantGroup' > "+
                                                "<span> "+(x+1)+") "+arrayOfMyGroups[x]['name']+"</span>";
                                                
                                                groupHtmlBox +=  "</div>"
                                                
                            $("#groupsParticipating").append(groupHtmlBox);
                        }
                    }

                    function createPostBox(arrayofPost, access){
                        $("#postContentDiv").empty();
                        $("#nbPostGroup").text(arrayofPost.length);
                        for(var x = 0; x<arrayofPost.length;x++ ){
                            var postHtmlBox = "<div class = 'userGroupPost'>" +
                                                "<h5>"+arrayofPost[x]['name']+"</h4> "+
                                                "<span> "+arrayofPost[x]['date']+"</span><br><br>"+
                                                "<h4>"+arrayofPost[x]['content']+"</h4><br>";
                                                if(access[0]['access'] == 'All' || access[0]['access'] == 'View_and_Comment'){
                                                    postHtmlBox+="<input id=\"commentPostId"+arrayofPost[x]['ID']+"\" type=text placeholder=\"Comment...\" />"+
                                                "<button id=\"commentPostIdButton"+arrayofPost[x]['ID']+"\">Comment</button>";
                            }
                            postHtmlBox+= createCommentBox(arrayofPost[x]['children'])+
                                "</div>"
                            $("#postContentDiv").append(postHtmlBox);
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

                    $("#searchGroupButton").click(function(){
                        if($("#searchGroupInput").val() != ""){
                            $.post('../../Controller/GroupController/searchGroup.php',{name:$("#searchGroupInput").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createGroupBox("All groups you searched for!",info[1]);
                                }else{
                                    createGroupBox("No group for this search !",[]);
                                }
                            });
                        }else{
                            alert("You need to search for a specific group");
                        }
                    });

                    $("#saveAccess").click(function(){
                        $.post('../../Controller/GroupController/updateParticipantAccess.php',{userID:$("#storeUserID").val(),groupId:$("#storeGroupId").val(),access:$("#accessSelected").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                alert("UPDATED SUCCESSFULLY")
                            }else{
                            }
                        });
                    });

                    $("#removeUser").click(function(){
                        console.log("user id is "+$("#storeGroupId").val());
                        $.post('../../Controller/GroupController/removeParticipant.php',{userID:$("#storeUserID").val(),groupId:$("#storeGroupId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                alert("REMOVED SUCCESSFULLY");
                                createRightAllParticipantsBox(info[2],info[3]['canEdit'][0]['canEdit']);
                            }else{
                            }
                        });
                    });

                    $("#backToSearchGroup").click(function(){
                        $("#mainSpecificGroup").hide();
                        $("#mainGenericGroup").show();

                    });

                    $("#clearButton").click(function(){
                        $.post('../../Controller/GroupController/searchUserGroup.php',{},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                createGroupBox("All groups you can join or are currently in !",info[1]);
                                $('#searchGroupInput').val('');
                            }else{
                                
                            }
                            });                   
                         });

                    $.post('../../Controller/GroupController/searchUserGroup.php',{},function(data){
                        var info = JSON.parse(data);
                            if(info[0]){
                                createGroupBox("All groups you can join or are currently in!",info[1]);
                            }else{
                            }
                    });

                    $.post('../../Controller/GroupController/getMyGroups.php',{},function(data){
                        var info = JSON.parse(data);
                            if(info[0]){
                                MyGroupBox(info[1]['myGroups']);
                                ParticipatingGroupBox(info[1]['groupsParticipating']);
                            }else{
                                alert("something wrong happened");
                            }
                    });

                    $("#groupPostText").click(function(){
                        if($("#postText").val() != ""){
                            $.post('../../Controller/GroupController/postContent.php',{content:$("#postText").val(),type:"Text",groupID:$("#storeGroupId").val()},function(data){
                                var info = JSON.parse(data);
                                if(info[0]){
                                    createPostBox(info[1],info[2]['access']);
                                }else{
                                }
                            });
                        }
                    });
                    
                    $("#inviteUsersToGroup").click(function(){
                       $.post('../../Controller/GroupController/getGroupInfoById.php',{id:$("#storeGroupId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                displayUserList(info[1]);
                            }else{
                                alert("something wrong happened");
                            }
                        });
                    });

                    function displayUserList(arrayofUser){
                        $("#userGroupList").empty();
                   
                        for(var x = 0; x<arrayofUser['groupparticipants'].length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> User Name : "+arrayofUser['groupparticipants'][x]['name']+"</span>";
                                                if(arrayofUser['groupparticipants'][x]['isRegistered'] == 1){
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser['groupparticipants'][x]['ID']+"\" class='userButton' style =\"background-color:green\" disabled>Registered</button><br>";
                                                }else{
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser['groupparticipants'][x]['ID']+"\" class='userButton'>Add</button><br>";
                                                }
                                                userHtmlBox += "</div>"

                            $("#userGroupList").append(userHtmlBox);
                        }
                   
                    }

                    function createUserBox(arrayofUser){
                        $("#userGroupList").empty();
                        for(var x = 0; x<arrayofUser.length;x++ ){
                            var userHtmlBox = "<div class = 'userGroup'> "+
                                                "<span> User Name : "+arrayofUser[x]['name']+"</span>";
                                                if(arrayofUser[x]['isRegistered'] == 0){
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser[x]['ID']+"\" class='userButton'>Add</button><br>";
                                                }else{
                                                    userHtmlBox +=  "<button id= \"addUserId"+arrayofUser[x]['ID']+"\" class='userButton' style =\"background-color:green\" disabled>Registered</button><br>";
                                                }
                                                userHtmlBox += "</div>"
                                                
                            $("#userGroupList").append(userHtmlBox);
                        }
                    }

                    $("#deleteGroupButton").click(function() {
                        $.post('../../Controller/GroupController/deleteGroup.php',{id:$("#storeGroupId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                $("#mainSpecificGroup").hide();
                                $("#mainGenericGroup").show();
                                $.post('../../Controller/GroupController/searchUserGroup.php',{},function(data){
                                        var info = JSON.parse(data);
                                        if(info[0]){
                                            createGroupBox("All groups you can join or are currently in !",info[1]);
                                            $('#searchGroupInput').val('');
                                            $.post('../../Controller/GroupController/getMyGroups.php',{},function(data){
                                                var info = JSON.parse(data);
                                                    if(info[0]){
                                                        MyGroupBox(info[1]['myGroups']);
                                                        ParticipatingGroupBox(info[1]['groupsParticipating']);
                                                    }else{
                                                        alert("something wrong happened");
                                                    }
                                            });
                                        }else{
                                            
                                        }
                                        }); 
                                alert('Group was successfully deleted');    
                            }else{
                                alert("something wrong happened");
                            }
                        });
                    });

                    $("#archiveGroupButton").click(function() {
                        $.post('../../Controller/GroupController/deleteGroup.php',{id:$("#storeGroupId").val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                displayUserList(info[1]);
                            }else{
                                alert("something wrong happened");
                            }
                        });
                    });
                });
            </script>
        </body>
    </html>