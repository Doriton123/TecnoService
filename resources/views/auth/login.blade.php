<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | TecnoService</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #081729;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: #126bc0;
            filter: blur(180px);
            opacity: 0.20;
            top: -180px;
            right: -150px;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 450px;
            height: 450px;
            background: #00bcd4;
            filter: blur(180px);
            opacity: 0.12;
            bottom: -200px;
            left: -150px;
            pointer-events: none;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: aparecer 0.7s ease;
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 78px;
            height: 78px;
            margin: 0 auto 15px;
            border-radius: 20px;
            background: linear-gradient(135deg, #1565c0, #00bcd4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 12px 35px rgba(0, 188, 212, 0.20);
        }

        .brand h1 {
            font-size: 32px;
            font-weight: 750;
            letter-spacing: -1px;
        }

        .brand h1 span {
            color: #39c9f4;
        }

        .brand p {
            color: #91a9c4;
            margin-top: 8px;
            font-size: 13px;
        }

        .login-card {
            background: rgba(17, 36, 60, 0.96);
            border: 1px solid #29435f;
            border-radius: 22px;
            padding: 35px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
        }

        .login-card h2 {
            font-size: 23px;
            text-align: center;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #9eb2ca;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 9px;
            color: #e1eaf5;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            background: #1b314c;
            border: 1px solid #35506d;
            border-radius: 11px;
            padding: 15px 45px 15px 16px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .input-wrapper input::placeholder {
            color: #829ab4;
        }

        .input-wrapper input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.12);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8da7c4;
            pointer-events: none;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #9cb4cd;
            cursor: pointer;
            padding: 5px;
            font-size: 12px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #b2c4d8;
            font-size: 13px;
            margin-bottom: 25px;
        }

        .remember input {
            accent-color: #159be8;
            width: 16px;
            height: 16px;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 11px;
            color: white;
            background: linear-gradient(135deg, #1565c0, #009cda);
            font-size: 15px;
            font-weight: 650;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 156, 218, 0.25);
        }

        .security-text {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #29435f;
            text-align: center;
            color: #91a9c4;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            color: #7893b1;
            font-size: 12px;
            margin-top: 25px;
        }

        .error-box {
            background: rgba(239, 68, 68, 0.12);
            color: #ffb4b4;
            border: 1px solid rgba(239, 68, 68, 0.35);
            border-radius: 9px;
            padding: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .status-box {
            background: rgba(34, 197, 94, 0.12);
            color: #a7f3d0;
            border: 1px solid rgba(34, 197, 94, 0.35);
            border-radius: 9px;
            padding: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        @keyframes aparecer {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 25px 20px;
            }

            .brand h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="brand">
            <div class="brand-icon">🖥️</div>

            <h1>Tecno<span>Service</span></h1>

            <p>Sistema de Gestión de Servicios Técnicos</p>
        </div>

        <div class="login-card">

            <h2>¡Bienvenido de nuevo!</h2>

            <p class="subtitle">
                Ingresa tus credenciales para continuar
            </p>

            @if(session('status'))
                <div class="status-box">
                    {{ session('status') }}
                </div>
            @endif


            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>
                            @if(
                                    $error === 'auth.failed' ||
                                    $error === 'These credentials do not match our records.'
                                )
                                El correo electrónico o la contraseña son incorrectos.
                            @elseif(
                                    str_contains($error, 'Too many login attempts') ||
                                    $error === 'auth.throttle'
                                )
                                Demasiados intentos de inicio de sesión.
                                Inténtalo nuevamente más tarde.
                            @else
                                {{ $error }}
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif


            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>

                    <div class="input-wrapper">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="Ingresa tu correo electrónico" autocomplete="username" required autofocus>

                        <span class="input-icon">✉</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>

                    <div class="input-wrapper">
                        <input id="password" type="password" name="password" placeholder="Ingresa tu contraseña"
                            autocomplete="current-password" required>

                        <button type="button" class="toggle-password" onclick="mostrarPassword()" id="togglePassword"
                            aria-label="Mostrar contraseña">
                            Mostrar
                        </button>
                    </div>
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember">
                    Mantener sesión iniciada
                </label>

                <button type="submit" class="login-button">
                    Iniciar sesión
                </button>
            </form>

            <div class="security-text">
                🔒 Acceso exclusivo para personal autorizado
            </div>

        </div>

        <div class="footer">
            © {{ date('Y') }} TecnoService.
            Todos los derechos reservados.
        </div>

    </div>

    <script>
        function mostrarPassword() {
            const input = document.getElementById('password');
            const boton = document.getElementById('togglePassword');

            if (input.type === 'password') {
                input.type = 'text';
                boton.textContent = 'Ocultar';
                boton.setAttribute('aria-label', 'Ocultar contraseña');
            } else {
                input.type = 'password';
                boton.textContent = 'Mostrar';
                boton.setAttribute('aria-label', 'Mostrar contraseña');
            }
        }
    </script>

</body>

</html>