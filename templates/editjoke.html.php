<form action="" method="POST">
    <div class="form-container">
        <input type="hidden" name="joke[id]" value="<?php echo $joke['id'] ?? ''?>">
        <label for="joketext"><?php echo (empty($joke['id'])? 'Submit': 'Edit' ) ?> your joke here:</label>
        <textarea name="joke[joketext]" id="joketext" cols="30" rows="10"><?php echo $joke['joketext'] ?? '' ?></textarea>
        <input type="submit" name="submit" value="Save">
    </div>
</form>
