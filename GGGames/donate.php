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
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web&display=swap' rel='stylesheet'>
    <title>Donate GG Games</title>
    <style>
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
                    <a class="nav-link " href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/request.php">Request Game</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/donate.php">Donate ❤</a>
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

        <div class="container text-center" style="padding-top: 2%;padding-bottom:2%;background-color:pink">

            <img id="donate_logo" alt="Logo" width="400" height="300">
            <p for="content" class="homeText" style="font-size: 25px; margin-top:2%">If you like GG-Games and would like to contribute and support it, please consider making a donation to help us maintain this sites.</p>
            <p for="content" class="homeText" style="font-size: 25px">We accept many forms of donation</p></br>
            <p class='homeText' style='color: purple'><span>BTC: </span>
                <span class='homeText'><a href="https://coinmarketcap.com" target="_blank"> 15AADVzTobcPT1S3sSHqLrSfaNYoT4myuK</a></span></p>
            <p class='homeText' style='color: purple'><span>BCH: </span>
                <span class='homeText'><a href="https://coinmarketcap.com" target="_blank"> qqkehuyyzv4653jkjru087zzq6urcsq30ujlh2942l</a></span></p>
            <p class='homeText' style='color: purple'><span>LTC: </span>
                <span class='homeText'><a href="https://coinmarketcap.com" target="_blank"> Lcn5U7K3cwhjTVnqcm22P8fUz5C8erHNaT</a></span></p>
            <p class='homeText' style='color: purple'><span>ETH: </span>
                <span class='homeText'><a href="https://coinmarketcap.com" target="_blank"> 0x716D8338a86e33c01c40AC0662310E80cf73a444</a></span></p>
            <p class='homeText' style='color: purple; margin-bottom:2%'><span>STELLAR: </span>
                <span class='homeText'><a href="https://coinmarketcap.com" target="_blank"> GANL7D37744YXVGGKEL4R633NDKJUVCSEFPJHNBL34XNTQPLADXJXMVZ</a></span></p>

            <img id="bitdonate_logo" alt="Logo" width="400" height="400">
            <p for="content" class="homeText" style="font-size: 25px">Otherwise, you also can donate us by bitcoin</p>
            <p for="content" class="homeText" style="font-size: 25px">You can buy some bitcoin an other cryptocurrencies on these sites:</p>
            <a href="https://indacoin.com" target="_blank">https://indacoin.com</a></br>
            <iframe width='700' height='450' src='https://www.youtube.com/embed/n1sXko6dIX8' frameborder='2' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture'></iframe></br></br>
            <iframe width='700' height='450' src='https://www.youtube.com/embed/NzcNg18d05c' frameborder='2' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture'></iframe></br></br>
            <iframe width='700' height='450' src='https://www.youtube.com/embed/gVWXahDuIU8' frameborder='2' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture'></iframe></br></br>
            <p for="content" class="homeText" style="color:purple;font-size: 15px;"><span>When withdrawal bitcoins, if you want to donate me, Please paste not your bitcoin address, but this one: </span>
                <span class='homeText' style="font-size: 15px">15AADVzTobcPT1S3sSHqLrSfaNYoT4myuK</span></p>
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

    <footer style="background-color:#2c3539">
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
    setImageSites("donate_logo", "donate.png");
</script>
<script>
    setImageSites("bitdonate_logo", "bitdonate.png");
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