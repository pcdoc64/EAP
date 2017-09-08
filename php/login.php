
<div id="loginForm">

    <?php
    function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    if (!is_session_started()) {
    echo 'starting session';
        session_start();
        session_unset();
        session_destroy();
        $_SESSION = array();

    }

//    require 'PasswordHash.php';
    // form is submitted, check if access will be granted
    if($_POST){

        try{

            // open database connection - $con is for kidscloud, $conaap is for kscouts database
            $con=mysqli_connect(DB_HOST,DBC_USER,DBC_PASSWORD,DBC_NAME);
            $conaap=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
			         //check if mysql user exists from dbinclude.inc
           $caseno=mysqli_connect_errno($con);
           $caseno=mysqli_connect_errno($conaap);
            // prepare query
            $query = "select uid, password from oc_users where uid = ? limit 0,1";    // - from kidscloud db
            $querya="select gid from oc_group_user where uid=? and gid='EAP' limit 0,1";   // - from kidscloud db
            $queryu = "select email1 from oc_users where uid = ? limit 0,1";   // - from kscouts db
            $stmt = $con->prepare( $query );
            $stmta = $con->prepare( $querya );
            $stmtu = $conaap->prepare( $queryu );
            // $named is subbed into $query string for uid
            $stmt->bind_param('s', $named);
            // $named is subbed into $query string for uid
            $stmta->bind_param('s', $named);
            $stmtu->bind_param('s', $named);
            $named=$_POST['user'];
//echo 'posting user '.$stmt.'';
            // execute our query
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userd,$password);
            $stmt->fetch();
            $stmta->execute();
            $stmta->store_result();
            $stmta->bind_result($gid);
            $stmta->fetch();
            $stmtu->execute();
            $stmtu->store_result();
            $stmtu->bind_result($email1);
            $stmtu->fetch();

            // count the rows returned
            $num = $stmt->num_rows;
            $_SESSION['uid']=$named;
            $_SESSION['user']=$userd;
            $_SESSION['pword']=$password;
            $_SESSION["email1"]=$email1;
            if ($gid=='EAP') {$_SESSION['admin']='TRUE';} else {$_SESSION['admin']='FALSE';}
// echo 'got back '.$num.' rows<br>';
// echo 'password is '.$_SESSION['pword'].' for user '.$_SESSION['user'].'';
            if($num==1){

                //store retrieved row to a 'row' variable


                // hashed password saved in the database
                $storedPassword = $password;

                // salt and entered password by the user
                $salt = "c2f66f4e56eaba1fa165fa185adbe1";
                $postedPassword = $_POST['password'];
                $saltedPostedPassword = $salt . $postedPassword;

                // initiate PasswordHash to check if it is a valid password
//                $hasher = new PasswordHash(8,false);
//                $check = $hasher->CheckPassword($saltedPostedPassword, $storedPassword);


                 $check=TRUE;
//                 echo $userd." - ".$password;
                if($check){
                    $conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
                    $query="SELECT uid, displayname, position, groupname, region, branch, phone1, report_to FROM oc_users WHERE uid='".$_SESSION['user']."'";
                    $result=mysqli_query($conaap,$query);
                    $row= mysqli_fetch_array($result,MYSQLI_ASSOC);
//                    echo var_dump($row);
                    $_SESSION['realname']=$row['displayname'];
                    $_SESSION['group']=$row['groupname'];
                    $_SESSION['phone1']=$row['phone1'];
                    $_SESSION['role']=$row['position'];

// add user login to logged table
                    
                    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
                    ('login', 'Successful', 'none', 'none', 'none', 'none', '".$_SESSION['realname']."')";
                    $query=mysqli_query($conaap, $sql);

                    if ($row['groupname']>"") {
                      echo '<script type="text/javascript"> window.location = "index.php?pg=welc";</script>';
                    } else {
                      echo '<script type="text/javascript"> window.location = "index.php?pg=profile";</script>';
                } }

                // $check variable is false, access denied.
                else{
                    echo "<div>Access denied. <a href='index.php'>Back.</a></div>";
                }

            }

            // no rows returned, access denied
            else{
                echo "<div>Access denied. <a href='index.php'>Back.</a></div>";
            }

        }
        //to handle error
        catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }


    }

    // show the registration form
    else{
    ?>

    <form action="index.php" method="post">
     <br><div id="loginbox">
        <h3><span style="color:black">Login with your </span><a href="https://kids.kennedyscouts.org.au"><span style="color:blue">KIDS</span></a><span style="color:black">cloud username and password<span></h3>
     </div>
        <div id="formBody">
            <div class="formField">
                <input type="text" class="logname" name="user" required autofocus autocomplete placeholder="User name" />
            </div>
            <div><br></div>
            <div class="formField">
                <input type="password" class="logpword"name="password" required placeholder="Password" />
            </div>

            <div>
                <input type="submit" value="Login" class="customButton" />
            </div>
        </div>
    </form>
    <?php
    }
    ?>

</div>
