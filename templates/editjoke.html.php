<form action="" method="post">
    <div class="form-container">
        <input type="hidden" name="jokeid" value="<?php echo $joke['id'] ?>">
        <label for="joketext">Edit your joke here:</label>
        <textarea name="joketext" id="joketext" cols="30" rows="10"><?php echo $joke['joketext'] ?></textarea>
        <input type="submit" name="submit" value="Save">
    </div>
</form>