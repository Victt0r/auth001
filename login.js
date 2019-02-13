function enter(){
  var url = `http://localhost/reg.auth/login.php?login=${login.value}&pass=${pass.value}`;
  request('POST', url, handler, console.log);
}

function handler(response) {
  if (response.startsWith("{")) {
    response = JSON.parse(response);
    setCookie('user_id', response.id, {expires:60*60*24*30});
    setCookie('token', response.token, {expires:60*60*24*30});
    //window.location.href = "http://p.acoras.in.ua/todo.php?user_id="+response.id;
  }
  else resp.innerText = response;

}
