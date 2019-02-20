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
	`executions`.`user_id` = 47 
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
	`executions`.`user_id` = 47 
	AND `date` < CURRENT_DATE() 
	ANd `executions`.`is_done` IS NULL)
    ORDER BY `date`