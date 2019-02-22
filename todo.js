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
      var tr = document.createElement('tr');
      //  checkBox
      var td = document.createElement('td');
      var input = document.createElement('input');
      table.append(tr);
      tr.append(td);
      td.append(input);
      input.setAttribute('type', 'checkbox');
      td = document.createElement('td');
      td.innerText = '+'+row[2];
      tr.append(td);
      td = document.createElement('td');
      td.innerText = row[6];
      tr.append(td);
      td = document.createElement('td');
      td.innerText = row[7]-row[8]+'(из '+row[7]+'дней)';
      tr.append(td);
      td = document.createElement('td');
      var pledge = row[9]/row[7]*(row[7]-row[10]);
      td.innerText = pledge+(pledge==row[9]?'': '/'+row[9]);
      tr.append(td);


    }
  }
}
