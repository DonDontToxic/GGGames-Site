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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
    <title>GG-Game: Home</title>
    <style>

        .mySlides {
            display: none;
        }

        .mySlides:hover {
            cursor: pointer;
        }

        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* The dots/bullets/indicators */
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: purple;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .dotactive {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @-webkit-keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
            .text {
                font-size: 11px
            }
        }

        /* Thick purple border */
        hr.custom {
            border: 5px solid purple;
            width: 100%
        }

        .vl {
            border-left: 2px solid gray;
            height: 150px;
        }

        .card-title {
            font-size: 18px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
    </style>
    <link rel="stylesheet" href="styles.css">
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
                    <a class="nav-link active" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/">Home</a>
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
                    <a class="nav-link " href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php">Request Game</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/donate.php">Donate ❤</a>
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

    <div class="container-fluid">

        <div class="row" style="padding-top: 2%">
            <div class="col-sm-1">
                <hr class="custom">
            </div>
            <div class="col-sm-2">
                <h2 class="hero" style="color:purple; font-size: 40px; font-weight: bold;">Games Hot</h2>
            </div>
            <div class="col-sm-9">
                <hr class="custom">
            </div>
        </div>
        <div class="container" style="padding-top: 1%;">
            <?php
            $hotGameInfos = file_get_contents('https://hcuimeuu6c.execute-api.ap-southeast-1.amazonaws.com/default/myViewFunction');
            $hotGameInfos_json = json_decode($hotGameInfos, true);
            $imagestr = "";

            for ($i = 0; $i < sizeof($hotGameInfos_json); $i++) {
                $hotgameImages = $hotGameInfos_json[$i]["Images"];
                $imagestr .=
                    "<div class='mySlides fade' onclick='slideClicked(" . $hotGameInfos_json[$i]["ID"] . ")'>
                        <img src='" . $hotgameImages . "' width='1100px' height='600px'>
                        <form id='gameHotForm' method='post' action='game.php'>
                            <input type='hidden' id='gameID' name='gameID' value='" . $hotGameInfos_json[$i]["ID"] . "'>
                        </form>
                    </div>";
            }
            echo $imagestr;

            ?>
            <br>
            <div style="text-align:center">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <!-- <span class="dot"></span> -->
            </div>

            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-horizontal">
                                    <div class="img-square-wrapper" style="background-color: purple">
                                        <img class="" id="mousesIcons" width="150" height="150" alt="Card image cap">
                                    </div>
                                    <div class="card-body" style="background-color: black">
                                        <h3 class="card-title homeText">PC</h3>
                                        <h4 class="card-text homeText">View Games</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-horizontal">
                                    <div class="img-square-wrapper" style="background-color: purple">
                                        <img class="" id="psIcons" width="150" height="150" alt="Card image cap">
                                    </div>
                                    <div class="card-body" style="background-color: black">
                                        <h3 class="card-title homeText">PS4</h3>
                                        <h4 class="card-text homeText">View Games</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-horizontal">
                                    <div class="img-square-wrapper" style="background-color: purple">
                                        <img class="" id="xboxIcons" width="150" height="150" alt="Card image cap">
                                    </div>
                                    <div class="card-body" style="background-color: black">
                                        <h3 class="card-title homeText">XBOX</h3>
                                        <h4 class="card-text homeText">View Games</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row" style="padding-top: 2%">
            <div class="col-sm-1">
                <hr class="custom">
            </div>
            <div class="col-sm-2">
                <h2 class="hero" style="color:purple; font-size: 40px; font-weight: bold;">Games List</h2>
            </div>
            <div class="col-sm-9">
                <hr class="custom">
            </div>
        </div>

        <div class="container">

            <?php
            if (isset($_GET["page"])) {
                $pn  = $_GET["page"];
                $total_records = $_GET["total"];
            } else {
                $pn = 1;
                $gameInfos = file_get_contents('https://r9facivsme.execute-api.ap-southeast-1.amazonaws.com/default/myGameFunction?startFrom=0&limit=18446744073709551615');
                $gameInfos_json = json_decode($gameInfos, true);
                $total_records = sizeof($gameInfos_json);
            };

            // Look for a GET variable page if not found default is 1.     
            $limit = 6;  // Number of entries to show in a page.  
            $start_from = ($pn - 1) * $limit;
            $gameInfos = file_get_contents('https://r9facivsme.execute-api.ap-southeast-1.amazonaws.com/default/myGameFunction?startFrom=' . $start_from . "&limit=" . $limit . "");
            $gameInfos_json = json_decode($gameInfos, true);

            $gameCards = "<div class='row' style='margin-top: 2%'>";
            for ($i = 0; $i < sizeof($gameInfos_json); $i++) {
                if ($i % 3 == 0) {
                    $gameCards .= "</div><div class='row' style='margin-top: 2%'>";
                }
                $gameID = $gameInfos_json[$i]["ID"];
                $gameName = $gameInfos_json[$i]["Name"];
                $gameCatg = $gameInfos_json[$i]["Category"];
                $gameDate = explode("T", $gameInfos_json[$i]["CDate"]);
                // $gameDate = $gameInfos_json[$i]["CDate"];
                $gameImage = $gameInfos_json[$i]["Images"];
                //ini_set('memory_limit', '-1');
                $gameCards .=
                    "<div class='col-sm-4'>
                    <div class='card text-center' style='width:300px; margin-inline-end: 0%'>
                        <img class='card-img-top' src='" . $gameImage . "' alt='Card image' style='background-color:black'>
                        <div class='card-body' style='background-color:pink'>
                            
                            <div class='textBox card-title'><span>" . $gameName . "</span></div>

                            <p class='card-text'>Category: " . $gameCatg . "</p>
                            <div class='row'>
                                <div class='col-6' style='text-align: left'>
                                    <p class='card-text'>Cracked in: " . $gameDate[0] . "</p>
                                </div>
                                <div id='infoDiv' class='col-6' style='text-align: right'>
                                    <form id='gameForm' method='post' action='game.php'>
                                        <input type='hidden' name='gameID' value='" . $gameID . "'>
                                        <input type='hidden' name='game_submitted' value='1'>
                                        <input type='submit' class='btn btn-danger' value='Download'>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
                if ($i == sizeof($gameInfos_json) - 1) {
                    $gameCards .= "</div>";
                }
            }
            echo $gameCards;
            ?>
        </div>

        <nav aria-label="Page Navgation">
            <ul class="pagination pagination-lg justify-content-end" style="text-align: center;margin-top: 3%">
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
                $pagLink .= "<li class='page-item " . $previous_status . "'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com?page="
                    . $previous . "&total=" . $total_records . "'>Previous</a></li>";

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $pn) {
                        $pagLink .= "<li class='page-item active'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com?page="
                            . $i . "&total=" . $total_records . "'>" . $i . "</a></li>";
                    } else {
                        $pagLink .= "<li class='page-item'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com?page=" . $i . "&total=" . $total_records . "'> 
                            " . $i . "</a></li>";
                    }
                };
                $pagLink .= "<li class='page-item " . $next_status . "'><a class='page-link' href='http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com?page="
                    . $next . "&total=" . $total_records . "'>Next</a></li>";

                echo $pagLink;
                ?>
            </ul>
        </nav>
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
                                <!-- <label for="recipient-name" class="col-form-label">By Name:</label> -->
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
<script type="text/javascript">

    var slideIndex = 0;
    showSlides();

    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" dotactive", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " dotactive";
        setTimeout(showSlides, 2000); // Change image every 2 seconds
    }

    function slideClicked(gameHotID) {
        document.getElementById("gameID").value = gameHotID;
        document.getElementById("gameHotForm").submit();
    }


    function genreClicked(choosenGenre) {
        document.cookie = "genre=" + choosenGenre;
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
    setImageSites("mousesIcons", "mousesIcons.png");
</script>
<script>
    setImageSites("psIcons", "psIcons.png");
</script>
<script>
    setImageSites("xboxIcons", "xboxIcons.png");
</script>
<script>
    setImageSites("fb_logo", "fb_logo.png");
</script>
<script>
    setImageSites("fl_logo", "fl_logo.png");
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</html>