<?php

$container_guid = get_input('guid');
$usuario = elgg_get_usuario_byId($container_guid);
$grupo_asesores = elgg_get_grupo_de_asesores();


if (check_entity_relationship($usuario->guid, 'membership_request', $grupo_asesores->guid)) {
	remove_entity_relationship($usuario->guid, 'membership_request', $grupo_asesores->guid);

}
if(add_entity_relationship($usuario->guid, "asesor", $grupo_asesores->guid)){
    system_message(elgg_echo("asesor:aceptar:ok"), 'success');
}  else {
    register_error(elgg_echo("asesor:aceptar:fail"));
}

forward(REFERER);
