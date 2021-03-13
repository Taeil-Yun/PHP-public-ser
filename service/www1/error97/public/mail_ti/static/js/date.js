//Data format
function getFormatDate(date) {

    //today
    var today = new Date(); //today
    var today_year = today.getFullYear();
    var today_month = (1 + today.getMonth());
    today_month = today_month >= 10 ? today_month : '0' + today_month;	//month 두자리로 저장
    var today_day = today.getDate();
    today_day = today_day >= 10 ? today_day : '0' + today_day;	//day 두자리로 저장
    var today_all = today_year + "-" + today_month + "-" + today_day;

    //udate
    var year = date.getFullYear();	//yyyy
    var month = (1 + date.getMonth());	//M
    month = month >= 10 ? month : '0' + month;	//month 두자리로 저장
    var day = date.getDate();	//d
    day = day >= 10 ? day : '0' + day;	//day 두자리로 저장
    var day_all = year + "-" + month + "-" + day;

    //time
    var hour = date.getHours();
    hour = hour >= 10 ? hour : '0' + hour;	//hours 두자리로 저장
    var minutes = date.getMinutes();
    minutes = minutes >= 10 ? minutes : '0' + minutes;	//minutes 두자리로 저장

    //출력
    year = (today_year == year) ? "" : year + "-";
    day = (today_all == day_all) ? "" : month + "-" + day + " ";
    var time = hour + ":" + minutes;

    return year + day + time;
}
