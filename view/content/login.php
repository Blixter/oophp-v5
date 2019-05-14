<?php
namespace Anax\View;

/**
 * Template file to render a view for the login.
 */

?>

<form method="post">
    <fieldset>
    <legend>Logga in och få tillgång till fler funktioner</legend>
    <p><label>Användarnamn:<br><input type="text" name="username"></label></p>
    <p><label>Lösenord:<br><input type="password" name="password" required></p>
    <?= $message ?>
    <p><input type="submit" name="login" value="Logga in"><br><br>
    </p>
    </fieldset>
</form>
