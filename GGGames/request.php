<?php

require 'vendor/autoload.php';

use Aws\Sns\SnsClient;

$key = 'AKIAIIASARHO54EMLTQQ';
$secret = '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';
$topic = 'arn:aws:sns:ap-southeast-1:147000850017:myGameTopic';


if (!isset($_COOKIE["id"])) {
    setcookie("id", 1, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("name", "Guest", time() + (86400 * 30), "/");
    setcookie("status",  "Login", time() + (86400 * 30), "/");
    setcookie("search",  "", time() + (86400 * 30), "/");
}


?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web&display=swap' rel='stylesheet'>
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel='stylesheet' href='styles.css'>
    <title>GG-Game: Detail</title>

    <style>
        /* Thick border */
        hr.custom {
            border: 5px solid palevioletred;
            width: 100%
        }

        .vl {
            border-left: 2px solid gray;
            height: 150px;
        }

        .card:hover {
            -webkit-box-shadow: -1px 9px 40px -12px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: -1px 9px 40px -12px rgba(0, 0, 0, 0.75);
            box-shadow: -1px 9px 40px -12px rgba(0, 0, 0, 0.75);
            color: white;
            -ms-transform: scale(1.05);
            -webkit-transform: scale(1.05);
            transform: scale(1.05);
            cursor: context-menu;
        }
    </style>

    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.672.0.min.js"></script>
    <script src="./src/bucket.js"></script>
    <script src="./src/index.js"></script>
    <script>
        setAccountAvatar("avatars", "<?php echo $_COOKIE['name']; ?>.png");
    </script>
        <script>setImageSites("favicon","favicon.ico");</script>
    <link id="favicon" rel="icon" href="" type="image/x-icon">

</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark  navbar-fixed-top">
        <a class="navbar-brand" href="#">
            <img id="navlogo" alt="Logo" width="75" height="75">
        </a>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <!-- Links -->
                <li class="nav-item">
                    <a class="nav-link" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Games+</a>
                    <div class="dropdown-menu">
                        <a onclick="genreClicked('Action'); return false;" class="dropdown-item" href="">Action</a>
                        <a onclick="genreClicked('Shooter'); return false;" class="dropdown-item" href="">Shooter</a>
                        <a onclick="genreClicked('Hack and Slash'); return false;" class="dropdown-item" href="">Hack and Slash</a>
                        <a onclick="genreClicked('Indie'); return false;" class="dropdown-item" href="">Indie</a>
                        <a onclick="genreClicked('Sport'); return false;" class="dropdown-item" href="">Sport</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php">Request Game</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/donate.php">Donate ❤</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link homeText" href="" style="font-size: 20px; color:purple" onclick="searched(); return false;">Search 🔎</a>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav pull-sm-right">
            <li class="nav-item">
                <p class="nav-link homeText" style="font-size: 25px; color:purple" id="accountName"><?php echo $_COOKIE['name']; ?></p>
            </li>
            <li class="nav-item">
                <img class="avatarNav" src="" id="avaImg" name="avaImg" alt="Logo" width="20px" height="20px">
            </li>
            <li class="nav-item">
                <a class="nav-link homeText" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/account.php" style="font-size: 25px; color:purple" id="accountStatus"><?php echo $_COOKIE['status']; ?></a>
            </li>
        </ul>
    </nav>

    <div class='container-fluid' style='background-color:black'>

        <div class='container' style='background-color:indigo; padding-top: 2%; padding-bottom: 2%'>
            <div class='text-center'>
                <h1 class='hero'>** Request Games **</h1>
            </div>
            <nav style='margin-top: 2%; margin-left:2%; margin-right:2%'>
                <div class='nav nav-tabs' id='nav-tab' role='tablist' style='background-color: palevioletred'>
                    <a class='nav-item nav-link active tabText' id='nav-request-tab' data-toggle='tab' href='#nav-request' role='tab' aria-controls='nav-request aria-selected=' true>REQUESTS</a>
                    <a class='nav-item nav-link tabText' id='nav-rules-tab' data-toggle='tab' href='#nav-rules' role='tab' aria-controls='nav-rules' aria-selected='false'>PLEASE CLICK HERE TO READ THE RULES BEFORE REQUEST *</a>
                </div>
            </nav>

            <div class='tab-content' id='nav-tabContent' style='background-color: pink; margin-left:2%; margin-right:2%'>
                <div class='tab-pane fade show active' id='nav-request' role='tabpanel' aria-labelledby='nav-request-tab' style='padding-top: 2%;padding-left: 2%; padding-bottom:2%'>

                    <?php if (isset($_POST['request_submitted'])) :

                        date_default_timezone_set('Australia/Melbourne');
                        $dateTime = date('m/d/Y h:i:s a', time()) . " " . date('T');

                        $url = 'https://lqreg9yjmi.execute-api.ap-southeast-1.amazonaws.com/test/requestgid';
                        $data = array('GName' => $_POST['gname'], 'GVersion' =>  $_POST['version'], 'Infos' => $_POST['infos'], 'DateTime' =>  $dateTime, 'RequestedBy' => $_POST['requestedBy']);
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

                        // Publish message to other subscribers
                        $SnSclient = new SnsClient([
                            'region' => 'ap-southeast-1', 
                            'version' => 'latest',
                            'credentials' => [
                                'key' => $key,
                                'secret' => $secret,
                            ],

                        ]);
                        $subject = "A new game have been request in our sites";
                        $message = "We here just to inform you another game have been requested in our site. For detail:\n
                                    Game Name: " . $_POST['gname'] . "\n
                                    Game Version: " . $_POST['version'] . "\n
                                    Additional Information: " . $_POST['infos'] . "\n
                                    Requested By: " . $_POST['requestedBy'] . "\n
                                    We will try our best to upload this game .Therefore, if you interested in this one, please visit our sites ASAP.";


                        $payload = array(
                            'TopicArn' => $topic, 
                            'Subject' =>  $subject,
                            'Message' =>  $message, 
                            'MessageStructure' => 'string',
                        );
                        try {
                            $SnSclient->publish($payload);
                        } catch (Exception $e) {
                            echo "Failure!\n" . $e->getMessage();
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
                                        <td class="" style="color: white; font-style:bold; font-weight:20px">The request has been submitted sucessfully</td>
                                    </tr>
                                    <thead class="table-danger" style="background-color: palevioletred">
                                        <tr>
                                            <th>Please reload page to request another game
                                                <form class="text-center" id="commentForm" action="request.php" method="post" style="padding-top: 1%">
                                                    <input class="btn" type="submit" value="Reload" style="float:center; width:200px; background-color:black">
                                                </form>
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>

                        <h4 class='' style='color:palevioletred; font-weight:bold'>Request your game by filling below form:</h4>
                        <form id="requestForm" action="request.php" method="post" style="margin-top:2%">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control homeText" id="gname" placeholder="Enter game name" name="gname" style="background-color: black; font-size: 15px" required>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="gname" class="homeText">Game's Name (required)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control homeText" id="version" placeholder="Enter game version " name="version" style="background-color: black; font-size: 15px" required>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="text" class="homeText">Version (required)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="infos" name="infos" cols="50" rows="3" style="background-color: black; font-size: 15px" placeholder="E.g: cracked by whom, published date..."></textarea>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="content" class="homeText">Additional information (optional)</label></br>
                                        <input type="hidden" id="requestedBy" name="requestedBy" value="" />
                                        <input type="hidden" id="request_submitted" name="request_submitted" value="1" />
                                        <input class="btn" type="button" onclick="submitClicked()" value="Submit Request" style="background-color: palevioletred; float:left">
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>

                </div>
                <div class='tab-pane fade' id='nav-rules' role='tabpanel' aria-labelledby='nav-rules-tab' style='padding-top: 2%;padding-left: 2%; padding-bottom:2%'>
                    <h4 class='' style='color:palevioletred; font-weight:bold'>A few tips:</h4>
                    <p class='contentText'>1. Before requesting a game, go to the GAME LIST and press [Ctrl] + [F] and see if the game you’re requesting is there first or type it in the Search bar!</p>
                    <p class='contentText'>2. RESEARCH the game that you want to request BEFORE requesting it! Also, DON’T request the following::</p>
                    <p class='contentText' style="font-size: 15px">• Don’t request MMO (Massively Multiplayer Online) games!</p>
                    <p class='contentText' style="font-size: 15px">• Don’t request games that require you to be connected to the Internet!*</p>
                    <p class='contentText' style="font-size: 15px">• Don’t request games that require you to be connected to a game’s servers to play!**</p>
                    <p class='contentText' style="font-size: 15px">• • Don’t request games that aren’t for the PC!</p>
                    <p class='contentText' style="font-size: 15px">• • Don’t request games that are already free!</p>
                    <p class='contentText' style="font-size: 15px">• Don’t request software whatsoever!</p>
                    <p class='contentText' style="font-size: 12px">* This rule doesn’t apply to single-player games with always-online DRM, as DRM can be crack-able and, therefore, the said game can be played offline.</p>
                    <p class='contentText' style="font-size: 12px">** This includes games with cracked servers.</p>
                    <p class='contentText'>3. You are only allowed to request ONE game per day! (A request counts if it’s an upload, update, or re-upload).</p>
                    <p class='contentText'>4. Go to the Donation page to learn how to upload and share games! When you share a game, DON’T upload files with malware!</p>
                    <p class='contentText'>5. You ARE allowed to request games that haven’t been released yet IF the game’s release date and your request date are a week or less apart!</p>
                    <p class='contentText'>6. Read the featured comment when you get a chance! You never know what you might find there! Also, don’t spam or advertise other websites! You will get banned if a moderator finds out!</p>
                </div>
            </div>

            <div style="text-align:center;">
                <input class="form-control homeText" id="searchInput" type="text" placeholder="Search by name..." style="margin-top: 5%; width: 500px; text-align:center; display:inline-block; background-color:pink; color:white;font-size:18px">
            </div>
            <?php
            if (isset($_GET["page"])) {
                $pn  = $_GET["page"];
                $total_records = $_GET["total"];
            } else {
                $pn = 1;
                $requestInfos = file_get_contents('https://svettd8jr6.execute-api.ap-southeast-1.amazonaws.com/default/myRequestFunction?startFrom=0&limit=18446744073709551615');
                $requestInfos = json_decode($requestInfos, true);
                $total_records = sizeof($requestInfos);
            };

            $limit = 10;  // Number of entries to show in a page. 
            $start_from = ($pn - 1) * $limit;

            $requestInfos = file_get_contents('https://svettd8jr6.execute-api.ap-southeast-1.amazonaws.com/default/myRequestFunction?startFrom=' . $start_from . '&limit=' . $limit . "");
            $requestInfos = json_decode($requestInfos, true);
            $requeststr = " <table class='table table-bordered table-hover table-danger id='myTable'>
            <thead  class='thead-dark' style='color:white'>
            <tr>
                <th>Name</th>
                <th>Version</th>
                <th>Aditional Information</th>
                <th>Requested In</th>
                <th>Requested By</th>
            </tr>
            </thead>
            <tbody  id='requestTable'>";

            for ($i = 0; $i < sizeof($requestInfos); $i++) {
                $requeststr .= "<tr>
            <td>" . $requestInfos[$i]["GName"] . "</td>
            <td>" . $requestInfos[$i]["GVersion"] . "</td>
            <td>" . $requestInfos[$i]["Infos"] . "</td>
            <td>" . $requestInfos[$i]["DateTime"] . "</td>
            <td>" . $requestInfos[$i]["RequestedBy"] . "</td></tr>";
            }
            $requeststr .= "</tbody></table>";
            echo $requeststr;
            ?>
            <nav aria-label="Page Navgation">
                <ul class="pagination pagination justify-content-center" style="text-align: center;margin-top: 3%">
                    <?php
                    // Number of pages required
                    $total_pages = ceil($total_records / $limit);
                    $previous = $pn - 1;
                    $next =  $pn + 1;
                    $previous_status = "";
                    $next_status = "";

                    if ($previous == 0) {
                        $previous_status = "disabled";
                    }
                    if ($next > $total_pages) {
                        $next_status = "disabled";
                    }

                    $pagLink = "";
                    $pagLink .= "<li class='page-item " . $previous_status . "'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php?page="
                        . $previous . "&total=" . $total_records . "'>Previous</a></li>";

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $pn) {
                            $pagLink .= "<li class='page-item active'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php?page="
                                . $i . "&total=" . $total_records . "'>" . $i . "</a></li>";
                        } else {
                            $pagLink .= "<li class='page-item'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php?page=" . $i . "&total=" . $total_records . "'> 
                            " . $i . "</a></li>";
                        }
                    };
                    $pagLink .= "<li class='page-item " . $next_status . "'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php?page="
                        . $next . "&total=" . $total_records . "'>Next</a></li>";

                    echo $pagLink;
                    ?>
                </ul>
            </nav>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title"> Sorry Bro !!!</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        This feature is only available for the one who already register an account. Therefore, if you dont have account just yet, join us by sign up one,
                        otherwise, you can login back to the site by clicking below button.
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 100px">Close</button>
                        <button type="button" class="btn btn-success" style="width: 150px" onclick="loginClicked()">Login</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="searchModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: purple; color: white">
                        <h4 class="modal-title">Search</h4>
                        <button type="button" class="close" data-dismiss="modal">x</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" style="background-color:palevioletred">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control homeText" id="searchInput" placeholder="By game's name..." style="background-color: palevioletred; font-size: 20px" required>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="background-color: purple">
                        <button type="button" class="btn " data-dismiss="modal" style="width: 100px; background-color:gray">Back</button>
                        <button type="button" class="btn " style="width: 150px;background-color: palevioletred" onclick="searchClicked()">Go</button>
                    </div>
                </div>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {

        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#requestTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


    }, false);

    function genreClicked(choosenGenre) {
        document.cookie = "genre=" + choosenGenre;
        window.open("http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/category.php", "_self");
    }

    function submitClicked() {

        var accountID = check_cookie_name("id");
        var accountName = check_cookie_name("name");
        var gname = document.getElementById("gname").value;
        var version = document.getElementById("version").value;

        document.getElementById("requestedBy").value = accountName;

        if (gname == "" || version == "") {
            alert("Both game's name and version have to be provided !!!");
            return;
        }

        if (accountID != 1) {
            document.getElementById("requestForm").submit();
        } else {
            $('#myModal').modal();
        }
    }

    function loginClicked() {
        window.open("http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/account.php", "_self");
    }

    function searched() {
        $('#searchModal').modal();
    }

    function searchClicked() {
        var searchInput = document.getElementById("searchInput").value;
        document.cookie = "search=" + searchInput;
        window.open("http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/search.php", "_self");
    }
</script>
<script>
    setImageSites("navlogo", "logo_trans.png");
</script>
<script>
    setImageSites("fb_logo", "fb_logo.png");
</script>
<script>
    setImageSites("fl_logo", "fl_logo.png");
</script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>

</html>