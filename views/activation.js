function activate(id) {
    div = document.getElementById('content:' + id);
    li = document.getElementById('title:' + id);
    div.className = div.className.replace(/inactive/, 'active');
    li.className = li.className.replace(/inactive/, 'active');
    return false;
}

function deactAll(actives) {
    while(0 < actives.length) {
        actives[0].className = actives[0].className.replace(/\ active/, ' inactive');
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
