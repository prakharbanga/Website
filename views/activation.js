function activate(id) {
    div = document.getElementById('content:' + id);
    li = document.getElementById('title:' + id);
    //alert("activating " + div.id + " class is " + div.className);
    div.className = div.className.replace(/inactive/, 'active');
    //alert("activating " + li.id + " class is " + li.className);
    li.className = li.className.replace(/inactive/, 'active');
    return false;
}

function deactAll(actives) {
    //var x = 0;
    while(0 < actives.length) {
        //alert(actives.length + " are active");
        //alert("deactivating " + x + " " + actives[0].id + " class is " + actives[0].className);
        actives[0].className = actives[0].className.replace(/\ active/, ' inactive');
        //x++;
    }
}

function activateOne(id) {
    var actives = getActives();
    deactAll(actives);
    return activate(id);
}

function getActives() {
    return document.getElementsByClassName('active');
}
