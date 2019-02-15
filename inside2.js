var url = `http://localhost/reg.auth/inside2.php`;
request('GET', url, handler, console.log);
function handler(response) {
  response = JSON.parse(response);
  setCookie('user_id', getCookie('user_id'), {expires:60*60*24*30});
  setCookie('token', response.token, {expires:60*60*24*30});
  h2.innerText += " "+response.number;
}

