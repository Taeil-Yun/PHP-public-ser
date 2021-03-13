function getParameter(param) {
    var url = location.href;
    var parameters = (url.slice(url.indexOf('?') + 1, url.length)).split('&');
    for (var i = 0; i < parameters.length; i++) {
        var varName = parameters[i].split('=')[0];
        if (varName.toUpperCase() == param.toUpperCase()) {
            var varValue = parameters[i].split('=')[1];
            return decodeURIComponent(varValue);
        }
    }
}
