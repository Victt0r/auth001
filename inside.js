var url = `http://localhost/reg.auth/inside.php`;
request('GET', url, handler, console.log);
function handler(response) {
  if (response.startsWith("{")) {
    response = JSON.parse(response);
    setCookie('user_id', getCookie('user_id'), {expires:60*60*24*30});
    setCookie('token', response.token, {expires:60*60*24*30});
    response.logins.forEach(shower);
    function shower(login) {
      var li = document.createElement('li');
      li.innerText = login;
      ol.append(li);
    }
  }
}
