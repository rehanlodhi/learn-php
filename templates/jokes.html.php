<p><?php echo $totalJokes ?> jokes have been submitted to the internet Joke Database</p>
<ul class="joke-list">
    <?php foreach ($jokes as $joke): ?>
        <li>
            <div class="joke-body">
                <p><?php echo htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8') ?> (<a href="mailto:<?php echo $joke['email'] ?>"><?php echo $joke['name'] ?></a>)</p>
                <a href="editjoke.php?id=<?php echo $joke['id'] ?>">Edit</a>
                <form action="deletejoke.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $joke['id'] ?>">
                    <input type="submit" value="Delete">
                </form>
            </div>
            <div class="joke-footer">

            </div>
        </li>

    <?php endforeach; ?>
</ul>
