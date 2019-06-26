<head>
    <link rel="stylesheet" type="text/css" href="css/custom/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

<!--Fontawesome CDN-->
<link rel="stylesheet" href="css/bootstrap-social.css">
<!--Custom styles-->
<link rel="stylesheet" href="css/fontawesome.css">
</head>

<body class="text-center">
    <div class="body">
    <form class="form-signin">

        <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
        <a class="btn btn-block btn-social btn-google">
        <i class="fab fa-google"></i>

            Sign in with Google
        </a>
        <a class="btn btn-block btn-social btn-facebook">
        <i class="fab fa-facebook-f"></i>
            Sign in with Facebook
        </a>
        <p class="divider-text">
            <span class="bg-light">OR</span>
        </p>
        <label for="inputName" class="sr-only">Ho ten</label>
        <input type="text" id="inputName" class="form-control" placeholder="Ho va ten" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required >
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        <hr>
        <span>Da co tai khoan? <a href="">Dang nhap</span>   
    </form>
       
    </div>
</body>
