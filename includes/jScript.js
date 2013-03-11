function disableInputs(el) {
    var el = document.getElementById('div_bid'),
        all = el.getElementsByTagName('input'),
        i;
    for (i = 0; i < all.length; i++) {
        all[i].disabled = true;
    }
}

