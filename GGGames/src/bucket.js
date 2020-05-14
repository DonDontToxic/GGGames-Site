//
// Data constructs and initialization.
//

// **DO THIS**:
//   Replace BUCKET_NAME with the bucket name.
//
var albumBucketName = 'myimages.bucket';

// **DO THIS**:
//   Replace this block of code with the sample code located at:
//   Cognito -- Manage Identity Pools -- [identity_pool_name] -- Sample Code -- JavaScript
//
// Initialize the Amazon Cognito credentials provider
AWS.config.region = 'ap-southeast-1'; // Region



AWS.config.credentials = new AWS.CognitoIdentityCredentials({
    IdentityPoolId: 'ap-southeast-1:3fe663a9-5a06-4531-aae8-3466c0c9bba3',
});


AWS.config.update({
    accessKeyId: "AKIAIIASARHO54EMLTQQ",
    secretAccessKey: "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"
});

// Create a new service object
var s3 = new AWS.S3({
    apiVersion: '2006-03-01',
    params: { Bucket: albumBucketName }
});

// A utility function to create HTML.
function getHtml(template) {
    return template.join('\n');
}


//
// Functions
//

// List the photo albums that exist in the bucket.
function listAlbums() {
    s3.listObjects({ Delimiter: '/' }, function (err, data) {
        if (err) {
            return alert('There was an error listing your albums: ' + err.message);
        } else {
            var albums = data.CommonPrefixes.map(function (commonPrefix) {
                var prefix = commonPrefix.Prefix;
                var albumName = decodeURIComponent(prefix.replace('/', ''));
                return getHtml([
                    '<li>',
                    '<button style="margin:5px;" onclick="viewAlbum(\'' + albumName + '\')">',
                    albumName,
                    '</button>',
                    '</li>'
                ]);
            });
            var message = albums.length ?
                getHtml([
                    '<p>Click on an album name to view it.</p>',
                ]) :
                '<p>You do not have any albums. Please Create album.';
            var htmlTemplate = [
                '<h2>Albums</h2>',
                message,
                '<ul>',
                getHtml(albums),
                '</ul>',
            ]
            document.getElementById('viewer').innerHTML = getHtml(htmlTemplate);
        }
    });
}

// Show the photos that exist in an album.
function viewAlbum(albumName) {
    var albumPhotosKey = encodeURIComponent(albumName) + '/';
    s3.listObjects({ Prefix: albumPhotosKey }, function (err, data) {
        if (err) {
            return alert('There was an error viewing your album: ' + err.message);
        }
        // 'this' references the AWS.Response instance that represents the response
        var href = this.request.httpRequest.endpoint.href;
        var bucketUrl = href + albumBucketName + '/';

        var photos = data.Contents.map(function (photo) {
            var photoKey = photo.Key;
            console.log(photoKey);

            var photoUrl = bucketUrl + encodeURIComponent(photoKey);
            console.log(photoUrl);

            return getHtml([
                '<span>',
                '<div>',
                '<br/>',
                '<img style="width:128px;height:128px;" src="' + photoUrl + '"/>',
                '</div>',
                '<div>',
                '<span>',
                photoKey.replace(albumPhotosKey, ''),
                '</span>',
                '</div>',
                '</span>',
            ]);
        });

        var message = photos.length ?
            '<p>The following photos are present.</p>' :
            '<p>There are no photos in this album.</p>';
        var htmlTemplate = [
            '<div>',
            '<button onclick="listAlbums()">',
            'Back To Albums',
            '</button>',
            '</div>',
            '<h2>',
            'Album: ' + albumName,
            '</h2>',
            message,
            '<div>',
            getHtml(photos),
            '</div>',
            '<h2>',
            'End of Album: ' + albumName,
            '</h2>',
            '<div>',
            '<button onclick="listAlbums()">',
            'Back To Albums',
            '</button>',
            '</div>',
        ]
        document.getElementById('viewer').innerHTML = getHtml(htmlTemplate);
        document.getElementsByTagName('img')[0].setAttribute('style', 'display:none;');
    });
}

function createAlbum(albumName) {
    albumName = albumName.trim();
    if (!albumName) {
        return alert("Album names must contain at least one non-space character.");
    }
    if (albumName.indexOf("/") !== -1) {
        return alert("Album names cannot contain slashes.");
    }
    var albumKey = encodeURIComponent(albumName) + "/";
    s3.headObject({ Key: albumKey }, function (err, data) {
        if (!err) {
            return alert("Album already exists.");
        }
        if (err.code !== "NotFound") {
            return alert("There was an error creating your album: " + err.message);
        }
        s3.putObject({ Key: albumKey }, function (err, data) {
            if (err) {
                return alert("There was an error creating your album: " + err.message);
            }
            alert("Successfully created album.");
            viewAlbum(albumName);
        });
    });
    //   alert("createAlbum");

}

function addPhoto(albumName) {
    var files = document.getElementById("image").files;
    // alert(files);
    if (!files.length) {
        return alert("Please choose a file to upload first.");
    }
    var file = files[0];
    // alert(file);
    var fileName = file.name;
    var albumPhotosKey = encodeURIComponent(albumName) + "//";
    // alert(albumPhotosKey);

    var photoKey = albumPhotosKey + fileName;
    // alert(photoKey);

    // Use S3 ManagedUpload class as it supports multipart uploads
    var upload = new AWS.S3.ManagedUpload({
        params: {
            Bucket: albumBucketName,
            Key: photoKey,
            Body: file,
            ACL: "public-read"
        }
    });


    var promise = upload.promise();

    promise.then(
        function (data) {
            alert("Successfully uploaded photo.");
            viewAlbum(albumName);
        },
        function (err) {
            return alert("There was an error uploading your photo: ", err.message);
        }
    );
}

function deletePhoto(albumName, photoKey) {
    s3.deleteObject({ Key: photoKey }, function (err, data) {
        if (err) {
            return alert("There was an error deleting your photo: ", err.message);
        }
        alert("Successfully deleted photo.");
        viewAlbum(albumName);
    });
}


function deleteAlbum(albumName) {
    var albumKey = encodeURIComponent(albumName) + "/";
    s3.listObjects({ Prefix: albumKey }, function (err, data) {
        if (err) {
            return alert("There was an error deleting your album: ", err.message);
        }
        var objects = data.Contents.map(function (object) {
            return { Key: object.Key };
        });
        s3.deleteObjects(
            {
                Delete: { Objects: objects, Quiet: true }
            },
            function (err, data) {
                if (err) {
                    return alert("There was an error deleting your album: ", err.message);
                }
                alert("Successfully deleted album.");
                listAlbums();
            }
        );
    });
}

function setAccountAvatar(albumName, key) {
    var albumPhotosKey = encodeURIComponent(albumName) + '/';
    var neededPhotoKey = albumName + "/" + key;
    var isFound = false;
    var imgSrc = "";;
    s3.listObjects({ Prefix: albumPhotosKey }, function (err, data) {

        if (err) {
            return alert('There was an error viewing your album: ' + err.message);
        }
        // 'this' references the AWS.Response instance that represents the response
        var href = this.request.httpRequest.endpoint.href;
        var bucketUrl = href + albumBucketName + '/';

        var photos = data.Contents.map(function (photo) {
            var photoKey = photo.Key;
            var photoUrl = bucketUrl + encodeURIComponent(photoKey);

            if (photoKey == neededPhotoKey) {
                imgSrc = photoUrl;
                isFound = true;
            }
        });
        if(isFound) {
            document.getElementById("avaImg").src = imgSrc;
        } else {
            setImageSites("avaImg", "login_logo.png");
        }
    });
}

function setImageSites(id, key) {
    var albumPhotosKey = encodeURIComponent("images") + '/';
    var neededPhotoKey = "images/" + key;
    var imgSrc = "";
    s3.listObjects({ Prefix: albumPhotosKey }, function (err, data) {

        if (err) {
            return alert('There was an error viewing your album: ' + err.message);
        }
        var href = this.request.httpRequest.endpoint.href;
        var bucketUrl = href + albumBucketName + '/';

        var photos = data.Contents.map(function (photo) {
            var photoKey = photo.Key;
            var photoUrl = bucketUrl + encodeURIComponent(photoKey);
            if (photoKey == neededPhotoKey) {
                imgSrc = photoUrl;
            }
        });
        if(id.includes("bg")) {
            document.getElementById(id).style.backgroundImage = "url('"+ imgSrc +"')";
            document.getElementById(id).style.backgroundPosition = "center";
            document.getElementById(id).style.backgroundRepeat = "no-repeat";
            document.getElementById(id).style.backgroundSize = "cover";
            document.getElementById(id).style.height = "100%";
        }else if(id.includes("icon")) {
            document.getElementById(id).href  = imgSrc;
        }else {
            document.getElementById(id).src = imgSrc;
        }
    });
}
