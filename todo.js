// TODO table building function
var url = `todoFetch.php`;
request('GET', url, handler, console.log);
function handler(response) {
  if (response.startsWith("[")) {
    response = JSON.parse(response);
    console.log(response);
    // setCookie('user_id', getCookie('user_id'), {expires:60*60*24*30});
    // setCookie('token', response.token, {expires:60*60*24*30});

    var table = document.createElement('table');
    section.append(table);
    table.innerHTML = `<tr>
    <th></th>
    <th>ВВС</th>
    <th>действие</th>
    <th>сделано (всего)</th>
    <th>залог/награда</th>
  </tr>`
    response.forEach(buildRow);
    function buildRow(row) {
      ex = {
        payment: row[2], 
        activity: row[6], 
        total: row[7], 
        done: row[7]-row[8],
        left: row[8], 
        value: row[9], 
        fora: row[10], 
        pledge: row[9]/row[7]*(row[7]-row[10]),
        date: row[4]
      }

      var tr = document.createElement('tr');
      //  checkBox
      var td = document.createElement('td');
      var input = document.createElement('input');
      table.append(tr);
      tr.append(td);
      td.append(input);
      input.setAttribute('type', 'checkbox');
      td = document.createElement('td');
      td.innerText = '+'+ex.payment;
      tr.append(td);
      td = document.createElement('td');
      td.innerText = ex.activity;
      tr.append(td);
      td = document.createElement('td');
      td.innerText = ex.done+' (из '+ex.total+' дней)';
      tr.append(td);
      td = document.createElement('td');
      td.innerText = ex.pledge+(ex.pledge==ex.value?'': '/'+ex.value);
      tr.append(td);

// TODO таблица сегодня/вчера/позавчера и т.д.
    }
  }
}
// TODO что делаем? (что не делаем) общее, т.з. по окну

// TODO модольное окно