<h1>Protected View!!</h1>

<h4>Email: <?= $the_user->email ?></h4>

<a href="<?= site_url('user/logout') ?>">logout</a>

<pre>
    <?php
        print_r($the_user);
    ?>
</pre>