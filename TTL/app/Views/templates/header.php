<!doctype html>
<html>
<head>
    <title>CodeIgniter Tutorial</title>
</head>
<body>

    <h1><?php 
    // esc pour protéger des attaques XSS (Cross-site scripting)
    // injection de contenu malveillant dans une page web
    // http://codeigniter.com/user_guide/general/common_functions.html#esc
    esc($title) 
    ?></h1>