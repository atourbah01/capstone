<?php
session_start();
include("../../login-form-08/dbconf.php");

if( isset($_REQUEST['action']) ){


    switch( $_REQUEST['action'] ){



        case "SendMessage":


            $query = $pdo->prepare("INSERT INTO chat SET user=?, message=?,public_key=?");

            $query->execute([$_SESSION['ip']. ' : ' . $_SESSION['port'], $_REQUEST['message'], $_SESSION['public_key']]);

            echo 1;


            break;




        case "getChat":
            $query = $pdo->prepare("SELECT * from chat");
            $query->execute();

            $rs = $query->fetchAll(PDO::FETCH_OBJ);


            $chat = '';
            foreach( $rs as $r ){
                $publicKey = isset($r->public_key) ? $r->public_key : "N/A";
                // Remove line breaks and escape special characters
                $escapedPublicKey = str_replace(["\n", "\r", '\\', '"'], ['\\n', '\\r', '\\\\', '\\"'], $publicKey);
                $chat .=  '<div class="siglemessage"><strong>'.$r->user.' says:  </strong>'.$r->message.'<button class="details-btn" onclick="showDetails(\'' . $escapedPublicKey . '\')">Details</button></div>';

            }

            echo $chat;


            break;



    }


}


?>
