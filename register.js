function request(type, url, cb, reportcb) {
  const xhr = new XMLHttpRequest()
  xhr.open(type, url)
  xhr.timeout = 30000
  xhr.ontimeout = () => reportcb? reportcb(`${type} ${url} timed out`) :0
  xhr.onerror   =  e => reportcb? reportcb(`${type} ${url} produced ${e}`) :0
  xhr.onload    = () => {
    if (cb) {
      if (xhr.status >= 200 && xhr.status < 400) {
        if (!xhr.response.startsWith('<?php')) {
          if (xhr.response !== '') cb(xhr.response)
          else cb() ||
            reportcb? reportcb(`${type} ${url} response was empty`) :0
        }
        else if (reportcb) {
          reportcb(`${type} ${url} php-code returned instead of response`)
        }
      }
      else {
        if (reportcb) reportcb(`${type} ${url} request.status is ${xhr.status
                               } ${xhr.statusText}`)
        cb()
      }
    }
  }
  xhr.send()
}

function register(){
  var url = `http://localhost/reg.auth/register.php?login=${login.value}&mail=${
            mail.value}&pass=${pass.value}`;
  request('POST', url, handler, console.log)
}

function handler(response) {
  resp.innerText = response+'\n';
  if (response == "регистрация успешна") {
    var button = document.createElement('button');
    button.innerText = 'войти';
    resp.append(button);
    button.onclick =
      () => window.location.href = 'http://localhost/reg.auth/login.html'
  }
}
