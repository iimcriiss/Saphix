<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" type="image/png" href="/img/icono_saphix.png">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<title>Login — Saphix</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Sora', sans-serif;
    background: #0f0e1a;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    overflow: hidden;
  }

  /* Grid background */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(99,102,241,0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(99,102,241,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
    z-index: 0;
  }

  /* Orbs */
  .orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    z-index: 0;
    animation: drift 12s ease-in-out infinite;
  }
  .orb-1 { width: 450px; height: 450px; background: rgba(79,70,229,0.2); top: -120px; left: -100px; }
  .orb-2 { width: 350px; height: 350px; background: rgba(139,92,246,0.13); bottom: -80px; right: -80px; animation-delay: -5s; }

  @keyframes drift {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(25px,-20px) scale(1.04); }
  }

  /* Card */
  .login-card {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 400px;
    background: rgba(22,21,42,0.85);
    border: 1px solid rgba(99,102,241,0.25);
    border-radius: 24px;
    padding: 40px 36px;
    backdrop-filter: blur(24px);
    box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(99,102,241,0.08);
    animation: cardIn 0.7s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes cardIn {
    from { opacity: 0; transform: translateY(32px) scale(0.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }

  /* Logo area */
  .logo-area {
    text-align: center;
    margin-bottom: 32px;
    animation: fadeUp 0.6s cubic-bezier(.22,1,.36,1) 0.15s both;
  }

  .logo-text {
    font-family: 'JetBrains Mono', monospace;
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, #818cf8, #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing: -0.5px;
  }

  .cursor {
    animation: blink 1s step-end infinite;
    -webkit-text-fill-color: #818cf8;
  }

  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Badge */
  .badge-shimmer {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px;
    border-radius: 999px;
    border: 1px solid rgba(99,102,241,0.3);
    font-size: 11px;
    color: #a5b4fc;
    font-weight: 500;
    letter-spacing: 0.05em;
    background: linear-gradient(90deg, rgba(99,102,241,0.1) 0%, rgba(139,92,246,0.25) 50%, rgba(99,102,241,0.1) 100%);
    background-size: 200% auto;
    animation: shimmer 3s linear infinite;
    margin-top: 8px;
  }

  @keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
  }

  /* Form fields */
  .field-group {
    margin-bottom: 18px;
    animation: fadeUp 0.6s cubic-bezier(.22,1,.36,1) both;
  }
  .field-group:nth-child(1) { animation-delay: 0.25s; }
  .field-group:nth-child(2) { animation-delay: 0.32s; }
  .field-group:nth-child(3) { animation-delay: 0.39s; }

  label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #a5b4fc;
    margin-bottom: 7px;
    letter-spacing: 0.02em;
  }

  .input-wrap { position: relative; }

  input[type="email"],
  input[type="password"],
  input[type="text"] {
    width: 100%;
    background: rgba(15,14,26,0.7);
    border: 1px solid rgba(99,102,241,0.2);
    border-radius: 12px;
    padding: 12px 16px 12px 44px;
    font-size: 14px;
    font-family: 'Sora', sans-serif;
    color: #e2e0f0;
    outline: none;
    transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
  }

  input::placeholder { color: rgba(165,180,252,0.3); }

  input:focus {
    border-color: rgba(99,102,241,0.6);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    background: rgba(15,14,26,0.9);
  }

  .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(99,102,241,0.5);
    pointer-events: none;
  }

  .toggle-pwd {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(99,102,241,0.4);
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    transition: color 0.2s;
  }
  .toggle-pwd:hover { color: rgba(165,180,252,0.8); }

  /* Error */
  .error-box {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    color: #fca5a5;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: fadeUp 0.4s cubic-bezier(.22,1,.36,1) both;
  }

  /* Submit button */
  .btn-submit {
    width: 100%;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    font-family: 'Sora', sans-serif;
    font-size: 15px;
    font-weight: 600;
    padding: 13px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 20px rgba(79,70,229,0.4);
    margin-top: 8px;
    animation: fadeUp 0.6s cubic-bezier(.22,1,.36,1) 0.45s both;
  }

  .btn-submit::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
    transition: left 0.5s;
  }
  .btn-submit:hover::before { left: 100%; }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(79,70,229,0.5);
  }
  .btn-submit:active { transform: translateY(0); }

  /* Divider */
  .divider-line {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0;
    animation: fadeUp 0.6s cubic-bezier(.22,1,.36,1) 0.4s both;
  }
  .divider-line::before,
  .divider-line::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(99,102,241,0.15);
  }
  .divider-line span { font-size: 11px; color: rgba(165,180,252,0.3); }

  /* Footer */
  .card-footer {
    text-align: center;
    margin-top: 24px;
    animation: fadeUp 0.6s cubic-bezier(.22,1,.36,1) 0.5s both;
  }

  /* Loading state */
  .btn-submit.loading { pointer-events: none; }
  .btn-submit.loading .btn-text { opacity: 0; }
  .btn-submit.loading::after {
    content: '';
    position: absolute;
    width: 18px; height: 18px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    top: 50%; left: 50%;
    transform: translate(-50%,-50%);
  }
  @keyframes spin { to { transform: translate(-50%,-50%) rotate(360deg); } }
</style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="login-card">

  <!-- Logo -->
  <div class="logo-area">
    <img src="/img/saphix_logo.svg" alt="SAPHIX" class="logo-text">
    <div style="margin-top:10px">
      <span class="badge-shimmer">
        <span style="width:6px;height:6px;border-radius:50%;background:#34d399;display:inline-block;animation:pulse 2s ease-in-out infinite"></span>
        Gestión de inventario y ventas
      </span>
    </div>
  </div>

  <!-- Error -->
  <?php if (isset($error)): ?>
  <div class="error-box">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?= $error ?>
  </div>
  <?php endif; ?>

  <!-- Form -->
  <form method="POST" action="/login" id="login-form">

    <div class="field-group">
      <label>Correo electrónico</label>
      <div class="input-wrap">
        <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <input type="email" name="email" placeholder="correo@ejemplo.com" required autocomplete="email">
      </div>
    </div>

    <div class="field-group">
      <label>Contraseña</label>
      <div class="input-wrap">
        <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        <input type="password" name="password" id="pwd-input" placeholder="••••••••" required autocomplete="current-password">
        <button type="button" class="toggle-pwd" onclick="togglePwd()" id="eye-btn">
          <svg id="eye-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
          </svg>
        </button>
      </div>
    </div>

    <button type="submit" class="btn-submit" id="btn-login">
      <span class="btn-text">Iniciar sesión →</span>
    </button>

  </form>

  <!-- Footer -->
  <div class="card-footer">
    <p style="font-size:11px;color:rgba(165,180,252,0.2);font-family:'JetBrains Mono',monospace;letter-spacing:0.05em">
      Saphix v1.0 — Sistema interno
    </p>
  </div>

</div>

<style>
  @keyframes pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50% { opacity:0.6; transform:scale(0.85); }
  }
</style>

<script>
  function togglePwd() {
    const input = document.getElementById('pwd-input');
    const icon  = document.getElementById('eye-icon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
      ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
      : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
  }

  // Loading state al hacer submit
  document.getElementById('login-form').addEventListener('submit', function() {
    const btn = document.getElementById('btn-login');
    btn.classList.add('loading');
  });
</script>

</body>
</html>