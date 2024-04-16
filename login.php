<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="vh-100">
    <main class="h-100 d-flex justify-content-center align-items-center">
        <div class="login p-4 rounded shadow">
            <h1 class="text-center mb-4">Login</h1>

              <form action="./auth.php" method="post" id="formLogin">
                <div class="mb-3 lg-2">
                  <label for="exampleInputEmail1" class="form-label">Username</label>
                  <input type="text" class="form-control" name="username">
                </div>

                <div class="mb-3 lg-2">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcfI54pAAAAAAQsp0Y9UcaCS18c-lERTvgSlOOK"></script>

    <script>
      $('#formLogin').submit(function (event) {
        event.preventDefault();

        grecaptcha.ready(function() {
          grecaptcha.execute('6LcfI54pAAAAAAQsp0Y9UcaCS18c-lERTvgSlOOK', { action: 'login' } ).then(function (token) {  
            

                $.ajax({
                  url: './auth.php',
                  type: 'post',
                  data: {
                    username: $('input[name="username"]').val(),
                    password: $('input[name="password"]').val(),
                    token: token
                    },
                    success: function (response) {
                      if(response == '1'){
                        window.location.href = './homepage.php';
                      } else {
                        alert(response);
                      }
                    }
                });
            });
          });
        });
      
    </script>

</body>

</html>