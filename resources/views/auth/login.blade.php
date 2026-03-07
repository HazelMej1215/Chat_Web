<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp — Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #f0f4ff;
            --white: #ffffff;
            --blue: #4a6cf7;
            --blue-dark: #3451d1;
            --blue-light: #eef2ff;
            --blue-mid: #c7d2fe;
            --text: #1e2340;
            --text2: #64748b;
            --muted: #94a3b8;
            --border: #e2e8f0;
            --success: #10b981;
            --error: #ef4444;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .bg-shapes { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .shape {
            position: absolute; border-radius: 50%;
            background: linear-gradient(135deg, rgba(74,108,247,0.12), rgba(99,102,241,0.08));
            animation: floatShape 14s ease-in-out infinite;
        }
        .shape-1 { width: 500px; height: 500px; top: -200px; right: -150px; animation-delay: 0s; }
        .shape-2 { width: 350px; height: 350px; bottom: -120px; left: -100px; animation-delay: -5s; }
        .shape-3 { width: 200px; height: 200px; top: 55%; left: 55%; animation-delay: -9s; }

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
            width: 100%; max-width: 460px;
            padding: 20px;
            animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            background: var(--white);
            border-radius: 24px;
            padding: 44px 40px 36px;
            box-shadow: 0 4px 6px rgba(74,108,247,0.04), 0 20px 60px rgba(74,108,247,0.12), 0 0 0 1px rgba(74,108,247,0.08);
        }

        .logo-section { text-align: center; margin-bottom: 36px; }
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

        .password-alert {
            background: linear-gradient(135deg, #ecfdf5, #f0fdf9);
            border: 1px solid #a7f3d0;
            border-radius: 14px; padding: 16px; margin-bottom: 28px;
        }
        .password-alert-title { font-size: 13px; font-weight: 600; color: #059669; margin-bottom: 10px; }
        .password-alert-label { font-size: 11px; color: var(--text2); margin-bottom: 6px; }
        .password-display {
            display: flex; align-items: center; gap: 8px;
            background: white; border: 1px solid #a7f3d0;
            border-radius: 10px; padding: 10px 14px;
        }
        .password-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 15px; font-weight: 500;
            color: #065f46; flex: 1; letter-spacing: 2px;
        }
        .copy-btn {
            background: #d1fae5; border: none; color: #065f46;
            padding: 4px 10px; border-radius: 6px;
            font-size: 11px; font-weight: 600;
            cursor: pointer; transition: all 0.2s; font-family: 'Sora', sans-serif;
        }
        .copy-btn:hover { background: #a7f3d0; }
        .warning-text { font-size: 11px; color: #ef4444; margin-top: 8px; }

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

        .input-wrapper { position: relative; }
        .eye-btn {
            position: absolute; right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--muted); cursor: pointer;
            padding: 4px; border-radius: 6px;
            display: flex; align-items: center; transition: color 0.2s;
        }
        .eye-btn:hover { color: var(--blue); }

        .form-row {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 24px;
        }
        .remember-wrap { display: flex; align-items: center; gap: 8px; }
        .remember-wrap input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--blue); cursor: pointer; }
        .remember-wrap label { font-size: 13px; color: var(--text2); cursor: pointer; }

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
        .submit-btn:active { transform: translateY(0); }

        .divider {
            display: flex; align-items: center; gap: 12px; margin: 24px 0;
        }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text { font-size: 12px; color: var(--muted); white-space: nowrap; }

        .register-btn {
            display: block; width: 100%;
            background: var(--blue-light);
            border: 1.5px solid var(--blue-mid);
            border-radius: 12px; padding: 14px;
            color: var(--blue); font-size: 14px; font-weight: 600;
            font-family: 'Sora', sans-serif; cursor: pointer;
            text-align: center; text-decoration: none;
            transition: all 0.2s; letter-spacing: 0.2px;
        }
        .register-btn:hover {
            background: white; border-color: var(--blue);
            box-shadow: 0 4px 14px rgba(74,108,247,0.15);
        }

        .footer-note { text-align: center; margin-top: 20px; font-size: 11px; color: var(--muted); }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="bg-dots"></div>

    <div class="container">
        <div class="card">
            <div class="logo-section">
                <div class="logo-icon">💬</div>
                <div class="logo-title">Chat<span>App</span></div>
                <div class="logo-subtitle">Inicia sesión para continuar</div>
            </div>

            @if(session('generated_password'))
            <div class="password-alert">
                <div class="password-alert-title">✅ Cuenta creada exitosamente</div>
                <div class="password-alert-label">Tu contraseña generada automáticamente:</div>
                <div class="password-display">
                    <span class="password-code" id="passCode">{{ session('generated_password') }}</span>
                    <button class="copy-btn" onclick="copyPass()">Copiar</button>
                </div>
                <div class="warning-text">⚠️ Guarda esta contraseña, no se mostrará de nuevo.</div>
            </div>
            @endif

            @if(session('status'))
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:12px;margin-bottom:20px;font-size:13px;color:#3b82f6;">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-input"
                        value="{{ old('email', session('registered_email')) }}"
                        placeholder="tu@correo.com" required autofocus>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password"
                            class="form-input" style="padding-right:46px;"
                            placeholder="••••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePassword()">
                            <svg id="eyeShow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeHide" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="remember-wrap">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Iniciar Sesión →</button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">¿No tienes cuenta?</span>
                <div class="divider-line"></div>
            </div>

            <a href="{{ route('register') }}" class="register-btn">Crear cuenta nueva</a>

            <div class="footer-note">ChatApp Gamboa &nbsp;·&nbsp; Mensajes cifrados AES-256</div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const show = document.getElementById('eyeShow');
            const hide = document.getElementById('eyeHide');
            if (input.type === 'password') {
                input.type = 'text';
                show.style.display = 'none';
                hide.style.display = 'block';
            } else {
                input.type = 'password';
                show.style.display = 'block';
                hide.style.display = 'none';
            }
        }

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