starting();

function starting() {
    var get_ip = ajax_get('https://ipwhois.app/json/', '');
    if(get_ip !== false) {
        console.log('IP : ' + get_ip['ip'] + ' || Country : ' + get_ip['country']);
    }
}


function ajax_get(url, params) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url + params, true);
    xhr.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            return this.responseText;
        } else {
            return false;
        }
    };
    xhr.send();
}
