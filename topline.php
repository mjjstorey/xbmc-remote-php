<?php include "browserdetect.php"; ?>

<html>
<head>

<?php if ($iphone == '1'): ?>
<meta name="viewport" content="width=320" />
<link rel="stylesheet" href="css/safari-mobile.css" title="default" type="text/css">
<?php elseif ($iphone == '2'): ?>
<meta name="viewport" content="width=980" />
<link rel="stylesheet" href="css/safari-mobile.css" title="default" type="text/css">
<?php else: ?>
<meta name="viewport" content="width=1024" />
<link rel="stylesheet" href="css/desktop.css" title="default" type="text/css">
<?php endif; ?>

<title>XBMC Remote</title>
</head>
<body>
<div id="container">
<div id="header">

