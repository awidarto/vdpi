<html>
<head>
    <title>Login Form</title>
</head>
<body>
    <h1> Login </h1>
    <? if (@$error): ?>
        <h3 style="color:red"><?= $error ?></h3>
    <? endif; ?>
    <?= form_open() ?>
    
    <label for="email">Email:</label><input type="text" name="identity" value="" id="email">
    <label for="password">Password:</label><input type="password" name="password" value="" id="password">
    <input type="submit" name="submit" value="Login" id="submit">
    
    <?= form_close() ?>
</body>
</html>