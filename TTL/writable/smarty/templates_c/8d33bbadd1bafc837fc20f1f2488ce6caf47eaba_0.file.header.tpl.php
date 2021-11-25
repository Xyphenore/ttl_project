<?php
/* Smarty version 3.1.40, created on 2021-11-25 01:50:23
  from '/home/suzy/proj_suzy/ttl_project/TTL/app/Views/templates/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_619f403f5d1652_92888780',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8d33bbadd1bafc837fc20f1f2488ce6caf47eaba' => 
    array (
      0 => '/home/suzy/proj_suzy/ttl_project/TTL/app/Views/templates/header.tpl',
      1 => 1637825840,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_619f403f5d1652_92888780 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html>
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['Name']->value;?>
</title>
</head>
<body bgcolor="#ffffff">

    <!--<h1><?php echo '<?php'; ?>
 esc({$title}) <?php echo '?>'; ?>
</h1>-->
    <h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1>
<?php }
}
