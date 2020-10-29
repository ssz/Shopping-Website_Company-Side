<?php 
session_start();

//login.php
$username=$_POST['username'];
$password=$_POST['password'];
$errmsg="";
$_SESSION['loginsuccess'] = false;
$_SESSION['usertype'] = -1;

if(strlen($username)==0){
    $errmsg='Invalid Login';
}
if(strlen($password)==0){
    $errmsg='Invalid Login';
}
if(strlen($username)==0 && strlen($password)==0){
    $errmsg=''; 
}

//go to DB to validate when both exist.
if(strlen($username)>0 && strlen($password)>0){
    $sql="select usertype from users where username='$username' and password=password('$password');";
    $con=mysql_connect("cs-server.usc.edu:61618", "root", "dalin100");

    if(!$con){
    //DB connects request failed
    //die("Cannot connect to the database.");
        die('Could not connect to database'.mysql_error());
     }
    //select a database
    $db_con = mysql_select_db("sell", $con);
    if(!$db_con){
    //DB connects request failed
    //die("Cannot connect to the database.");
        die('Could not select DB'.mysql_error());
     }
    //Issuing SQL
    $res=mysql_query($sql);
    if(!($row=mysql_fetch_assoc($res))){
        $errmsg='Invalid Login';
    }
    if(strlen($errmsg)>0){
        require 'prelogin.html';
        echo "<p class='err'>$errmsg</p>";
        require 'postlogin.html';
    }elseif(!$res){
        require 'prelogin.html';
        require 'postlogin.html';
    }else{
    //valid username and password
    //Display appropriate page
        $_SESSION['username'] = $username;
        $_SESSION['usertype'] = $row['usertype'];  
        $_SESSION['loginsuccess'] = true;
        $_SESSION['start']=time();
        // Ending a session in 15 minutes from the starting time.
        $_SESSION['expire']=$_SESSION['start'] + (15 * 60); 

        if($_SESSION['usertype']==0){
        //0 represents admin
            header('Location:admin.php');
        }elseif($_SESSION['usertype']==1){
        //1 represents manager
        //require manager.php;
            header('Location:manager.php');
        }elseif($_SESSION['usertype']==2){
        //2 represents sales manager
        //require employee.php;
            header('Location:saler.php');
        }
      mysql_close($con);
    }
} else {
    require 'prelogin.html';
    ?>
    <p id = "errMsg" class="err">
    <?php
    echo $errmsg;
    ?>
    </p>
    <?php
    require 'postlogin.html';
}
?>