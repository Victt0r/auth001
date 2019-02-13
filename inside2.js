var url = `http://localhost/reg.auth/inside2.php`;
request('GET', url, handler, console.log);
function handler(response) {
  response = JSON.parse(response);
  setCookie('token', response.token, {expires:60*60*24*7});
  h2.innerText += " "+response.number;
}

