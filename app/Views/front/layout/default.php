<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Babumoshai restora</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="<?php echo site_url(); ?>assets/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?= $this->include('front/layout/menu') ?>
         <?= $this->renderSection("content"); ?>
         <?= $this->include('front/layout/footer') ?>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/scripts.js"></script>
        <?= $this->renderSection("scripts"); ?>
     <body>
</html>