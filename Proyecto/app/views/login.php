<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Login</title>
        <style>
            html{
                height: 100%;
            }
        </style>
    </head>
    <body class="container h-100 d-flex justify-content-center align-items-center">
        <div class=" col-12 d-flex justify-content-center">
            <form action="" method="POST" class="col-4 rounded-4 shadow-lg p-5">
                <span style="color:red;"><?= $msgLogin ?></span>
                <h1>Iniciar sesión</h1>
                <div class="d-flex flex-column gap-4">
                    <div>
                        <label for="" class="form-label">Login</label>
                        <input type="text" class="form-control" name="login">
                    </div>
                    <div>
                        <label for="" class="form-label">Clave</label>
                        <input type="text" class="form-control" name="clave">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-5" name="comprobar" value="comprobar">
            </form>
        </div>
    </body>
</html>