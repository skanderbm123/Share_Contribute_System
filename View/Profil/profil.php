<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_SESSION['usernameId'])){

    include '..\..\Controller\PayPalController\PayPal.php';

    $paypal = new PayPal();
    $paymentHistory = $paypal->getPaidEventHistory($_SESSION['usernameId']);

    $historyContent = "<div class='userProfilBox'>
        <h3>Transaction History</h3>
        <table>
            <tr>
                <th>Amount ($)</th>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Invoice ID</th>
                <th>Date</th>
            </tr>";
    $rowContent = "";
    if(isset($paymentHistory)){
        foreach($paymentHistory as $index){
            $amount = $index['amount'];
            $transID = $index['transactionID'];
            $status = $index['status'];
            $invoice = $index['invoiceID'];
            $date = $index['date'] . " UTC";
            $rowContent = $rowContent . "
            <tr>
                <td>${amount}</td>
                <td>${transID}</td>
                <td>${status}</td>
                <td>${invoice}</td>
                <td>${date}</td>
            </tr>";
        }
        $historyContent = $historyContent . $rowContent;
    }
    $historyContent = $historyContent . "</table></div>";

    echo "<!DOCTYPE html>
        <html>
            <head>
                <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
                <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
                <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
                <title>Soul Society</title>
                <style>
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                  }
                  
                  td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                  }
                  
                  tr:nth-child(even) {
                    background-color: #dddddd;
                  }

                .userProfilBox {
                    margin: auto;
                    margin-top : 5%;
                    margin-left: 25%;
                    border-radius: 5px;
                    background-color: #f2f2f2;
                    padding: 20px;
                    width: 40%;
                    
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
                </style>
            </head>
            <body>";
            include('../Dashboard/navbar.php');
            echo "
            <div id='main'>
            <span style='font-size:30px;cursor:pointer' id='openNav'>&#9776; Menu</span>
                <div class='userProfilBox' >
                <h3>Profile Information</h3>
                    <p> Name : <span id='userName'></span></p>
                    <p> Username  : <span id='userUsername'></span></p>
                    <p> Birthday  : <span id='userBirthday'></span></p>
                    <button id='editUser' data-toggle='modal' data-target='#myModal'>Edit</button>
                </div>";
                echo $historyContent;
                echo "
            </div>
            <div class='modal fade' id='myModal' role='dialog'>
                <div class='modal-dialog'>
                    <!-- Modal content-->
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h4 class='modal-title'>Edit Profil</h4>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        </div>
                        <div class='modal-body'>
                        <span> Name :</span> <input type='text' id='nameEdit' ><br>
                        <span> Username :</span> <span id='usernameEdit' ></span><br>
                        <span> Birthday :</span> <span  id='birthdayEdit' ></span><br>
                        </div>
                        <div class='modal-footer'>
                        <button type='button' id='saveUser' class='btn btn-default' data-dismiss='modal'>Save</button>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
                

            <script>
                $(document).ready(function() {
                
                    $.post('../../Controller/UserController/getCurrentUserInformation.php',{},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                $('#userName').text(info[1]['name']);
                                $('#userUsername').text(info[1]['username']);
                                $('#userBirthday').text(info[1]['BirthDate']);

                                //for modal
                                $('#nameEdit').val(info[1]['name']);
                                $('#usernameEdit').text(info[1]['username']);
                                $('#birthdayEdit').text(info[1]['BirthDate']);
                            }else{

                            }
                        });
                    
                    $('#saveUser').click(function(){
                        if($('#nameEdit').val() == ''){
                            alert('All fields must be field');
                        }else{
                            $.post('../../Controller/UserController/editInformation.php',{name:$('#nameEdit').val()},function(data){
                            var info = JSON.parse(data);
                            if(info[0]){
                                window.location.href='profil.php';
                            }else{

                            }
                        });
                        }
                    });

                });
            </script>
        </body>
    </html>";
} else if($_SERVER["REQUEST_METHOD"] === "POST"){
    header("Location: ..\Dashboard\dashboard.php");
}