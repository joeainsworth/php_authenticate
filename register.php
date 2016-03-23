<?php
require_once 'core/init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required'  => true,
                'min'       => 2,
                'max'       => 20,
                'unique'    => 'users'
            ),
            'password' => array(
                'required'  => true,
                'min'       => 6,
            ),
            'password_again' => array(
                'required'  => true,
                'matches'   => 'password'
            ),
            'name' => array(
                'required'  => true,
                'min'       => 2,
                'max'       => 50
            ),
        ));
        
        if($validation->passed()) {
            $user = new User();
            $salt = Hash::salt(32);
            try {
                $user->create([
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt'     => $salt,
                    'name'     => Input::get('name'),
                    'created'   => date('Y-m-d H:i:s'),
                    'groupNumber'    => 1,
                ]);
                
                Session::flash('home', 'You have been registered and can now login!');
                Redirect::to('index.php');
                
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            echo "<ul>";
            foreach($validation->errors() as $error) {
                echo "<li>{$error}</li>";
            }
            echo "</ul>";
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
    </div>
    
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password">
    </div>
    
    <div class="field">
        <label for="password_again">Confirm password</label>
        <input type="password" name="password_again" id="password_again" placeholder="Password">
    </div>
    
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Your name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>