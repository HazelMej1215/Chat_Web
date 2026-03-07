<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp — Crear Cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #f0f4ff;
            --white: #ffffff;
            --blue: #4a6cf7;
            --blue-light: #eef2ff;
            --blue-mid: #c7d2fe;
            --text: #1e2340;
            --text2: #64748b;
            --muted: #94a3b8;
            --border: #e2e8f0;
            --error: #ef4444;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }

        .bg-shapes { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .shape {
            position: absolute; border-radius: 50%;
            background: linear-gradient(135deg, rgba(74,108,247,0.12), rgba(99,102,241,0.08));
            animation: floatShape 14s ease-in-out infinite;
        }
        .shape-1 { width: 450px; height: 450px; top: -180px; left: -120px; animation-delay: 0s; }
        .shape-2 { width: 320px; height: 320px; bottom: -100px; right: -80px; animation-delay: -5s; }

        @keyframes floatShape {
            0%, 100% { transform: translate(0,0) scale(1); }
            40% { transform: translate(15px,-20px) scale(1.04); }
            70% { transform: translate(-10px,12px) scale(0.97); }
        }

        .bg-dots {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: radial-gradient(circle, rgba(74,108,247,0.12) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .container {
            position: relative; z-index: 1;
            width: 100%; max-width: 460px; padding: 20px;
            animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            background: var(--white); border-radius: 24px;
            padding: 44px 40px 36px;
            box-shadow: 0 4px 6px rgba(74,108,247,0.04), 0 20px 60px rgba(74,108,247,0.12), 0 0 0 1px rgba(74,108,247,0.08);
        }

        .logo-section { text-align: center; margin-bottom: 32px; }
        .logo-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 18px;
            box-shadow: 0 8px 24px rgba(74,108,247,0.35);
        }
        .logo-title { font-size: 28px; font-weight: 700; letter-spacing: -0.6px; color: var(--text); }
        .logo-title span { color: var(--blue); }
        .logo-subtitle { font-size: 14px; color: var(--text2); margin-top: 6px; }

        /* Password reveal */
        .password-reveal {
            background: linear-gradient(135deg, #ecfdf5, #f0fdf9);
            border: 1px solid #a7f3d0;
            border-radius: 16px; padding: 24px;
            margin-bottom: 24px; text-align: center;
        }
        .password-reveal-title { font-size: 16px; font-weight: 700; color: #059669; margin-bottom: 4px; }
        .password-reveal-sub { font-size: 13px; color: var(--text2); margin-bottom: 16px; }
        .password-box {
            display: flex; align-items: center; gap: 10px;
            background: white; border: 1px solid #a7f3d0;
            border-radius: 12px; padding: 14px 16px; margin-bottom: 12px;
        }
        .password-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 18px; font-weight: 500;
            color: #065f46; flex: 1; letter-spacing: 3px; text-align: center;
        }
        .copy-btn {
            background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46;
            padding: 6px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            transition: all 0.2s; font-family: 'Sora', sans-serif;
        }
        .copy-btn:hover { background: #a7f3d0; }
        .warning-text { font-size: 12px; color: #ef4444; margin-bottom: 16px; }
        .goto-login {
            display: block;
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            color: white; text-decoration: none;
            padding: 13px; border-radius: 12px;
            font-size: 14px; font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(74,108,247,0.35);
        }
        .goto-login:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(74,108,247,0.45); }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 12px; font-weight: 600;
            color: var(--text2); text-transform: uppercase;
            letter-spacing: 0.7px; margin-bottom: 8px;
        }
        .form-input {
            width: 100%; background: var(--bg);
            border: 1.5px solid var(--border); border-radius: 12px;
            padding: 13px 16px; color: var(--text);
            font-size: 14px; font-family: 'Sora', sans-serif;
            outline: none; transition: all 0.2s;
        }
        .form-input:focus {
            border-color: var(--blue); background: white;
            box-shadow: 0 0 0 4px rgba(74,108,247,0.1);
        }
        .form-input::placeholder { color: var(--muted); }
        .form-error { font-size: 12px; color: var(--error); margin-top: 6px; }

        .info-box {
            background: var(--blue-light); border: 1px solid var(--blue-mid);
            border-radius: 10px; padding: 12px 14px;
            font-size: 13px; color: var(--blue);
            margin-bottom: 22px; display: flex; align-items: center; gap: 8px;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            border: none; border-radius: 12px; padding: 15px;
            color: white; font-size: 15px; font-weight: 600;
            font-family: 'Sora', sans-serif; cursor: pointer;
            transition: all 0.2s; letter-spacing: 0.3px;
            box-shadow: 0 4px 16px rgba(74,108,247,0.35);
        }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(74,108,247,0.45); }

        .divider { display: flex; align-items: center; gap: 12px; margin: 24px 0; }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text { font-size: 12px; color: var(--muted); white-space: nowrap; }

        .login-link {
            display: block; width: 100%;
            background: var(--blue-light); border: 1.5px solid var(--blue-mid);
            border-radius: 12px; padding: 14px;
            color: var(--blue); font-size: 14px; font-weight: 600;
            text-align: center; text-decoration: none;
            transition: all 0.2s;
        }
        .login-link:hover { background: white; border-color: var(--blue); box-shadow: 0 4px 14px rgba(74,108,247,0.15); }

        .footer-note { text-align: center; margin-top: 20px; font-size: 11px; color: var(--muted); }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>
    <div class="bg-dots"></div>

    <div class="container">
        <div class="card">
            <div class="logo-section">
                <div class="logo-icon">💬</div>
                <div class="logo-title">Chat<span>App</span></div>
                <div class="logo-subtitle">Crea tu cuenta en segundos</div>
            </div>

            @if(session('generated_password'))
            <div class="password-reveal">
                <div class="password-reveal-title">🎉 ¡Cuenta creada!</div>
                <div class="password-reveal-sub">Guarda tu contraseña antes de continuar</div>
                <div class="password-box">
                    <span class="password-code" id="passCode">{{ session('generated_password') }}</span>
                    <button class="copy-btn" onclick="copyPass()">Copiar</button>
                </div>
                <div class="warning-text">⚠️ Esta contraseña no se mostrará de nuevo</div>
                <a href="{{ route('login') }}" class="goto-login">Ir al Login →</a>
            </div>
            @endif

            @if(!session('generated_password'))
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-input"
                        value="{{ old('name') }}"
                        placeholder="Tu nombre completo" required autofocus>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-input"
                        value="{{ old('email') }}"
                        placeholder="tu@correo.com" required>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-box">
                    🔐 Se generará una contraseña segura automáticamente
                </div>

                <button type="submit" class="submit-btn">Crear mi cuenta →</button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">¿Ya tienes cuenta?</span>
                <div class="divider-line"></div>
            </div>

            <a href="{{ route('login') }}" class="login-link">Iniciar sesión</a>

            <div class="footer-note">ChatApp Gamboa &nbsp;·&nbsp; Mensajes cifrados AES-256</div>
            @endif
        </div>
    </div>

    <script>
        function copyPass() {
            const code = document.getElementById('passCode')?.innerText;
            if (code) {
                navigator.clipboard.writeText(code);
                const btn = event.target;
                btn.textContent = '✓ Copiado';
                setTimeout(() => btn.textContent = 'Copiar', 2000);
            }
        }
    </script>
</body>
</html>