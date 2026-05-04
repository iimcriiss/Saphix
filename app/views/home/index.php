<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="theme-color" content="#0f0e1a">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Saphix — Gestión de inventario y ventas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="/img/icono_saphix.png">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --indigo: #4f46e5;
      --indigo-light: #818cf8;
      --dark: #0f0e1a;
      --surface: #16152a;
      --border: rgba(99, 102, 241, 0.2);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Sora', sans-serif;
      background: var(--dark);
      color: #e2e0f0;
      overflow-x: hidden;
    }

    /* ── Grid background ── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(99, 102, 241, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99, 102, 241, 0.04) 1px, transparent 1px);
      background-size: 48px 48px;
      pointer-events: none;
      z-index: 0;
    }

    /* ── Glow orbs ── */
    .orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(100px);
      pointer-events: none;
      z-index: 0;
      animation: drift 12s ease-in-out infinite;
    }

    .orb-1 {
      width: 500px;
      height: 500px;
      background: rgba(79, 70, 229, 0.18);
      top: -100px;
      left: -100px;
      animation-delay: 0s;
    }

    .orb-2 {
      width: 400px;
      height: 400px;
      background: rgba(139, 92, 246, 0.12);
      top: 40%;
      right: -100px;
      animation-delay: -4s;
    }

    .orb-3 {
      width: 350px;
      height: 350px;
      background: rgba(16, 185, 129, 0.08);
      bottom: -50px;
      left: 30%;
      animation-delay: -8s;
    }

    @keyframes drift {

      0%,
      100% {
        transform: translate(0, 0) scale(1);
      }

      33% {
        transform: translate(30px, -30px) scale(1.05);
      }

      66% {
        transform: translate(-20px, 20px) scale(0.97);
      }
    }

    /* ── Navbar ── */
    nav {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 100;
      padding: 18px 48px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(15, 14, 26, 0.7);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
    }

    .logo {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.5px;
      background: linear-gradient(135deg, #818cf8, #a78bfa);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family: 'JetBrains Mono', monospace;
    }

    .logo span {
      color: #4f46e5;
      -webkit-text-fill-color: #818cf8;
    }

    /* ── Animations de entrada ── */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(32px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes scaleIn {
      from {
        opacity: 0;
        transform: scale(0.92);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes slideLeft {
      from {
        opacity: 0;
        transform: translateX(-40px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideRight {
      from {
        opacity: 0;
        transform: translateX(40px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes pulse-ring {
      0% {
        transform: scale(1);
        opacity: 0.6;
      }

      100% {
        transform: scale(1.6);
        opacity: 0;
      }
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    @keyframes shimmer {
      0% {
        background-position: -200% center;
      }

      100% {
        background-position: 200% center;
      }
    }

    @keyframes counter {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes spin-slow {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    @keyframes blink {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }
    }

    .animate-fade-up {
      animation: fadeUp 0.7s cubic-bezier(.22, 1, .36, 1) both;
    }

    .animate-fade-in {
      animation: fadeIn 0.6s ease both;
    }

    .animate-scale-in {
      animation: scaleIn 0.6s cubic-bezier(.22, 1, .36, 1) both;
    }

    .animate-slide-left {
      animation: slideLeft 0.7s cubic-bezier(.22, 1, .36, 1) both;
    }

    .animate-slide-right {
      animation: slideRight 0.7s cubic-bezier(.22, 1, .36, 1) both;
    }

    .animate-float {
      animation: float 4s ease-in-out infinite;
    }

    .delay-1 {
      animation-delay: 0.1s;
    }

    .delay-2 {
      animation-delay: 0.2s;
    }

    .delay-3 {
      animation-delay: 0.3s;
    }

    .delay-4 {
      animation-delay: 0.4s;
    }

    .delay-5 {
      animation-delay: 0.5s;
    }

    .delay-6 {
      animation-delay: 0.6s;
    }

    .delay-7 {
      animation-delay: 0.7s;
    }

    .delay-8 {
      animation-delay: 0.8s;
    }

    /* ── Badge shimmer ── */
    .badge-shimmer {
      background: linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0%, rgba(139, 92, 246, 0.4) 50%, rgba(99, 102, 241, 0.15) 100%);
      background-size: 200% auto;
      animation: shimmer 3s linear infinite;
    }

    /* ── Cursor blink ── */
    .cursor {
      animation: blink 1s step-end infinite;
    }

    /* ── Stat card ── */
    .stat-card {
      position: relative;
      background: rgba(22, 21, 42, 0.8);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px 24px;
      backdrop-filter: blur(10px);
      transition: border-color 0.3s, transform 0.3s;
    }

    .stat-card:hover {
      border-color: rgba(99, 102, 241, 0.5);
      transform: translateY(-3px);
    }

    .stat-card::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 16px;
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), transparent);
      pointer-events: none;
    }

    /* ── Feature card ── */
    .feature-card {
      background: rgba(22, 21, 42, 0.6);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 28px;
      backdrop-filter: blur(10px);
      transition: all 0.35s cubic-bezier(.22, 1, .36, 1);
      position: relative;
      overflow: hidden;
    }

    .feature-card::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.06), transparent 60%);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .feature-card:hover {
      border-color: rgba(99, 102, 241, 0.45);
      transform: translateY(-6px);
      box-shadow: 0 20px 60px rgba(79, 70, 229, 0.15);
    }

    .feature-card:hover::after {
      opacity: 1;
    }

    /* ── Icon ring animation ── */
    .icon-wrap {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .icon-wrap::before {
      content: '';
      position: absolute;
      inset: -4px;
      border-radius: 14px;
      background: rgba(99, 102, 241, 0.2);
      animation: pulse-ring 2.5s ease-out infinite;
    }

    /* ── CTA button ── */
    .btn-cta {
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white;
      font-weight: 600;
      padding: 14px 32px;
      border-radius: 12px;
      text-decoration: none;
      font-size: 15px;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 24px rgba(79, 70, 229, 0.4);
    }

    .btn-cta::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.12), transparent);
      transition: left 0.5s;
    }

    .btn-cta:hover::before {
      left: 100%;
    }

    .btn-cta:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 32px rgba(79, 70, 229, 0.5);
    }

    .btn-ghost {
      color: #a5b4fc;
      font-weight: 500;
      padding: 14px 28px;
      border-radius: 12px;
      text-decoration: none;
      font-size: 15px;
      border: 1px solid rgba(99, 102, 241, 0.3);
      transition: all 0.2s;
    }

    .btn-ghost:hover {
      background: rgba(99, 102, 241, 0.1);
      border-color: rgba(99, 102, 241, 0.5);
      color: white;
    }

    /* ── Dashboard mockup ── */
    .mockup {
      background: rgba(22, 21, 42, 0.9);
      border: 1px solid rgba(99, 102, 241, 0.25);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(99, 102, 241, 0.1);
    }

    .mockup-bar {
      background: rgba(15, 14, 26, 0.8);
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      border-bottom: 1px solid rgba(99, 102, 241, 0.15);
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
    }

    .mockup-content {
      padding: 16px;
    }

    .mock-stat {
      background: rgba(99, 102, 241, 0.08);
      border: 1px solid rgba(99, 102, 241, 0.15);
      border-radius: 10px;
      padding: 12px;
    }

    .mock-bar {
      height: 6px;
      border-radius: 3px;
      background: linear-gradient(90deg, #4f46e5, #7c3aed);
      margin-top: 8px;
    }

    /* ── Typing text ── */
    .typing-text {
      font-family: 'JetBrains Mono', monospace;
    }

    /* ── Scroll reveal ── */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.7s cubic-bezier(.22, 1, .36, 1), transform 0.7s cubic-bezier(.22, 1, .36, 1);
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* ── Divider gradient ── */
    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.4), transparent);
    }

    /* Tailwind overrides para z-index */
    .z-10 {
      z-index: 10;
    }

    html,
    body {
      scroll-behavior: smooth;
      height: 100%;
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 100px;
      width: auto;
    }

    .logo img {
      height: 100px;
      width: auto;
      filter: drop-shadow(0 0 20px rgba(79, 70, 229, 0.5));
    }

    .delay-0 {
      animation-delay: 0s;
    }

    html {
      scroll-behavior: smooth;
      /* fuerza scrollbar siempre visible, evita el salto */
    }

    body {
      overflow-anchor: none;
      /* evita que el browser restaure posición */
    }
  </style>
</head>

<body>

  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <!-- ── Navbar ── -->
  <nav>
    <div class="logo">Saphix<span class="cursor ml-0.5">_</span></div>
    <div class="flex items-center gap-3">
      <a href="#features" class="hidden sm:block text-sm text-indigo-300 hover:text-white transition-colors px-4 py-2">Funciones</a>
      <a href="/login" class="btn-cta text-sm py-2.5 px-5">Iniciar sesión →</a>
    </div>
  </nav>

  <!-- ── Hero ── -->
  <section class="relative z-10 min-h-screen flex flex-col items-center justify-center px-6 pt-24 pb-16 text-center">

    <!-- Logo hero -->
    <div class="animate-fade-up delay-0 mb-6">
      <img src="/img/saphix_logo.svg" alt="Saphix" style="height:100px; width:auto; filter: drop-shadow(0 0 20px rgba(79,70,229,0.5));">
    </div>

    <!-- Badge -->
    <div class="animate-fade-up delay-1 mb-6">
      <span class="badge-shimmer inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-indigo-500/30 text-indigo-300 text-xs font-medium tracking-wide">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse inline-block"></span>
        Sistema de gestión activo
      </span>
    </div>

    <!-- Headline -->
    <h1 class="animate-fade-up delay-2 text-5xl sm:text-6xl md:text-7xl font-extrabold leading-tight tracking-tight mb-6 max-w-3xl">
      <span class="text-white">Gestiona tu</span><br>
      <span style="background: linear-gradient(135deg, #818cf8, #a78bfa, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">negocio completo</span>
    </h1>

    <!-- Subtext con typing -->
    <p class="animate-fade-up delay-3 text-lg text-indigo-200/60 max-w-lg mb-10 leading-relaxed">
      Inventario, ventas, clientes y reportes — todo en un solo sistema diseñado para crecer contigo.
    </p>

    <!-- Buttons -->
    <div class="animate-fade-up delay-4 flex flex-wrap items-center justify-center gap-4 mb-16">
      <a href="/login" class="btn-cta">Entrar al sistema</a>
      <a href="#features" class="btn-ghost">Ver funciones ↓</a>
    </div>

    <!-- Stats row -->
    <div class="animate-fade-up delay-5 grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-2xl w-full mb-16">
      <div class="stat-card text-center">
        <p class="text-2xl font-bold text-white" data-count="100">0</p>
        <p class="text-xs text-indigo-300/60 mt-1">Productos</p>
      </div>
      <div class="stat-card text-center">
        <p class="text-2xl font-bold text-emerald-400" data-count="500">0</p>
        <p class="text-xs text-indigo-300/60 mt-1">Ventas</p>
      </div>
      <div class="stat-card text-center">
        <p class="text-2xl font-bold text-violet-400" data-count="50">0</p>
        <p class="text-xs text-indigo-300/60 mt-1">Clientes</p>
      </div>
      <div class="stat-card text-center">
        <p class="text-2xl font-bold text-amber-400">24/7</p>
        <p class="text-xs text-indigo-300/60 mt-1">Disponible</p>
      </div>
    </div>

    <!-- Dashboard mockup -->
    <div class="animate-scale-in delay-6 animate-float w-full max-w-2xl mx-auto">
      <div class="mockup">
        <div class="mockup-bar">
          <div class="dot bg-red-400"></div>
          <div class="dot bg-yellow-400"></div>
          <div class="dot bg-green-400"></div>
          <span class="ml-3 text-xs text-indigo-300/40 font-mono">saphix / dashboard</span>
        </div>
        <div class="mockup-content">
          <div class="grid grid-cols-3 gap-2 mb-3">
            <div class="mock-stat">
              <p class="text-xs text-indigo-300/50">Ventas hoy</p>
              <p class="text-lg font-bold text-white mt-1">$513.500</p>
              <div class="mock-bar" style="width:75%"></div>
            </div>
            <div class="mock-stat">
              <p class="text-xs text-indigo-300/50">Productos</p>
              <p class="text-lg font-bold text-violet-400 mt-1">48</p>
              <div class="mock-bar" style="width:60%; background: linear-gradient(90deg,#7c3aed,#a78bfa)"></div>
            </div>
            <div class="mock-stat">
              <p class="text-xs text-indigo-300/50">Balance</p>
              <p class="text-lg font-bold text-emerald-400 mt-1">+$113k</p>
              <div class="mock-bar" style="width:85%; background: linear-gradient(90deg,#059669,#34d399)"></div>
            </div>
          </div>
          <div class="grid grid-cols-5 gap-1.5">
            <div class="col-span-3 bg-indigo-500/5 border border-indigo-500/10 rounded-lg p-3">
              <p class="text-xs text-indigo-300/40 mb-2">Últimas ventas</p>
              <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                  <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-indigo-500/30 flex items-center justify-center text-xs text-indigo-300">M</div>
                    <span class="text-xs text-indigo-200/60">Mostrador</span>
                  </div>
                  <span class="text-xs text-emerald-400 font-mono">$25.000</span>
                </div>
                <div class="flex justify-between items-center">
                  <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-violet-500/30 flex items-center justify-center text-xs text-violet-300">A</div>
                    <span class="text-xs text-indigo-200/60">Alejandro</span>
                  </div>
                  <span class="text-xs text-emerald-400 font-mono">$88.000</span>
                </div>
                <div class="flex justify-between items-center">
                  <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-pink-500/30 flex items-center justify-center text-xs text-pink-300">S</div>
                    <span class="text-xs text-indigo-200/60">Sayago</span>
                  </div>
                  <span class="text-xs text-emerald-400 font-mono">$44.500</span>
                </div>
              </div>
            </div>
            <div class="col-span-2 bg-indigo-500/5 border border-indigo-500/10 rounded-lg p-3">
              <p class="text-xs text-indigo-300/40 mb-2">Stock bajo</p>
              <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                  <span class="text-xs text-indigo-200/60">Prueba</span>
                  <span class="text-xs bg-red-500/20 text-red-400 border border-red-500/20 px-1.5 py-0.5 rounded-full">2</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-xs text-indigo-200/60">Gatsy</span>
                  <span class="text-xs bg-amber-500/20 text-amber-400 border border-amber-500/20 px-1.5 py-0.5 rounded-full">9</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="divider"></div>

  <!-- ── Features ── -->
  <section id="features" class="relative z-10 px-6 py-24 max-w-6xl mx-auto">
    <div class="text-center mb-16 reveal">
      <p class="text-indigo-400 text-sm font-mono mb-3 tracking-widest uppercase">¿Qué incluye?</p>
      <h2 class="text-4xl font-bold text-white mb-4">Todo lo que necesitas</h2>
      <p class="text-indigo-200/50 max-w-md mx-auto">Un sistema completo para gestionar cada aspecto de tu negocio desde un solo lugar.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

      <div class="feature-card reveal" style="transition-delay:0.05s">
        <div class="icon-wrap mb-5">
          <div class="w-12 h-12 bg-indigo-500/15 border border-indigo-500/25 rounded-2xl flex items-center justify-center text-2xl relative z-10">📦</div>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Inventario</h3>
        <p class="text-indigo-200/50 text-sm leading-relaxed">Controla stock en tiempo real. Alertas automáticas cuando los productos están por agotarse.</p>
        <div class="mt-4 flex gap-1">
          <span class="text-xs bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2 py-0.5 rounded-full">Stock bajo</span>
          <span class="text-xs bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2 py-0.5 rounded-full">Categorías</span>
        </div>
      </div>

      <div class="feature-card reveal" style="transition-delay:0.1s">
        <div class="icon-wrap mb-5">
          <div class="w-12 h-12 bg-emerald-500/15 border border-emerald-500/25 rounded-2xl flex items-center justify-center text-2xl relative z-10">💰</div>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Ventas</h3>
        <p class="text-indigo-200/50 text-sm leading-relaxed">Registra ventas, aplica impuestos, múltiples métodos de pago y genera historial completo.</p>
        <div class="mt-4 flex gap-1">
          <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full">Efectivo</span>
          <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full">Nequi</span>
          <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full">Tarjeta</span>
        </div>
      </div>

      <div class="feature-card reveal" style="transition-delay:0.15s">
        <div class="icon-wrap mb-5">
          <div class="w-12 h-12 bg-violet-500/15 border border-violet-500/25 rounded-2xl flex items-center justify-center text-2xl relative z-10">👥</div>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Clientes</h3>
        <p class="text-indigo-200/50 text-sm leading-relaxed">Gestiona tu cartera de clientes, historial de compras y datos de contacto organizados.</p>
        <div class="mt-4 flex gap-1">
          <span class="text-xs bg-violet-500/10 text-violet-400 border border-violet-500/20 px-2 py-0.5 rounded-full">Historial</span>
          <span class="text-xs bg-violet-500/10 text-violet-400 border border-violet-500/20 px-2 py-0.5 rounded-full">Búsqueda</span>
        </div>
      </div>

      <div class="feature-card reveal" style="transition-delay:0.2s">
        <div class="icon-wrap mb-5">
          <div class="w-12 h-12 bg-amber-500/15 border border-amber-500/25 rounded-2xl flex items-center justify-center text-2xl relative z-10">📊</div>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Reportes</h3>
        <p class="text-indigo-200/50 text-sm leading-relaxed">Cierre de caja, balance del mes, exportación de datos y reportes detallados de rendimiento.</p>
        <div class="mt-4 flex gap-1">
          <span class="text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-full">Excel</span>
          <span class="text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-full">Cierre caja</span>
        </div>
      </div>

      <div class="feature-card reveal" style="transition-delay:0.25s">
        <div class="icon-wrap mb-5">
          <div class="w-12 h-12 bg-pink-500/15 border border-pink-500/25 rounded-2xl flex items-center justify-center text-2xl relative z-10">🛒</div>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Compras</h3>
        <p class="text-indigo-200/50 text-sm leading-relaxed">Gestiona compras a proveedores, actualiza el inventario automáticamente y lleva el control de gastos.</p>
        <div class="mt-4 flex gap-1">
          <span class="text-xs bg-pink-500/10 text-pink-400 border border-pink-500/20 px-2 py-0.5 rounded-full">Proveedores</span>
          <span class="text-xs bg-pink-500/10 text-pink-400 border border-pink-500/20 px-2 py-0.5 rounded-full">Auto-stock</span>
        </div>
      </div>

      <div class="feature-card reveal" style="transition-delay:0.3s">
        <div class="icon-wrap mb-5">
          <div class="w-12 h-12 bg-cyan-500/15 border border-cyan-500/25 rounded-2xl flex items-center justify-center text-2xl relative z-10">🔔</div>
        </div>
        <h3 class="text-white font-semibold text-lg mb-2">Notificaciones</h3>
        <p class="text-indigo-200/50 text-sm leading-relaxed">Alertas en tiempo real de stock bajo, nuevas ventas y eventos importantes del sistema.</p>
        <div class="mt-4 flex gap-1">
          <span class="text-xs bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 px-2 py-0.5 rounded-full">Tiempo real</span>
          <span class="text-xs bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 px-2 py-0.5 rounded-full">Smart alerts</span>
        </div>
      </div>

    </div>
  </section>

  <div class="divider"></div>

  <!-- ── CTA final ── -->
  <section class="relative z-10 px-6 py-24 text-center reveal">
    <div class="max-w-lg mx-auto">
      <h2 class="text-4xl font-bold text-white mb-4">Listo para empezar</h2>
      <p class="text-indigo-200/50 mb-8">Accede a tu sistema de gestión ahora mismo.</p>
      <a href="/login" class="btn-cta inline-block text-base px-10 py-4">
        Entrar a Saphix →
      </a>
    </div>
  </section>

  <!-- ── Footer ── -->
  <footer class="relative z-10 border-t border-indigo-500/10 py-6 px-6 text-center">
    <p class="text-xs text-indigo-300/30 font-mono">Saphix © 2026 — Sistema de gestión de inventario y ventas</p>
  </footer>

  <script>
    // ── Counter animation ──
    function animateCounter(el, target, duration = 1500) {
      let start = 0;
      const step = target / (duration / 16);
      const update = () => {
        start = Math.min(start + step, target);
        el.textContent = Math.floor(start) + (target >= 100 ? '+' : '');
        if (start < target) requestAnimationFrame(update);
      };
      requestAnimationFrame(update);
    }

    window.addEventListener('load', () => {
      document.querySelectorAll('[data-count]').forEach(el => {
        animateCounter(el, parseInt(el.dataset.count));
      });
    });

    // ── Scroll reveal ──
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1
    });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // SVG reveal automático
    document.addEventListener("DOMContentLoaded", () => {
      const paths = document.querySelectorAll("#logoPaths path");

      paths.forEach((path, index) => {
        path.classList.add("path-reveal");
        path.style.animationDelay = (index * 0.012) + "s";
      });
    });
    window.scrollTo({
      top: 0,
      behavior: 'instant'
    });
  </script>

</body>

</html>