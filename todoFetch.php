<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'connect.php';
// TODO Adapt tokenCheck

$user_id = 47;
$query = "
(SELECT 
	`executions`.`id`, 
	`executions`.`is_done`, 
	`payment`, 
	`quest_id`, 
	`executions`.`date`, 
	`executions`.`act_id`, 
	`activity`, 
	`ex_total`, 
	`ex_left`, 
	`value`, 
	`fora`, 
	`quests`.`is_done` AS `q_is_done` 
FROM 
	`executions` 
	LEFT JOIN `activities` ON `activities`.`id` = `act_id` 
	LEFT JOIN `quests` ON `quest_id` = `quests`.`id` 
WHERE 
	`executions`.`user_id` = $user_id
	AND `date` = CURRENT_DATE())
UNION 
(SELECT 
	`executions`.`id`, 
	`executions`.`is_done`, 
	`payment`, 
	`quest_id`, 
	`executions`.`date`, 
	`executions`.`act_id`, 
	`activity`, 
	`ex_total`, 
	`ex_left`, 
	`value`, 
	`fora`, 
	`quests`.`is_done` AS `q_is_done` 
FROM 
	`executions` 
	LEFT JOIN `activities` ON `activities`.`id` = `act_id` 
	LEFT JOIN `quests` ON `quest_id` = `quests`.`id` 
WHERE 
	`executions`.`user_id` = $user_id 
	AND `date` < CURRENT_DATE() 
	ANd `executions`.`is_done` IS NULL)
    ORDER BY `date`
";
$result = mysqli_query($db, $query) or exit ('query failed');
while ($row = mysqli_fetch_row($result)) $data[] = $row;


echo json_encode($data);

?>