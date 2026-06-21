<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Raja - Akses Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 p-4">
                    <div class="text-center mb-4">
                        <a href="/" class="h3 fw-bold text-decoration-none text-primary">Silsilah Raja</a>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>