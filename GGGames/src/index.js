function check_cookie_name(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) {
        console.log(match[2]);
       return match[2];
    } else {
        console.log('--something went wrong---');
    }
}