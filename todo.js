// TODO table building function
var url = `todoFetch.php`;
request('GET', url, handler, console.log);
function handler(response) {
  if (response.startsWith("[")) {
    response = JSON.parse(response);

    var today = new Date(),
      yyyy = today.getFullYear(),
      mm = today.getMonth() + 1,
      dd = (today.getDate() > 9 ? '' : '0') + today.getDate();
    mm = (mm > 9 ? '' : '0') + mm;
    today = yyyy + '-' + mm + '-' + dd + ' 00:00:00';

    function splitData(arr, str) {
      var arr1 = [], arr2 = [];
      for (var el of arr) {
        if (el[4] == str) arr1.push(el)
        else arr2.push(el)
      }
      return [arr1, arr2];
    }
    var [todayData, beforeData] = splitData(response, today);

    function splitBefore(arr) {
      obj = {};
      for (var el of arr) {
        const date = el[4];
        if (!obj[date]) obj[date] = [el]
        else obj[date].push(el)
      }
      return obj;
    }
    beforeData = splitBefore(beforeData);
    
    function buildTable(dayData) {
      var table = document.createElement('table');
      section.append(table);
      table.innerHTML = `<tr>
        <th></th>
        <th>ВВС</th>
        <th>действие</th>
        <th>сделано (всего)</th>
        <th>залог/награда</th>
      </tr>`
      function buildRow(row) {
        ex = {
          payment: row[2],
          activity: row[6],
          total: row[7],
          done: row[7] - row[8],
          left: row[8],
          value: row[9],
          fora: row[10],
          pledge: row[9] / row[7] * (row[7] - row[10]),
          date: row[4]
        }
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        var input = document.createElement('input');
        input.setAttribute('type', 'checkbox');
        input.onclick = reportButtons;
        // input.setAttribute('date-ex', JSON.stringify(ex));
        input.ex = ex;
        td.append(input);
        tr.append(td);
        td = document.createElement('td');
        td.innerText = '+' + ex.payment;
        tr.append(td);
        td = document.createElement('td');
        td.innerText = ex.activity;
        tr.append(td);
        td = document.createElement('td');
        td.innerText = ex.done + ' (из ' + ex.total + ' дней)';
        tr.append(td);
        td = document.createElement('td');
        td.innerText = ex.pledge + (ex.pledge == ex.value ? '' : '/' + ex.value);
        tr.append(td);
        table.append(tr);
      }
      dayData.forEach(buildRow);
    }
    const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
    for (var key in beforeData) {
      var h3 = document.createElement('h3');
      var date = new Date(key);
      h3.innerText = days[date.getDay()]+', '+date.getDate()+' '+
      months[date.getMonth()];
      section.append(h3);
      buildTable(beforeData[key]);
    }
    var h3 = document.createElement('h3');
    h3.innerText = 'Задачи на сегодня';
    section.append(h3);
    buildTable(todayData);
  }
}


// TODO setCookie('user_id', getCookie('user_id'), {expires:60*60*24*30});
// TODO setCookie('token', response.token, {expires:60*60*24*30});

// репорт баттон

// TODO что делаем? (что не делаем?) общее
