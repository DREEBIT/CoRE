<?php


//$GLOBALS['TL_DCA']['tl_user']['palettes']['__selector__'][] = 'core_notifications';
$GLOBALS['TL_DCA']['tl_user']['palettes']['login'] = $GLOBALS['TL_DCA']['tl_user']['palettes']['login'].';{CoRE},core_notifications,core_notification_interval';
$GLOBALS['TL_DCA']['tl_user']['palettes']['group'] = $GLOBALS['TL_DCA']['tl_user']['palettes']['group'].';{CoRE},core_notifications,core_notification_interval';

/*if (!isset($GLOBALS['TL_DCA']['tl_user']['subpalettes'])) $GLOBALS['TL_DCA']['tl_user']['subpalettes'] = array();
array_insert($GLOBALS['TL_DCA']['tl_user']['subpalettes'], 1, array (
    'core_notifications' => 'core_notification_interval'
));
*/
$GLOBALS['TL_DCA']['tl_user']['fields']['core_notifications'] = array
(
    'label'					=> &$GLOBALS['TL_LANG']['tl_user']['core_notifications'],
    'exclude'				=> true,
    'inputType'				=> 'checkbox',
//    'eval'					=> array('submitOnChange'=>true),
    'sql'					=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['core_notification_interval'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['core_notification_interval'],
    'inputType' => 'text',
    'sql'       => "int(3) unsigned NULL"
);



//echo '<pre>';
//var_dump($GLOBALS['TL_DCA']['tl_user']);
//die;