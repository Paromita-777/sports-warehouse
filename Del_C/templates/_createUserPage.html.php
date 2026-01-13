<h2>Create new user</h2>

<p>Create a new user in the database - password will be stored as a hash (not plaintext).</p>

<p><strong>NOTE:</strong> do NOT leave this accessible on a production website!</p>

<?php include "_error.html.php" ?>
<?php include "_success.html.php" ?>

<form action="createUser.php" method="post" novalidate>
  <fieldset>
    <div class="form-row">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" value="<?= setValue("username") ?>" required>
    </div>

    <div class="form-row">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" value="<?= setValue("password") ?>" required>
    </div>

    <div class="form-row">
      <button type="submit" name="submitCreateUser">Create new user</button>
    </div>
  </fieldset>
</form>