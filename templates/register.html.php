<?php if (!empty($errors)): ?>
    <div class="errors">
        <p>Your account cannot be created, please check the following errors</p>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="" method="POST">
    <label for="name">Name</label>
    <input type="text" name="author[name]" id="name" value="<?php echo $author['name'] ?? '' ?>">

    <label for="email">Email</label>
    <input type="text" name="author[email]" id="email" value="<?php echo $author['email'] ?? '' ?>">

    <label for="password">Password</label>
    <input type="password" name="author[password]" id="password" value="<?php echo $author['password'] ?? '' ?>">

    <input type="submit" name="submit" value="Register">
</form>