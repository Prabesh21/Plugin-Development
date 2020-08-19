<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  
}

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
</style>
</head>
<body>

<form method="POST">
<?php wp_nonce_field( 'create_user_form_submit', 'djie3duhb3edub3u' ); ?>
  <div class="container">
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter username" name="username" id="username" required>  

    <label for="displayname"><b>Display Name</b></label>
    <input type="text" placeholder="Enter display name" name="displayname" id="displayname" required>

    <label for="firstname"><b>First Name</b></label>
    <input type="text" placeholder="Enter firstname" name="firstname" id="firstname" required>

    <label for="lastname"><b>Last Name</b></label>
    <input type="text" placeholder="Enter lastname" name="lastname" id="lastname" required>

    <label for="role">Choose a Role:</label>

<select name="role" id="role">
  <option value="subscriber">Subscirber</option>
  <option value="editor">Editor</option>
  <option value="administrator">Administrator</option>
</select>
    <hr>
    <button type="submit" name="my_submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="https://basic.pm/wp-admin">Sign in</a>.</p>
  </div>
</form>

</body>
</html>