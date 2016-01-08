<?php

$module = '';
$output = null;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
	case xPDOTransport::ACTION_UPGRADE:

		$modules = array(
			'animate'   => 0,
			'buttons'   => 1,
			'callbacks' => 1,
			'confirm'   => 1,
			'desktop'   => 0,
			'history'   => 0,
			'mobile'    => 0,
			'nonblock'  => 0,
			'reference' => 0,
			'tooltip'   => 0
		);

		$module = '<ul id="formCheckboxes" style="height:200px;overflow:auto;">';
		foreach ($modules as $k => $v) {
			$checked = !empty($v) ? 'checked' : '';
			$module .= '
				<li>
					<label>
						<input type="checkbox" name="modules[]" value="' . $k . '"' . $checked . '> ' . $k . '
					</label>
				</li>';
		}
		$module .= '</ul>';

		break;

	case xPDOTransport::ACTION_UNINSTALL:
		break;
}

$output = '';

if ($module) {

	switch ($modx->getOption('manager_language')) {
		case 'ru':
			$output .= 'Выберите модули, которые необходимо <b>собрать</b>:<br/>
				<small>
					<a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = true;});">отметить все</a> |
					<a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = false;});">cнять отметки</a>
				</small>
			';
			break;
		default:
			$output .= 'Select modules, which need to <b>build</b>:<br/>
				<small>
					<a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = true;});">select all</a> |
					<a href="#" onclick="Ext.get(\'formCheckboxes\').select(\'input\').each(function(v) {v.dom.checked = false;});">deselect all</a>
				</small>
			';
	}

	$output .= $module;
}

return $output;