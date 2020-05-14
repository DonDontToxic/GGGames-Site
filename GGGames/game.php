<?php

if (!isset($_COOKIE["id"])) {
    setcookie("id", 1, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("name", "Guest", time() + (86400 * 30), "/");
    setcookie("status",  "Login", time() + (86400 * 30), "/");
    setcookie("genre",  "", time() + (86400 * 30), "/");
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
                    <a class="nav-link dropdown-toggle active" href="#" id="navbardrop" data-toggle="dropdown">Games+</a>
                    <div class="dropdown-menu">
                        <a onclick="genreClicked('Action'); return false;" class="dropdown-item" href="">Action</a>
                        <a onclick="genreClicked('Shooter'); return false;" class="dropdown-item" href="">Shooter</a>
                        <a onclick="genreClicked('Hack and Slash'); return false;" class="dropdown-item" href="">Hack and Slash</a>
                        <a onclick="genreClicked('Indie'); return false;" class="dropdown-item" href="">Indie</a>
                        <a onclick="genreClicked('Sport'); return false;" class="dropdown-item" href="">Sport</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php">Request Game</a>
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

            <?php
            $gameInfos = file_get_contents('https://k7e6znphqa.execute-api.ap-southeast-1.amazonaws.com/default/myGameIDFunction?id=' . $_POST['gameID']);
            $gameInfos_json = json_decode($gameInfos, true);
            $gameID = $gameInfos_json[0]['ID'];
            $gameDescrpt = $gameInfos_json[0]['Description'];
            $gameCatg = $gameInfos_json[0]['Category'];
            $gameSize = $gameInfos_json[0]['Size'];
            $gameImages = $gameInfos_json[0]['Images'];
            $gameVids = $gameInfos_json[0]['Videos'];
            $gameDowns = $gameInfos_json[0]['Downloads'];
            $gameVDowns = $gameInfos_json[0]['VDownloads'];
            $gameBuy = $gameInfos_json[0]['Buy'];
            $gameView = (int) $gameInfos_json[0]['View'];

            $gameInfo = explode('-', $gameInfos_json[0]['Name']);
            $gameDate = explode('T', $gameInfos_json[0]['CDate']);
            $gameGPI = explode('\n', $gameInfos_json[0]['GPImages']);


            $gamestr = "<div class='text-center'>
            <h3 class='homeText'>" . $gameInfo[0] . " - " . $gameInfo[1] . "</h3>
            <img src=" . $gameImages . " alt='Game banner shloud be here' width='600' height='450'></div>";

            $gamestr .=
                "<nav style='margin-top: 2%; margin-left:2%; margin-right:2%'>
                <div class='nav nav-tabs' id='nav-tab' role='tablist' style='background-color: palevioletred'>
                <a class='nav-item nav-link active tabText' id='nav-descrpt-tab' data-toggle='tab' href='#nav-descrpt' role='tab' aria-controls='nav-descrpt aria-selected='true'>DESCRIPTION</a>
                <a class='nav-item nav-link tabText' id='nav-download-tab' data-toggle='tab' href='#nav-download' role='tab' aria-controls='nav-download' aria-selected='false'>DOWNLOAD</a>
                <a class='nav-item nav-link tabText' id='nav-sshot-tab' data-toggle='tab' href='#nav-sshot' role='tab' aria-controls='nav-sshot' aria-selected='false'>SCREENSHOTS</a>
                <a class='nav-item nav-link tabText' id='nav-gplay-tab' data-toggle='tab' href='#nav-gplay' role='tab' aria-controls='nav-gplay' aria-selected='false'>GAMEPLAY</a>
                <a class='nav-item nav-link tabText' id='nav-info-tab' data-toggle='tab' href='#nav-info' role='tab' aria-controls='nav-info' aria-selected='false'>INFO</a>
                </div>
            </nav>

            <div class='tab-content' id='nav-tabContent' style='background-color: pink; margin-left:2%; margin-right:2%'>
                <div class='tab-pane fade show active' id='nav-descrpt' role='tabpanel' aria-labelledby='nav-descrpt-tab' style='padding-top: 2%;padding-left: 2%'>
                    <h3 class='contentText' style='color: purple'>About The Game</h3>
                    <p class='contentText'>" . $gameDescrpt . "</p>
                    <p class='contentText' style='color: purple'><span>Title: </span>
                    <span class='contentText'> " . $gameInfo[0] . "</span></p>   
                    <p class='contentText' style='color: purple'><span>Genre: </span>
                    <span class='contentText'>" . $gameCatg . "</span></p>   
                    <p class='contentText' style='color: purple'><span>Size: </span>
                    <span class='contentText'>" . $gameSize . " GB</span></p> 
                    <p class='contentText text-center' style='color: purple'><span>Support the software developers, please </span>
                    <span><a class='text-center' href='" . $gameBuy . "' target='_blank'>BUY IT!</a></span></p> 
                </div>
                <div class='tab-pane fade' id='nav-download' role='tabpanel' aria-labelledby='nav-download-tab' style='padding-top: 2%;padding-left: 2%'>
                    <h3 class='contentText' style='color: purple'>" . $gameInfo[0] . "</h3>
                    <p class='contentText' style='color: purple'><span>Cracked by: </span>
                    <span class='contentText'>" . $gameInfo[1] . "</span></p>   
                    <p class='contentText' style='color: purple'><span>Cracked in: </span>
                    <span class='contentText'>" . $gameDate[0] . "</span></p>   
                    <p class='contentText text-center' style='color: purple'><span>Download</span>
                    <span><a class='text-center' href='" . $gameDowns . "' target='_blank'>HERE!</a> OR  
                    <span><a id='myTag' class='text-center' href='' onclick='exDownClicked(); return false;'> HERE! </a></span></p> 

                </div>
                <div class='tab-pane fade text-center' id='nav-sshot' role='tabpanel' aria-labelledby='nav-sshot-tab' style='padding-top: 2%;padding-left: 2%'>
                    <img src='" . $gameGPI[0] . "' alt='Game banner shloud be here' width='900' height='600'>
                    <img style = 'margin-top:2%'src='" . $gameGPI[1] . "' alt='Game banner shloud be here' width='900' height='600'>
                    <img style = 'margin-top:2%' src='" . $gameGPI[2] . "' alt='Game banner shloud be here' width='900' height='600'>
                </div>

                <div class='tab-pane fade text-center' id='nav-gplay' role='tabpanel' aria-labelledby='nav-gplay-tab' style='padding-top: 2%;padding-left: 2%'>
                    <iframe width='900' height='600' src='" . $gameVids . "' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                </div>

                <div class='tab-pane fade' id='nav-info' role='tabpanel' aria-labelledby='nav-info-tab' style='padding-top: 2%;padding-left: 2%'>
                    <h3 class='contentText' style='color: purple'>" . $gameInfo[0] . " - " . $gameInfo[1] . "</h3>
                    <p class='contentText' >1.Exact</p>
                    <p class='contentText'>2.Copy crack (if needed) and Play!</p>
                </div>
            </div>";

            echo $gamestr;


            $url = 'https://s2f2s8w1rc.execute-api.ap-southeast-1.amazonaws.com/testPut/putview?id=' . $_POST['gameID'];
            $gameView++;
            $data = array('View' => $gameView);
            $data = json_encode($data);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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

            ?>

            <div style="margin-left:2%; margin-right:3%">
                <div class="row" style="margin-top: 2%">
                    <div class="col-sm-1">
                        <hr class="custom">
                    </div>
                    <div class="col-sm-3">
                        <h3 class="homeText text-center">Lastest Comments</h3>
                    </div>
                    <div class="col-sm-8">
                        <hr class="custom">
                    </div>
                </div>

                <?php
                $commentInfos = file_get_contents('https://e6y3n7ktk2.execute-api.ap-southeast-1.amazonaws.com/default/myCommentIDFunction?In_gameID=' . $_POST['gameID']);
                $commentInfos = json_decode($commentInfos, true);
                $commentstr = "";

                for ($i = 0; $i < sizeof($commentInfos); $i++) {
                    $replyAva = "https://s3.ap-southeast-1.amazonaws.com/myimages.bucket/";

                    if( $commentInfos[$i]["CommentedBy"] != 1) {
                        $replyAva .= "avatars%2F".$commentInfos[$i]["Name"].".png";
                    } else {
                        $replyAva .= "images%2Fdefaultava.png";
                    }
                    $commentstr .=
                        "<div class='row'>
                        <div class='col-12 mt-3'>
                            <div class='card'>
                                <div class='card-horizontal'>
                                    <div class='img-square-wrapper' style='background-color:palevioletred' style='padding-left: 2%;padding-right: 2%'>
                                        <img id='replyAva' src='". $replyAva."' width='150' height='150' alt='Default avatar here'>
                                    </div>
                                    <div class='card-body' style='background-color:black'>
                                        <h3 class='card-title homeText'>" . $commentInfos[$i]["Name"] . " says: </h3>
                                        <h4 class='card-text homeText'>" . $commentInfos[$i]["Content"] . "</h4>
                                        <h5 class='card-text homeText' style='float: right'>" . $commentInfos[$i]["DateTime"] . "</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
                echo $commentstr;
                ?>

                <div class="row" style="margin-top: 2%">
                    <div class="col-sm-1">
                        <hr class="custom">
                    </div>
                    <div class="col-sm-3">
                        <h3 class="homeText text-center">Leave A Reply</h3>
                    </div>
                    <div class="col-sm-8">
                        <hr class="custom">
                    </div>
                </div>

                <?php if (isset($_POST['comment_submitted'])) :
                    date_default_timezone_set('Australia/Melbourne');
                    $dateTime = date('m/d/Y h:i:s a', time()) . " " . date('T');
                    $gameID = (int) $_POST['gameID'];
                    $$data = "";

                    $url = 'https://g9de599qg0.execute-api.ap-southeast-1.amazonaws.com/testPost/postcomment?gid=' . $gameID. '&aid=' .$_COOKIE['id'];

                    if($_COOKIE['id'] != 1) {
                        $data = array('Name' => $_COOKIE['name'], 'Content' =>  $_POST['content'], 'Mail' => $_COOKIE['mail'], 'DateTime' =>  $dateTime);
                    } else {
                        $data = array('Name' => $_POST['name'], 'Content' =>  $_POST['content'], 'Mail' => $_POST['email'], 'DateTime' =>  $dateTime);
                    }

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
                                    <td class="" style="color: white; font-style:bold; font-weight:20px">The comment has been submitted sucessfully</td>
                                </tr>
                                <thead class="table-danger" style="background-color: palevioletred">
                                    <tr>
                                        <th>Please reload page to update comments section
                                            <form class="text-center" id="commentForm" action="game.php" method="post" style="padding-top: 1%">
                                                <input type="hidden" id="gameID" name="gameID" value=<?php echo "'" . $_POST['gameID'] . "'"; ?> />
                                                <input class="btn" type="submit" value="Reload" style="float:center; width:200px; background-color:black">
                                            </form>
                                        </th>
                                    </tr>
                                </thead>
                            </tbody>
                        </table>
                    </div>

                <?php else : ?>
                    <form id="commentForm" action="game.php" method="post" style="margin-top:2%">

                        <?php
                        $str = "";
                        if($_COOKIE['id'] == 1) {
                            $str .=  "<div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-4'>
                                    <input type='text' class='form-control homeText' id='name' placeholder='Enter name' name='name' style='background-color: black; font-size: 15px' required>
                                </div>
                                <div class='col-sm-8'>
                                    <label for='name' class='homeText' style='font-size: 15px'>Name (required)</label>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-4'>
                                    <input type='email' class='form-control homeText' id='email' placeholder='Enter your mail' name='email' style='background-color: black; font-size: 15px' required>
                                </div>
                                <div class='col-sm-8'>
                                    <label for='email' class='homeText' style='font-size: 15px'>Mail (will not be published) (required)</label>
                                </div>
                            </div>
                        </div>";
                        }
                        echo $str;
                        ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="content" name="content" cols="50" rows="3" style="background-color: black; font-size: 15px" placeholder="Enter comment here"></textarea>
                                </div>
                                <div class="col-sm-4">
                                    <label for="content" class="homeText" style="font-size: 15px">Comments (required)</label></br>
                                    <input type="hidden" id="gameID" name="gameID" value=<?php echo "'" . $_POST['gameID'] . "'"; ?> />
                                    <input type="hidden" id="comment_submitted" name="comment_submitted" value="1" />
                                    <input class="btn" type="submit" value="Submit Comment" style="background-color: palevioletred; float:left">
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"> Sorry Bro !!!</h4>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            This back-up link only available for the one who already register an account. Therefore, if you dont have account just yet, join us by sign up one,
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

    function exDownClicked() {
        var accountID = check_cookie_name("id");
        if (accountID != 1) {
            window.open("<?php echo $gameVDowns ?>");
        } else {
            $('#myModal').modal();
        }
    }

    function loginClicked() {
        window.open("http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/account.php", "_self");
    }

    function genreClicked(chosenGenre) {
        document.cookie = "genre=" + chosenGenre;
        window.open("http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/category.php", "_self");
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