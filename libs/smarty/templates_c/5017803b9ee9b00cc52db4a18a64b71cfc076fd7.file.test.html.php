<?php /* Smarty version Smarty-3.1.15, created on 2014-01-07 11:14:12
         compiled from "test.html" */ ?>
<?php /*%%SmartyHeaderCode:827652cbd303cc9f26-15075380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5017803b9ee9b00cc52db4a18a64b71cfc076fd7' => 
    array (
      0 => 'test.html',
      1 => 1389089649,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '827652cbd303cc9f26-15075380',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52cbd303d966a5_47789624',
  'variables' => 
  array (
    'name' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52cbd303d966a5_47789624')) {function content_52cbd303d966a5_47789624($_smarty_tpl) {?><html>
  <head>
    <title>Smarty</title>
  </head>
  <body>
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['name']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
		<?php echo $_smarty_tpl->tpl_vars['val']->value;?>

	<?php } ?>
  </body>
</html><?php }} ?>
