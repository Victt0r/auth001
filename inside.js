var url = `http://localhost/reg.auth/inside.php`;
request('GET', url, handler, console.log);
function handler(response) {
  response = JSON.parse(response);
  setCookie('token', response.token, {expires:60*60*24*7});
  response.logins.forEach(shower);
  function shower(login) {
    var li = document.createElement('li');
    li.innerText = login;
    ol.append(li);
  }
}
