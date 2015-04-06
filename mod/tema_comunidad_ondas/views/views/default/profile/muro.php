<?php

/**
 * Ohyes Theme
 * @website Link: https://github.com/lianglee/OhYesTheme
 * @Package Ohyes
 * @subpackage Theme
 * @author Liang Lee
 * @copyright All right reserved Liang Lee 2014.
 * @ide The Code is Generated by Liang Lee php IDE.
 */
elgg_load_js('ver_mas');
elgg_load_js('autoresize');
elgg_load_js("ajax_comentarios");
$user = elgg_get_page_owner_entity();
$icon = elgg_view('ohyes/theme/profile_icon', array(
    'user' => $user,
    'image_size' => 'large',
    'hover' => false,
    'pic_class' => 'ohyes-profile-picture'
        ));

$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
    $text = elgg_echo('admin:options');

    $admin_links .= '<ul class="ohyes-admin-menu">';
    foreach ($admin as $menu_item) {
        $admin_links .= elgg_view('navigation/menu/elements/item', array(
            'item' => $menu_item
        ));
    }
    $admin_links .= '</ul>';
}
$content_menu = elgg_view_menu('owner_block', array(
    'entity' => elgg_get_page_owner_entity(),
        ));

$query = array(
    'annotation_name' => 'messageboard',
    'guid' => $user->guid,
    'limit' => 12,
    'offset' => 0,
    'wheres' => " n_table.entity_guid=$user->guid",
    'reverse_order_by' => true,
);

$messageboard = elgg_get_messageboard_grupo_investigacion($query, true);
$profile_menu = elgg_view_menu('ohyes/profile');
$options['subject_guid'] = elgg_get_page_owner_guid();
$river_profile = elgg_list_river($options);
$profile_details = elgg_view('profile/details');
//$mensaje = elgg_view_form('messageboard/add', array('guid'=> $user->guid,));
//$mensaje = elgg_view('profile/estado',array('owner'=> $user,));
$mensaje = "";
if (elgg_is_logged_in()) {
    $mensaje = elgg_view("profile/estado", array('owner' => $user));
}

$profile = <<<HTML

            $mensaje
                
        <div id="message-board-body">
            $messageboard
        </div>

    </div>
    

</div>
HTML;
?>
<script>

//<![CDATA[
    $(document).ready(function() {
        $('textarea.txt-comment').autoResize({
// Al redimensionar
            onResize: function() {
                $(this).css({opacity: 0.8});
            },
// Llamar efecto despues de redimensionar:
            animateCallback: function() {
                $(this).css({opacity: 1});
                $(this).css({'background-color': '#A39565'});
            },
// Diración de la animación:
            animateDuration: 300,
// Limite en pixeles hasta los que se va a expandir
// pasado el límite genera el scroll tradicional, valor por defecto 1000px
            limit: 300,
// Espacio Extra al final del texto:
            extraSpace: 0
        });

// reseteamos el textarea
        
    });
//]]></script>
<?php

echo $profile;