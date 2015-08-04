<?php

/* EXCEL CONFIG */

$EXCEL[0]['startrow'] = 2;
$EXCEL[0]['startcolumn'] = 1;
$EXCEL[0]['startindex'] = 0;
$EXCEL[0]['filetype'] = array('application/ms-excel', 'application/vnd.ms-excel','application/octet-stream','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

/* SMARTY CONFIG */

$SMARTY[0]['template'] = APPPATH.'view/';
$SMARTY[0]['cache'] = LIBS.'smarty/cache';
$SMARTY[0]['config'] = LIBS.'smarty/configs';
$SMARTY[0]['logs'] = CACHE;

?>