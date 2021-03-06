<?php

$ajax = get_input("ajax");
$relacion = get_input('relacion');
$guid_convocatoria = get_input('convocatoria');
$id_linea = get_input('linea');
$convocatoria = new ElggConvocatoria($guid_convocatoria);
$lineasAsociadas = elgg_get_relationship($convocatoria, "tiene_la_línea_temática");
$lineas_asociadas = Array();

if (!$ajax) {
    foreach ($lineasAsociadas as $linea) {
        $lin = array('id_linea' => $linea->guid, 'nombre_linea' => $linea->name);
        array_push($lineas_asociadas, $lin);
    }
    $listado_lineas = $lineas_asociadas;

    $option = array();

    foreach ($listado_lineas as $listado) {
        $option[$listado['id_linea']] = $listado['nombre_linea'];
    }

    $lineas_input = elgg_view('input/dropdown', array('name' => 'linea', 'id' => 'linea', 'class' => 'select', 'required' => 'true', 'options_values' => $option));
    $relacion_input = elgg_view('input/hidden', array('id' => 'relacion', 'value' => $relacion));
    echo "<div><label>Seleccione la Línea Temática:  </label>" . $lineas_input . "</div>"
    . "</div></div>" . $convocatoria_input . $relacion_input . "<br><div id='investigaciones'>";
    echo elgg_get_investigaciones_linea_convocatoria(15, 0, $guid_convocatoria, $listado_lineas[0]['id_linea'], $relacion);
    echo "</div>";
} else {
    echo elgg_get_investigaciones_linea_convocatoria(15,$offset, $guid_convocatoria, $id_linea, $relacion);
   
}