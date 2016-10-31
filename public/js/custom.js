function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();

    var year = today.getFullYear();
    var month = (today.getMonth()+1);
    var day = today.getUTCDate();
    var d = day+"/"+month+"/"+year;
    
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('getclock').innerHTML = d+" "+
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}