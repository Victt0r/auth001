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
    <button id=firm>подтвердить</button>`
  this.parentElement.append(div);
  window.rbe = true;
  function handleReportButton(event) {
    const {target} = event;
    if (target == done) console.log("запрос done");
    else if (target == fail) console.log("запрос fail");
    else if (target == firm) console.log("запрос confirm");
    else console.log("закрыть баттонс");
    // switch (target) {
    //   case done: console.log("запрос done")
    //     break;
    //   case fail: console.log("запрос fail")
    //     break;
    //   case firm: console.log("запрос confirm")
    //     break;
    //   default: console.log("закрыть баттонс");
    // }
  }
  document.body.addEventListener('click', handleReportButton);
}
  // TODO написать обработчики для кнопок блока.
