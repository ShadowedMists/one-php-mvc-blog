<h1>Update Password</h1>
<p class="error"><?php echo $model['error'];?></p>
<form method="post">
    <label for="password">Password</label>
    <input type="password" name="password" required />
    <label for="confirm">Confirm Password</label>
    <input type="password" name="confirm" required />
    <input type="submit" name="submit" value="Update Password" />
</form>