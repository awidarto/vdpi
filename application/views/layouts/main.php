<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to CodeIgniter</title>
        <?php $this->tf_assets->render_css(); ?>
        <?php $this->tf_assets->render_js('top'); ?>
    </head>
    <body>

        <?php $this->tf_assets->render_partial('header'); ?>

        <?php $this->tf_assets->render_content(); ?>

        <?php $this->tf_assets->render_partial('footer'); ?>
    </body>
    <?php $this->tf_assets->render_js('bottom'); ?>
</html>