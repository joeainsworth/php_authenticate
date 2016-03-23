<?php
require_once 'core/init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true
            ],
            'password' => [
                'required' => true
            ]
        ]);
    }
    
    if($validation->passed()) {
        $user = new User();
        $login = $user->login(Input::get('username'), Input::get('password'));
        
        if($login) {
            echo 'Success';
        } else {
            echo '<p>Sorry, logging in failed.</p>';
        }
    } else {
        echo '<ul>';
        foreach($validation->errors() as $error) {
            echo "<li>{$error}</li>";
        }
        echo '</ul>';
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
    </div>
    
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>