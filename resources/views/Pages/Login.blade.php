<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login </title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite('resources/js/app.js')
</head>
<body>
    <div class="min-vh-100 d-flex justify-content-center align-items-center py-3" 
         style="background: linear-gradient(to right, #0073dead, #ff000096), url('img/FONDOUCV.png') center/cover;">
        <div class="bg-white rounded-4 p-5 shadow" style="width: 400px;">
            <form class="text-center" id="loginForm" action="{{route('login.post')}}" method="post">
                @csrf
                <div class="mb-4">
                    <img src="img/ucv.png" alt="ucv" class="img-fluid" style="width: 170px;">
                </div>
                
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
                    <label for="username">Usuario</label>
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" id="btnLogin" 
                            class="btn btn-primary btn-lg text-uppercase rounded-pill">
                        Conectar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>