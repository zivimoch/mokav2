<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
  }
  .container {
    max-width: 400px;
    margin: 100px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .container h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  .container input[type="email"],
  .container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
  }
  .container button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }
  @media (max-width: 480px) {
    .container {
      margin-top: 50px;
    }
  }
    </style>
  </head>
  <div class="container">
    <h1>SIMAK</h1> 
    <center>Sign in to start your session</center>
    <br>
    @if ($errors->any())
        <div style="padding: 10px; background-color:red; font-weight:bold; color:white">
            Email atau password yang anda masukan salah! Silahkan hubungi admin.
        </div>
        <br>
        @endif
        <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required> 
        <input type="password" name="password" placeholder="Password" required> 
        <button type="submit">Sign in</button>
   </form> 
</div>