<h1>Login</h1>
<p class="error"><?php echo $model['error']; ?></p>
<form method="post">
    <label for="email">Email</label>
    <input type="email" name="email" required value="<?php echo $model['email']; ?>" />
    <label for="password">Password</label>
    <input type="password" name="password" required />
    <input type="submit" name="submit" value="Login" />
</form>