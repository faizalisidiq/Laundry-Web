<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: #f2f6fc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-login {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h3 class="text-center mb-4 text-primary fw-bold">Login</h3>

        <form action="login" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="" selected disabled>Pilih role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Karyawan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-login w-100 mt-2">Login</button>

            <p class="text-center mt-3 mb-0 text-muted">
                Belum punya akun?
                <a href="" class="text-primary fw-semibold text-decoration-none">Daftar di sini</a>
            </p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
