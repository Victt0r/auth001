<!-- ОТОБРАЖАЕТ ВСЕ ОСТАВШИЕСЯ НЕСДЕЛАННЫМИ ВЫПОЛНЕНИЯ НА СЕГОДНЯ -->

<br> 

<?php

  require_once $_SERVER['DOCUMENT_ROOT'].'init.php';
  $user_id= $_GET['user_id'];   // ID активного пользователя
  
  // определяет стили ?>
  <style>
    body {font-family: Arial, Helvetica, sans-serif;}
    table {
      border-collapse: collapse;
      margin: auto;
    }
    th:first-child, td:first-child {
        max-width: 270px;
    }
    td {
      border: 1px solid #dddddd;
      text-align: center;
      padding: 8px;
    }
    th {
      border: 1px solid #ffffff;
      background-color: #dddddd;
      padding: 8px;
    }
    .but:hover { background: lightgrey }
  </style> <?php

  // если выбран конкретный пользователь, показывает только его выполнения на сегодня
  if ($user_id) {
    
    $query = "	
      SELECT `se` 
      FROM `users` 
      WHERE `id`=$user_id
    ";
    $result = mysql_query($query) or exit("SELECT `se` Query failed");
    list($se) = mysql_fetch_row($result);

    echo ("
      <div style=text-align:center><b>$se</b> &nbsp ВВС не задействовано, можешь выбрать &nbsp <a href='activities.php?user_id=$user_id'> Действия для новых Квестов </a></div> <br>
      <div style=text-align:center>Отчитайся за сегодня в таблице ниже, а если не успел(а) раньше, можешь &nbsp <a href='yesterdo.php?user_id=$user_id'> Отчитаться за вчера </a></div> <br> <br>
    ");  
    
    // выводит шапку таблицы ?>
    <table>
      <tr>
        <th> Действие </th>
        <th> позади    </th>
        <th> осталось </th>
        <th> ВО        </th>
        <th> Провал?  </th>
        <th> Сделано? </th>
        <th> залог    </th>
        <th> награда  </th>
      </tr> <?php
    
    // берёт из базы данные по всем актуальным выполнениям и их квестам
    $query = "
      SELECT 
        `executions`.`id`, 
        `payment`, 
        `quest_id`, 
        `executions`.`act_id`, 
        `activity`, 
        `ex_total`, 
        `ex_left`, 
        `value`, 
        `fora`,
        `quests`.`is_done`,
        `counts_as`,
        `pattern_id`
      FROM 
        `executions` 
        LEFT JOIN `activities` ON `activities`.`id` = `act_id` 
        LEFT JOIN `quests` ON `quest_id` = `quests`.`id`
      WHERE 
        `executions`.`user_id` = $user_id 
        AND `date` = CURRENT_DATE() 
        AND `executions`.`is_done` IS NULL
      ORDER BY
        `payment` DESC
    ";
    $result = mysql_query($query) or exit("Query failed");
    
    // заполняет переменные и создаёт всё необходимое для каждой полученной записи
    while (list(
      $ex_id,       // ID текущего выполнения
      $payment,     // верообразование с него
      $quest_id,    // ID выбранного квеста
      $act_id,      // ID соответствующего действия
      $activity,    // что это за действие
      $ex_total,    // всего выполнений в квесте
      $ex_left,     // из них осталось несделанных
      $value,       // цена квеста
      $fora,        // фора в днях
      $quest_done,  // завершён ли уже данный квест
      $counts_as,   // номер выполнения по порядку роста верообразования
      $pattern_id,  // ID схемы-графика выполнений выбранного действия
    ) = mysql_fetch_row($result) ) {
      $ex_done = $ex_total-$ex_left;  // сколько выполнений уже сделано
      $diff = $value/$ex_total;       // сложность действия
      $pledge = $value - $diff*$fora; // залог, внесённый при взятии квеста
      
      // если квест закончен, не показывать залог и награду
      if ($quest_done) {$value=""; $pledge="";}
      
      // склонения день, дня, дней, соответствующие цифрам
      if (10<$ex_done and $ex_done<20) {$done_days="дней";}
      elseif (-20<$ex_done and $ex_done<-10) {$done_days="дней";}
      else {
        $done_days = $ex_done%10;
        if ($done_days==1) {$done_days="день";}
        elseif (1<$done_days and $done_days<5) {$done_days="дня";}
        else {$done_days="дней";}
      }
      if (10<$ex_left and $ex_left<20) {$left_days="дней";}
      elseif (-20<$ex_left and $ex_left<-10) {$left_days="дней";}
      else {
        $left_days = $ex_left%10;
        if ($left_days==1) {$left_days="день";}
        elseif (1<$left_days and $left_days<5) {$left_days="дня";}
        else {$left_days="дней";}
      }
      
      // выводит текущее действие для квеста в строку таблицы
      echo("
      <tr>
        <td> $activity        </td>
        <td> $ex_done $done_days </td>
        <td> $ex_left $left_days </td>
        <td> $payment        </td>
        <td class=but onclick=".'"func('."
          $user_id,
          $ex_id,
          $quest_id,
          $act_id,
          $payment,
          $counts_as,
          $pattern_id,
          '$activity',
          0".'
        )"'." style=cursor:pointer> увы &nbsp  (⌣̩̩́_⌣̩̩̀) </td>
        <td class=but onclick=".'"func('."
          $user_id,
          $ex_id,
          $quest_id,
          $act_id,
          $payment,
          $counts_as,
          $pattern_id,
          '$activity',
          1".'
        )"'." style=cursor:pointer> ДА! &nbsp  \(◦'⌣'◦)/ </td>
        <td> $pledge </td>
        <td> $value  </td>
      </tr>");
    }
    
    // закрывает таблицу и даёт ссылку на список действий для квестов
    echo ("
      </table> <br> <br>
      <div style=text-align:center><b>$se</b> &nbsp ВВС не задействовано, можешь выбрать &nbsp <a href='activities.php?user_id=$user_id'> Действия для новых Квестов </a></div> <br>
      <div style=text-align:center>В крайнем случае, можешь &nbsp <a href='yesterdo.php?user_id=$user_id'> Отчитаться за вчерашние </a></div> <br>
      <div style=text-align:center>Посмотреть &nbsp <a href='chronicle.php?user_id=$user_id'> Хронику прежних</a> &nbsp или &nbsp <a href='planned.php?user_id=$user_id'> Запланированные Квесты </a></div> <br>
    ");  
    
    // скрипт с функцией, передающей данные для принятия отчёта ?>
      <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'> </script>
      <script>
        // функция передачи запроса на отчёт о выполнении
        function func(
          user_id,
          ex_id,
          quest_id,
          act_id,
          payment,
          counts_as,
          pattern_id,
          activity,
          is_done
        ) {
          if (is_done) {confirmation='Что, правда, сделал? ('+activity+')'}
          else {confirmation='Провалил ('+activity+')? Серьёзно?'}
          if (confirm(confirmation)) {
            
            // формирует и отправляет запрос к подчинённому php-файлу
            $.get('todo_report.php'+
              '?user_id='+    user_id+
              '&ex_id='+      ex_id+
              '&quest_id='+   quest_id+
              '&act_id='+     act_id+
              '&payment='+    payment+
              '&counts_as='+  counts_as+
              '&pattern_id='+ pattern_id+
              '&is_done='+    is_done, 
            function(data) {
              alert(data);
              
              // возвращает на эту же страницу, обновляя информацию на ней
              document.location.href='todo.php?user_id='+user_id;
            } );
          } 
          else {
            if (is_done) {alert('Так сделай же! Ты можешь!')}
            else {alert('Пока не провалил, ещё можно успеть справиться!')}
          }
        }
      </script> 
      
      <script>
        var hour = (new Date()).getHours();
        setInterval(()=>{
          if (hour != (new Date()).getHours())
            window.location.replace('todo.php?user_id=<?php echo $user_id; ?>');
        }, 1000);
      </script>
      
      <?php
  } 
  
  // если пользователь не выбран, показывает задачи на сегодня всех пользователей
  elseif ($user_id==='0') {

    // выводит шапку таблицы ?>
    <table>
      <tr>
        <th> Герой    </th>
        <th> Действие </th>
        <th> позади   </th>
        <th> осталось </th>
        <th> ВО       </th>
        <th> залог    </th>
        <th> награда  </th>
      </tr> <?php
    
    // берёт из базы данные по всем актуальным выполнениям и их квестам
    $query = "
      SELECT 
        `executions`.`user_id`,
        `user_name`,
        `activity`, 
        `payment`, 
        `ex_total`, 
        `ex_left`, 
        `value`, 
        `fora`,
        `quests`.`is_done`
      FROM 
        `executions` 
        LEFT JOIN `activities` ON `activities`.`id` = `act_id` 
        LEFT JOIN `quests` ON `quest_id` = `quests`.`id` 
        LEFT JOIN `users` ON `executions`.`user_id` = `users`.`id`
      WHERE 
        `date` = CURRENT_DATE() 
        AND `executions`.`is_done` IS NULL
      ORDER BY
        `user_id` DESC";
    $result = mysql_query($query) or exit("Query failed");

    // заполняет переменные
    while (list(
      $user_ids,      // ID пользователей
      $user_name,     // их имена
      $activity,      // действие квеста
      $payment,       // верообразование с него
      $ex_total,      // всего выполнений в квесте
      $ex_left,       // из них осталось несделанных
      $value,         // цена квеста
      $fora,          // фора в днях
      $quest_done,    // провалил или выполнил
    ) = mysql_fetch_row($result) ){
      $ex_done = $ex_total-$ex_left;  // сколько выполнений уже сделано
      $diff = $value/$ex_total;       // сложность действия
      $pledge = $value - $diff*$fora; // залог, внесённый при взятии квеста
      
      // если квест закончен, не показывать залог и награду
      if ($quest_done) {$value=""; $pledge="";}
      
      // склонения день, дня, дней, соответствующие цифрам
      $done_days = $ex_done%10;
      if ($done_days==1) {$done_days="день";}
      elseif (1<$done_days and $done_days<5) {$done_days="дня";}
      else {$done_days="дней";}
      $left_days = abs($ex_left)%10;
      if ($left_days==1) {$left_days="день";}
      elseif (1<$left_days and $left_days<5) {$left_days="дня";}
      else {$left_days="дней";}
      
      // вывод текущего действия-квеста-выполнения в строку таблицы
      echo("
        <tr>
          <td> $user_name       </td>
          <td> $activity       </td>
          <td> $ex_done $done_days </td>
          <td> $ex_left $left_days </td>
          <td> $payment       </td>
          <td> $pledge       </td>
          <td> $value         </td>
        </tr>
      ");
    }
    // закрывает таблицу
    echo ("
      </table>
    ");  
  }
?>