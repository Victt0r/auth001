function logout(){
  var url = `http://localhost/reg.auth/logout.php`;
  request('GET', url, console.log, console.log);

  deleteCookie('user_id');
  deleteCookie('token');
  window.location.href = 'http://localhost/reg.auth/login.html';
}

