<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title>
    <?= $page_title; ?>
</title>

<link href="./views/style.css" rel="stylesheet" type="text/css" />

<script src="./views/activation.js" type="text/javascript">
</script>

</head>

<?php $active = (isset($_GET['content'])) ? ($_GET['content']) : 0; ?>


<body>

<div class="background">

<img src="./views/back.bmp" id="background_image" alt="" />

<div class="wrapper">

<div class="header">

<div class="heading">
<br />
<br />
<h2>
    Prakhar Banga
</h2>
<br />
<br />
<h3>
    Department of Computer Science and Engineering,
    <br />
    IIT Kanpur
</h3>
</div>

<img id="header_image" src="./views/header.jpg" alt="" />

</div>

<div class="toc_div">

<ul id="toc">

<?php $i=0; ?>
<?php foreach($tabs as $item) : ?>

<li>

<a class="title <?php if($i!=$active) echo "in"; ?>active" id="title:<?= $i; ?>" href="?content=<?= $i; ?>" onclick="return activateOne('<?= $i; ?>');">
    <?= $item['title']; ?>

</a>

</li>

<?php $i++; ?>
<?php endforeach; ?>

</ul>

</div>

<?php $i=0; ?>
<?php foreach($tabs as $item): ?>

<div class="content <?php if($i!=$active) echo "in"; ?>active" id="content:<?= $i; ?>">

<div class="inner_content">

<?php $item['content']->set_variable('current_page', '?content=' . $i); ?>
<?= $item['content']->render(); ?>

</div>

<img class="content_bg" src="./views/content.bmp" alt="" />

</div>

<?php $i++; ?>
<?php endforeach; ?>

</div>

</div>

</body>

</html>
