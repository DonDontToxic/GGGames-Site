<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Aws\Sns\SnsClient;

require 'vendor/autoload.php';

$key = 'AKIAIIASARHO54EMLTQQ';
$secret = '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';
$topic = 'arn:aws:sns:ap-southeast-1:147000850017:myGameTopic';
$protocol = 'email';
$bucket = 'myimages.bucket';
$version = 'latest';
$region = 'ap-southeast-1';
$sender = 'donnod837@gmail.com';
$senderName = 'GG-Games Site';
$recipient = 'quexx4@gmail.com';
$usernameSmtp = 'AKIASEOPO6ZQ2E6K6JNM';
$passwordSmtp = 'BKDKkjkACEURYgX9KziJycq+84ftXXQzVJccEFNtn/80';
$host = 'email-smtp.ap-south-1.amazonaws.com';
$port = 587;

$accountInfos = file_get_contents('https://b7izw92orh.execute-api.ap-southeast-1.amazonaws.com/default/myAccountFunction?id=0');
$accountInfos_json = json_decode($accountInfos, true);

$unameArr = array();
$passArr = array();
$mailArr = array();
$accountIDArr = array();

for ($i = 0; $i < sizeof($accountInfos_json); $i++) {
    array_push($accountIDArr, $accountInfos_json[$i]['ID']);
    array_push($unameArr, $accountInfos_json[$i]['Username']);
    array_push($passArr, $accountInfos_json[$i]['Password']);
    array_push($mailArr, $accountInfos_json[$i]['Mail']);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
    <title>GG-Game: Login</title>

    <style>
        hr.custom {
            border: 5px solid purple;
            width: 100%
        }

        hr.customRight {
            border: 5px solid green;
            width: 100%
        }
    </style>
    <link rel="stylesheet" href="styles.css">
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.672.0.min.js"></script>
    <script src="./src/index.js"></script>
    <script src="./src/bucket.js"></script>
    <script>setImageSites("favicon","favicon.ico");</script>
    <link id="favicon" rel="icon" href="" type="image/x-icon">
    <!-- <script type="module" src="./src/cognito.js"></script> -->

</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark navbar-fixed-top">
        <a class="navbar-brand" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/">
            <img id="navlogo" alt="Logo" width="200" height="200">
        </a>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <form class="nav-item">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 text-center">
                            <h2 style="margin-top: 15%; color: purple">One Of The Largest Download Game Website</h2>
                        </div>
                </form>
            </ul>
        </div>
    </nav>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="row" style="margin-top: 2%">
                    <div class="col-sm-1">
                        <hr class="custom">
                    </div>
                    <div class="col-sm-2">
                        <h2 class="hero" style="color:purple; font-size: 40px; font-weight: bold;">Login</h2>
                    </div>
                    <div class="col-sm-9">
                        <hr class="custom">
                    </div>
                </div>

                <div class="row" style="margin-top: 2%; margin-left:2%">
                    <div class="col-sm-10 text-center">
                        <form id="loginForm" action="index.php" method="post" style="margin-top:2%">
                            <div class="form-group">
                                <div class="row" style="margin-top:5%">
                                    <div class="col-sm-4">
                                        <label for="name" class="homeText" style="font-size: 20px">Username * :</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control homeText" id="uname" placeholder="Enter your username" name="uname" style="background-color: black; font-size: 20px" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row" style="margin-top:5%">
                                    <div class="col-sm-4">
                                        <label for="password" class="homeText" style="font-size: 20px">Password * :</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control homeText" id="password" placeholder="Enter your password" name="password" style="background-color: black; font-size: 20px" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row" style="margin-top:5%">
                                    <div class="col-sm-5">
                                        <a class="homeText" style="font-size: 20px" href="">Don't have an account yet ?</a>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="hidden" id="accountID" name="accountID" value="0" />
                                        <input type="hidden" id="login_submitted" name="login_submitted" value="1" />
                                        <input class="btn btn-lg" onclick="logClicked()" type="button" value="Login" style="background-color: palevioletred; float:right;width: 150px ">
                                        <input class="btn btn-lg" onclick="resetLogClicked()" type="button" value="Reset" style="background-color: gray; float:right; margin-right:1%; width: 100px">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2 text-center">
                    </div>
                </div>
            </div>

            <?php if (isset($_POST['sub_submitted'])) :

                $SnSclient = new SnsClient([
                    'region' => 'ap-southeast-1', //Change according to you
                    'version' => 'latest',
                    'credentials' => [
                        'key' => $key,
                        'secret' => $secret,
                    ]
                ]);

                $endpoint = $_POST['subMail'];
                try {
                    $result = $SnSclient->subscribe([
                        'Protocol' => $protocol,
                        'Endpoint' => $endpoint,
                        'ReturnSubscriptionArn' => true,
                        'TopicArn' => $topic,
                    ]);
                    // var_dump($result);
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            ?>
                <div class="col-sm-6">
                    <div class="row" style="margin-top: 2%">
                        <div class="col-sm-7">
                            <hr class="custom">
                        </div>
                        <div class="col-sm-4">
                            <h2 class="hero" style="color:purple; font-size: 40px; font-weight: bold;">Subscribed ✓</h2>
                        </div>
                        <div class="col-sm-1">
                            <hr class="custom">
                        </div>
                    </div>
                    <p style="float: right;margin-top: 6%; font-size: 30px" class="homeText">Thank you for joining our community.</p>
                    <p style="float: right;margin-top: 4%; font-size: 20px" class="homeText">From now, you can gain several emails from us in different cases such as our give away gift,
                        discount codes to buy game from our sponsors. Therefore, just be patient and check your mail frequently to be surprise by us !!!</p>
                    <p style="float: right;margin-top: 4%; font-size: 20px" class="homeText"> Now,
                        <span><a href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/account.php">Reload</a></span> OR </span><a href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/">Forward</a></span></p>
                </div>
            <?php else : ?>
                <div class="col-sm-6">
                    <div class="row" style="margin-top: 2%">
                        <div class="col-sm-8">
                            <hr class="custom">
                        </div>
                        <div class="col-sm-3">
                            <h2 class="hero" style="color:purple; font-size: 40px; font-weight: bold;">Subscribe</h2>
                        </div>
                        <div class="col-sm-1">
                            <hr class="custom">
                        </div>
                    </div>
                    <p style="float: right;margin-top: 6%; font-size: 20px" class="homeText">Be a subscriber to the site for recieving the lastest news such as recently requested games or cracked games</p>
                    <form id="subForm" action="account.php" method="post" style="margin-top:15%;">
                        <div class="form-group">
                            <div class="row" style="margin-top:5%">
                                <div class="col-sm-8">
                                    <input type="email" class="form-control homeText" id="subMail" placeholder="Enter your mail" name="subMail" style="margin-left:15%; background-color: black; font-size: 20px" required>
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" id="sub_submitted" name="sub_submitted" value="1">
                                    <input id="subBtn" name="subBtn" class="btn btn-lg" type="submit" value="Subscribe" style="float:right; width:200px; background-color:palevioletred">
                                </div>
                            </div>
                        </div>
                    </form>
                    <p id="subMess" name="subMess" style="float: right;margin-top: 2%; font-size: 20px" class="homeText"></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="row" style="margin-top: 5%">
            <div class="col-sm-5">
                <hr class="custom">
            </div>
            <div class="col-sm-2">
                <h2 class="hero" style="color:purple; font-size: 40px; font-weight: bold;">Sign Up</h2>
            </div>
            <div class="col-sm-5">
                <hr class="custom">
            </div>
        </div>

        <?php if (isset($_POST['signup_submitted'])) :

            // If file upload form is submitted 
            $statusMsg = '';
            if (!empty($_FILES["ava"]["name"])) {
                // Get file info 
                $fileType = pathinfo(basename($_FILES["ava"]["name"]), PATHINFO_EXTENSION);
                // Allow certain file formats 
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {

                    $temp_file_location = $_FILES['ava']['tmp_name'];
                    $s3 = new Aws\S3\S3Client([
                        'region'  => $region,
                        'version' => $version,
                        'credentials' => [
                            'key'    => $key,
                            'secret' => $secret
                        ]
                    ]);

                    $key = "avatars/" . $_POST['unames'] . ".png";

                    $result = $s3->putObject([
                        'Bucket' => $bucket,
                        'Key'    => $key,
                        'SourceFile' => $temp_file_location,
                        'ACL'    => 'public-read'
                    ]);
                    $statusMsg = 'Your account has been registered sucessfully. Please check your mail to claim our welcome gift !!!';
                } else {
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                }
            } else {
                $statusMsg = "Your account has been registered sucessfully with default avatar. Please check your mail to claim our welcome gift !!!";
            }

            $url = 'https://c5hqxml0p9.execute-api.ap-southeast-1.amazonaws.com/test/postaccount';
            $data = array('Username' => $_POST['unames'], 'Password' =>  $_POST['passwords'], 'Mail' => $_POST['email']);
            $data = json_encode($data);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)
                )
            );
            //  Get the response
            $result = curl_exec($ch);

                $subject = 'A Welcome Gift From Us';
                $bodyText =  "Email Test\r\nThis email was sent through the Amazon SES SMTP interface using the PHPMailer class.";

                // The HTML-formatted body of the email
                $bodyHtml = '<!DOCTYPE html><html>
                    <head>
                        <style>
                            .content {
                                color: black;
                                font-size: 20px;
                                font-weight: bold;
                            }
                            .button {
                            background-color: palevioletred; /* Green */
                            border: none;
                            color: white;
                            padding: 16px 32px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            transition-duration: 0.4s;
                            cursor: pointer;
                            border-radius: 12px;
                            }
                            .button1:hover {
                            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
                            }
                        </style>
                    </head>
                    <body style="background-color: white;">
                        <div align="center" class="container text-center" style="margin-bottom: 2%; margin-top: 2%;">
                            <h3  style="color:palevioletred;font-size: 30px;"> WELCOME BROTHER !!!</h3> </br>
                            <p class="content"> We"re excited to have you joint our community. First, there is a gift from our site to welcome the new member. Click the link below to claim your rewards.</p></br>
                            <a href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/" class="button button1" style="color:white">Claim Your Rewards</a>
                            <p class="content"style="margin-top: 2%;">If that doesn"t work, copy and paste the following link in your browser:</p></br>
                            <p class="content"style="color:palevioletred;"> XXX.XXXXXXX.XXX / XXXXXXXXXXXXX</p></br>
                            <p class="content">If you have any questions, just reply to this email—we"re always happy to help out.</p></br>
                            <p class="content"style="color:palevioletred;">Cheers, The GG-Games Community</p></br>
                        </div>
                    </body></html>';

                $mail = new PHPMailer(true);
                try {
                    // Specify the SMTP settings.
                    $mail->isSMTP();
                    $mail->setFrom($sender, $senderName);
                    $mail->Username   = $usernameSmtp;
                    $mail->Password   = $passwordSmtp;
                    $mail->Host       = $host;
                    $mail->Port       = $port;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = 'tls';

                    $mail->addAddress($_POST['email']);

                    // Specify the content of the message.
                    $mail->isHTML(true);
                    $mail->Subject    = $subject;
                    $mail->Body       = $bodyHtml;
                    $mail->AltBody    = $bodyText;
                    $mail->Send();
                }
                catch (Exception $e) {
                    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
                } 
        ?>
            <div class="container" style="text-align: center;">
                <table class="table table-dark table-striped table-bordered table-hover" style="margin-top: 2%">
                    <thead class="table-danger" style="background-color: palevioletred">
                        <tr>
                            <th>Annoucement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background-color: black">
                            <td class="" style="color: white; font-style:bold; font-weight:20px"><?php echo $statusMsg; ?></td>
                        </tr>
                        <thead class="table-danger" style="background-color: palevioletred">
                            <tr>
                                <th>Please reload page to sign up again OR Be a subcriber to recive additional information such as new requested game
                                </th>
                            </tr>
                        </thead>
                        <tr style="background-color: black">
                            <td>
                                <form class="text-center" id="reloadForm" action="account.php" method="post" style="padding-top: 1%">
                                    <input type="hidden" id="" name="" value="">
                                    <input class="btn" type="submit" value="Reload" style="float:center; width:200px; background-color:gray">
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        <?php else : ?>
            <div class="row" style="margin-top: 2%; margin-left:2%">
                <div class="col-sm-4">
                    <div class="row" style="margin-top:5%">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            <img class="avatar" id="avaImage" name="avaImage"  alt="Avata should be here">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-6 text-center">
                    <form id="signForm" action="account.php" method="post" enctype="multipart/form-data" style="margin-top:2%">
                        <div class="form-group">
                            <div class="row" style="margin-top:5%">
                                <div class="col-sm-4">
                                    <label for="email" class="homeText" style="font-size: 20px">Mail * :</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control homeText" id="email" placeholder="Enter your email" name="email" style="background-color: black; font-size: 20px" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="margin-top:5%">
                                <div class="col-sm-4">
                                    <label for="uname" class="homeText" style="font-size: 20px">Username * :</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control homeText" id="unames" placeholder="Enter your username" name="unames" style="background-color: black; font-size: 20px" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="margin-top:5%">
                                <div class="col-sm-4">
                                    <label for="password" class="homeText" style="font-size: 20px">Password * :</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control homeText" id="passwords" placeholder="Enter your password" name="passwords" style="background-color: black; font-size: 20px" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="margin-top:5%">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-8">
                                    <label for="ava" class="homeText" style="font-size: 20px">Select Avatar Image:</label>
                                    <input type="file" class="form-control homeText" id="ava" name="ava" style="background-color: black" onchange="previewAva()" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="margin-top:5%">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <input type="hidden" id="signup_submitted" name="signup_submitted" value="1" />
                                    <input class="btn btn-lg" type="button" onclick="signClicked()" value="Sign Up" style="background-color: palevioletred; float:right;width: 150px ">
                                    <input class="btn btn-lg" type="button" onclick="resetSignClicked()" value="Reset" style="background-color: gray; float:right; margin-right:1%; width: 100px"></input>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
                </div>

            </div>
    </div>
    <footer style="margin-top: 2%;background-color:#2c3539">
        <div class="row">
            <div class="col">
                <div style="margin-top:5%; margin-left: 2%;">
                    <p class="homeText">Copyright © <?php echo date("Y"); ?> Dong Nguyen</p>
                    <p class="homeText">Contact information: <a href="mailto:quexx4@gmail.com">Gmail</a>-<a href="mailto:N.dong83@outlook.com">Outlook</a></p>
                    <p class="homeText">Phone Number: (+84) 0329455587</p>
                </div>
            </div>
            <div class="col">
                <div style="margin-top:5%;text-align: center">
                    <p class="homeText">About My Self</p>
                    <p class="homeText"><a href="https://www.rmit.edu.vn/programs/bachelor-engineering-software-engineering-honours">Banchelor
                            of Software Engineer</a></p>
                    <p class="homeText">My Current Work: Freelancer</p>
                </div>
            </div>
            <div class="col">
                <div style="margin-top:4%; margin-right: 2%; text-align: right">
                    <p class="homeText">Follow Me</p>
                    <p class="homeText">
                        <img id="fb_logo" width="30" height="30" alt="The facebook logo should be here">
                        <a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/profile.php?id=100004307940153">Facebook</a></p>
                    <p class="homeText">
                        <img id="fl_logo" class="imageFree" width="150" height="30" alt="The Freelancer logo should be here">
                        <a target="_blank" rel="noopener noreferrer" href="https://www.freelancer.com/">FreeLancer</a></p>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>


<script type="text/javascript">
    var accountIDArr = <?php echo json_encode($accountIDArr); ?>;
    var unameArr = <?php echo json_encode($unameArr); ?>;
    var passArr = <?php echo json_encode($passArr); ?>;
    var mailArr = <?php echo json_encode($mailArr); ?>;


    function previewAva() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("ava").files[0]);

        oFReader.onload = function(oFREvent) {
            document.getElementById("avaImage").src = oFREvent.target.result;
        };
    };

    function resetSignClicked() {
        document.getElementById("unames").value = "";
        document.getElementById("passwords").value = "";
        document.getElementById("ava").value = "";
        document.getElementById("email").value = "";
        document.getElementById("avaImage").src = "img/defaultava.png";
    }

    function resetLogClicked() {
        document.getElementById("uname").value = "";
        document.getElementById("password").value = "";
    }


    function logClicked() {
        var uname = document.getElementById("uname").value;
        var pass = document.getElementById("password").value;
        var isValid = false;

        if (uname == "" || pass == "") {
            alert("Both username and password have been filled !!!");
            return;
        }

        for (i = 0; i < unameArr.length; i++) {
            if (uname == unameArr[i] && pass == passArr[i]) {
                document.getElementById("accountID").value = accountIDArr[i];
                document.cookie = "name=" + uname;
                document.cookie = "id=" + accountIDArr[i];
                document.cookie = "mail=" + mailArr[i];
                document.cookie = "status=Logout";
                document.cookie = "genre=";
                isValid = true;
                break;
            }
        }

        if (isValid) {
            document.getElementById("loginForm").submit();
        } else {
            alert("Incorrect username or password");
        }
    }

    function signClicked() {
        var uname = document.getElementById("unames").value;
        var pass = document.getElementById("passwords").value;
        var mail = document.getElementById("email").value;
        var avatar = document.getElementById("ava").value;

        var isValid = false;

        if (uname == "" || pass == "" || mail == "") {
            alert("All fields have to be filled !!!");
            return;
        }

        if (uname.toLowerCase() == "guest") {
            alert("You cant use the default username");
            return;
        }

        if (avatar == "") {
            alert("If the avatar being left empty, the default image will be applied later on");
        }

        if (mailArr.includes(mail)) {
            alert("This mail is already registered. Please try again !!!");
            return;
        }
        if (unameArr.includes(uname)) {
            alert("This username has been taken. Please try again !!!");
            return;
        }
        document.getElementById("signForm").submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.cookie = "name=Guest";
        document.cookie = "id=" + 1;
        document.cookie = "status=Login";
        document.cookie = "genre=";

    }, false);
</script>
<script>setImageSites("navlogo","logo_trans.png");</script>
<script>setImageSites("avaImage","defaultava.png");</script>
<script>setImageSites("fb_logo","fb_logo.png");</script>
<script>setImageSites("fl_logo","fl_logo.png");</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</html>