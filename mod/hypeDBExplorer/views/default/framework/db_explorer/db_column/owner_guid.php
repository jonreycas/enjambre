<?php

$data = elgg_extract('data', $vars);
$value = $data->owner_guid;

echo elgg_view('framework/db_explorer/template/guid', array(
	'value' => $value
));
