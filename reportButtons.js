chb.onclick = reportButtons
function reportButtons(event) {
  if (window.rbe) return;
  event.stopPropagation();
  var div = document.createElement('div');
  div.setAttribute('style', 'position:absolute;display:flex;flex-direction:column;transform:translateX(-38%)')
  div.innerHTML =
    `<div style=display:flex>
      <button id=done>сделано</button>
      <button id=fail>провалено</button>
    </div> 
    <button id=firm style=display:none>подтвердить</button>`
  this.parentElement.append(div);
  window.rbe = true;
  function handleReportButton(event) {

    const {target} = event;
    if (target == done) {
      firm.confirm = 'done'
      firm.style.display = 'inline-block'
    }
    else if (target == fail) {
      firm.confirm = 'fail'
      firm.style.display = 'inline-block'
    }
    else if (target == firm) {
      if (firm.confirm == 'done') console.log("запрос yes")
      else if (firm.confirm == 'fail') console.log("запрос no")
      div.remove();
      window.rbe = false
      document.body.removeEventListener('click', handleReportButton);
    }
    else {
      div.remove();
      window.rbe = false;
      document.body.removeEventListener('click', handleReportButton);
    }
  }
  document.body.addEventListener('click', handleReportButton);
}


  // TODO написать обработчики для кнопок блока.
