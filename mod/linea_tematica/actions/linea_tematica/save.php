<?php

/**
 * Action que crea o actualiza un grupo nuevo
 */

elgg_make_sticky_form('groups');

/**
 * wrapper for recursive array walk decoding
 */
function profile_array_decoder(&$v) {
	$v = _elgg_html_decode($v);
}


$name = htmlspecialchars(get_input('name', '', false), ENT_QUOTES, 'UTF-8');
$description = get_input('description');
$user = elgg_get_logged_in_user_entity();

$group_guid = (int)get_input('group_guid');
$is_new_group = $group_guid == 0;


$group = new ElggRedTematica($group_guid); // load if present, if not create a new group


$existe_name= elgg_existe_red($name);
// Assume we can edit or this is a new group

if ($is_new_group && !$existe_name) {

    $group->name = $name;
    $group->access_id = ACCESS_PUBLIC;
    $group->owner_guid = $user->guid;
    $group->container_guid = $user->guid;
    
} 
else if (!$is_new_group && $name != $group->name) {
    
    $group->name=$name;
}


else if($is_new_group&& $existe_name){
    register_error(elgg_echo("Ya existe una Red Temática con ese nombre"));
    forward(REFERER);
}


$group->description = $description;



if ($is_new_group) {
	$group->access_id = ACCESS_PUBLIC;
}

$guid_red_tematica=$group->save();


// group creator needs to be member of new group and river entry created
if ($is_new_group) {

        $user->addRelationship($group->guid, "administrador");
	add_to_river('river/group/create', 'create', $user->guid, $group->guid, $group->access_id);
}



 $mimeR = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
	# Buscamos si el archivo que subimos tiene el MIME type que permitimos en nuestra subida
	if( !in_array( $_FILES['icon']['type'], $mimeR )&& !empty($_FILES['icon']['type']) )
	{
            register_error("Para el Ícono de la Red, el archivo seleccionado debe ser una Imagen ");
             forward(REFERER);
	}
        

$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));


if ($has_uploaded_icon) {

	$icon_sizes = elgg_get_config('icon_sizes');

	$prefix = "redes_tematicas/" . $group->guid;

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $group->owner_guid;
	$filehandler->setFilename($prefix . ".jpg");
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('icon'));
	$filehandler->close();
	$filename = $filehandler->getFilenameOnFilestore();
         

	$sizes = array('tiny', 'small', 'medium', 'large');

	$thumbs = array();
	foreach ($sizes as $size) {
		$thumbs[$size] = get_resized_image_from_existing_file(
			$filename,
			$icon_sizes[$size]['w'],
			$icon_sizes[$size]['h'],
			$icon_sizes[$size]['square']
		);
                   
                
	}
       

	if ($thumbs['tiny']) { // just checking if resize successful
            
              
		$thumb = new ElggFile();
              
		$thumb->owner_guid = $group->owner_guid;
             
		$thumb->setMimeType('image/jpeg');
              

		foreach ($sizes as $size) {
             
			$thumb->setFilename("{$prefix}{$size}.jpg");		
                        $thumb->open("write");
			$thumb->write($thumbs[$size]);
			$thumb->close();
		}

		$group->icontime = time();
              
               
	}
        
        
     
        
        
}


system_message(elgg_echo("Red temática Guardada"));

forward("/redes_tematicas/ver/".$group->guid);

