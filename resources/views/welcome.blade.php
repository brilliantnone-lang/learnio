<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learnio - LMS Interaktif</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Quicksand:wght@300;500;700&display=swap" rel="stylesheet">
  <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
  <style>
    :root {
      --coral: #FF6B6B;
      --coral-deep: #E85555;
      --coral-light: #FF9A8B;
      --mint: #4ECDC4;
      --mint-soft: #A8E6CF;
      --sun: #FFD93D;
      --sun-soft: #FFF3C4;
      --violet: #C4B5FD;
      --cream: #FFFAF5;
      --peach: #FFE8DD;
      --text-dark: #2D2B3D;
      --text-mid: #6B6580;
      --text-light: #A9A3B8;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Nunito', sans-serif;
      overflow: hidden;
      height: 100vh;
      width: 100vw;
      background: var(--cream);
      cursor: none;
    }

    .loader-bar {
      position: fixed;
      top: 0; left: 0;
      height: 3px;
      width: 0%;
      background: linear-gradient(90deg, var(--coral), var(--mint), var(--sun), var(--violet));
      background-size: 300% 100%;
      animation: loaderFill 1.8s cubic-bezier(0.65, 0, 0.35, 1) forwards, loaderGradient 2s linear infinite;
      z-index: 9999;
      border-radius: 0 3px 3px 0;
    }
    .loader-bar.done {
      animation: loaderExit 0.5s 0.3s ease-in forwards;
    }
    @keyframes loaderFill { to { width: 100%; } }
    @keyframes loaderGradient { to { background-position: 300% 0; } }
    @keyframes loaderExit { to { transform: translateY(-100%); opacity: 0; } }

    .cursor-glow {
      position: fixed;
      width: 320px; height: 320px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,107,107,0.08) 0%, transparent 70%);
      pointer-events: none;
      z-index: 3;
      transform: translate(-50%, -50%);
      transition: opacity 0.3s;
      will-change: left, top;
    }
    .cursor-dot {
      position: fixed;
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--coral);
      pointer-events: none;
      z-index: 9998;
      transform: translate(-50%, -50%);
      transition: transform 0.15s ease, width 0.2s, height 0.2s, background 0.2s;
      will-change: left, top;
    }
    .cursor-dot.hovering {
      width: 16px; height: 16px;
      background: var(--mint);
      transform: translate(-50%, -50%) scale(1);
    }

    .bg-layer { position: fixed; inset: 0; z-index: 0; overflow: hidden; }

    .bg-gradient {
      position: absolute; inset: 0;
      background: linear-gradient(165deg, #FFFAF5 0%, #FFE8DD 35%, #FFF5EE 65%, #E8FFF8 100%);
    }

    .bg-orb {
      position: absolute;
      top: 50%; left: 50%;
      width: 140vmax; height: 140vmax;
      transform: translate(-50%, -50%);
      background: conic-gradient(from 0deg at 50% 50%,
        rgba(255,107,107,0.12), rgba(78,205,196,0.1), rgba(255,217,61,0.1),
        rgba(196,181,253,0.08), rgba(255,107,107,0.12));
      filter: blur(80px);
      animation: orbSpin 25s linear infinite;
    }
    @keyframes orbSpin { to { transform: translate(-50%, -50%) rotate(360deg); } }

    .bg-dots {
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(45,43,61,0.035) 1px, transparent 1px);
      background-size: 30px 30px;
    }

    /* Blob morphing */
    .blob {
      position: absolute;
      filter: blur(50px);
      opacity: 0.35;
    }
    .blob-1 {
      width: 300px; height: 300px;
      background: var(--coral);
      top: -60px; left: -40px;
      animation: morphBlob1 14s ease-in-out infinite, blobDrift1 18s ease-in-out infinite;
    }
    .blob-2 {
      width: 260px; height: 260px;
      background: var(--mint);
      bottom: -40px; right: -30px;
      animation: morphBlob2 12s ease-in-out infinite, blobDrift2 16s ease-in-out infinite;
    }
    .blob-3 {
      width: 200px; height: 200px;
      background: var(--sun);
      top: 25%; right: 8%;
      opacity: 0.2;
      animation: morphBlob3 16s ease-in-out infinite, blobDrift3 20s ease-in-out infinite;
    }
    .blob-4 {
      width: 170px; height: 170px;
      background: var(--violet);
      bottom: 18%; left: 6%;
      opacity: 0.18;
      animation: morphBlob1 11s ease-in-out infinite reverse, blobDrift2 14s ease-in-out infinite reverse;
    }

    @keyframes morphBlob1 {
      0%   { border-radius: 40% 60% 60% 40% / 60% 30% 70% 40%; }
      25%  { border-radius: 50% 50% 30% 70% / 50% 60% 40% 50%; }
      50%  { border-radius: 30% 70% 50% 50% / 40% 40% 60% 60%; }
      75%  { border-radius: 60% 40% 40% 60% / 70% 50% 50% 30%; }
      100% { border-radius: 40% 60% 60% 40% / 60% 30% 70% 40%; }
    }
    @keyframes morphBlob2 {
      0%   { border-radius: 60% 40% 30% 70% / 50% 60% 40% 50%; }
      33%  { border-radius: 30% 70% 50% 50% / 60% 30% 70% 40%; }
      66%  { border-radius: 50% 50% 60% 40% / 40% 50% 50% 60%; }
      100% { border-radius: 60% 40% 30% 70% / 50% 60% 40% 50%; }
    }
    @keyframes morphBlob3 {
      0%   { border-radius: 50% 50% 40% 60% / 40% 60% 50% 50%; }
      50%  { border-radius: 40% 60% 60% 40% / 60% 40% 40% 60%; }
      100% { border-radius: 50% 50% 40% 60% / 40% 60% 50% 50%; }
    }
    @keyframes blobDrift1 {
      0%, 100% { transform: translate(0, 0); }
      33% { transform: translate(40px, -25px); }
      66% { transform: translate(-20px, 35px); }
    }
    @keyframes blobDrift2 {
      0%, 100% { transform: translate(0, 0); }
      33% { transform: translate(-35px, 20px); }
      66% { transform: translate(25px, -30px); }
    }
    @keyframes blobDrift3 {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(30px, 25px); }
    }

    .floating-elements { position: fixed; inset: 0; z-index: 1; pointer-events: none; }
    .float-item {
      position: absolute;
      animation: floatUp linear infinite;
      opacity: 0;
    }
    @keyframes floatUp {
      0%   { opacity: 0; transform: translateY(100vh) rotate(0deg) scale(0.4); }
      8%   { opacity: 0.6; }
      88%  { opacity: 0.6; }
      100% { opacity: 0; transform: translateY(-10vh) rotate(360deg) scale(1.1); }
    }

    #particleCanvas { position: fixed; inset: 0; z-index: 2; pointer-events: none; }

    .splash-content {
      position: relative;
      z-index: 10;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      padding: 20px;
      text-align: center;
    }

    .book-wrapper {
      position: relative;
      margin-bottom: 16px;
    }
    .book-character {
      position: relative;
      width: 180px;
      height: 210px;
      animation: bookBounce 3s ease-in-out infinite;
    }
    @keyframes bookBounce {
      0%, 100% { transform: translateY(0) rotate(-1.5deg); }
      50% { transform: translateY(-16px) rotate(1.5deg); }
    }

    .orbit-ring {
      position: absolute;
      width: 250px; height: 250px;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      border: 1.5px dashed rgba(255,107,107,0.12);
      border-radius: 50%;
      animation: orbitSpin 35s linear infinite;
    }
    .orbit-ring-2 {
      width: 280px; height: 280px;
      border-color: rgba(78,205,196,0.08);
      animation-direction: reverse;
      animation-duration: 45s;
    }
    .orbit-dot {
      position: absolute;
      width: 6px; height: 6px;
      border-radius: 50%;
      top: -3px; left: 50%;
      transform: translateX(-50%);
    }
    .orbit-ring .orbit-dot { background: var(--coral-light); }
    .orbit-ring-2 .orbit-dot { background: var(--mint); }
    @keyframes orbitSpin { to { transform: translate(-50%, -50%) rotate(360deg); } }

    /* Bayangan buku */
    .book-shadow {
      position: absolute;
      bottom: 2px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px; height: 12px;
      background: rgba(45,43,61,0.08);
      border-radius: 50%;
      animation: shadowBreathe 3s ease-in-out infinite;
    }
    @keyframes shadowBreathe {
      0%, 100% { transform: translateX(-50%) scaleX(1); opacity: 0.08; }
      50% { transform: translateX(-50%) scaleX(0.8); opacity: 0.04; }
    }

    /* Tubuh buku */
    .book-body {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      width: 130px; height: 160px;
      background: linear-gradient(145deg, #FF9A8B 0%, var(--coral) 100%);
      border-radius: 6px 14px 14px 6px;
      box-shadow:
        -6px 0 0 0 #E06050,
        -8px 2px 0 0 #C84A3A,
        4px 10px 25px rgba(45,43,61,0.12);
      overflow: visible;
    }
    .book-spine {
      position: absolute;
      left: -8px; top: 0;
      width: 8px; height: 100%;
      background: linear-gradient(90deg, #C84A3A, #E06050);
      border-radius: 4px 0 0 4px;
    }

    /* Halaman buku yang bergerak */
    .book-page-edge {
      position: absolute;
      top: 4px; right: 3px;
      width: 18px; height: calc(100% - 8px);
      background: rgba(255,255,255,0.2);
      border-radius: 0 11px 11px 0;
      transform-origin: left center;
      animation: pageFlip 5s ease-in-out infinite;
    }
    @keyframes pageFlip {
      0%, 75%, 100% { transform: rotateY(0deg); }
      80% { transform: rotateY(-25deg); }
      85% { transform: rotateY(0deg); }
      90% { transform: rotateY(-12deg); }
      95% { transform: rotateY(0deg); }
    }

    /* Garis halaman */
    .book-lines { position: absolute; top: 30px; left: 20px; right: 15px; }
    .book-line {
      height: 4px;
      border-radius: 2px;
      background: rgba(255,255,255,0.3);
      margin-bottom: 10px;
    }
    .book-line:nth-child(1) { width: 85%; }
    .book-line:nth-child(2) { width: 70%; }
    .book-line:nth-child(3) { width: 90%; }
    .book-line:nth-child(4) { width: 55%; }
    .book-line:nth-child(5) { width: 75%; }
    .book-label {
      position: absolute;
      bottom: 12px; left: 20px; right: 15px;
      height: 22px;
      background: rgba(255,255,255,0.2);
      border-radius: 4px;
    }

    /* Tangan buku */
    .arm {
      position: absolute;
      width: 16px; height: 42px;
      border-radius: 8px;
      transform-origin: top center;
    }
    .arm-left {
      bottom: 48px; left: calc(50% - 73px);
      background: linear-gradient(to bottom, var(--coral-light), var(--coral));
      transform: rotate(18deg);
    }
    .arm-right {
      bottom: 52px; right: calc(50% - 73px);
      background: linear-gradient(to bottom, var(--coral-light), var(--coral));
      animation: armWave 2s ease-in-out infinite;
    }
    .hand {
      position: absolute;
      bottom: -3px; left: 50%;
      transform: translateX(-50%);
      width: 14px; height: 14px;
      background: #FFDAB9;
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    @keyframes armWave {
      0%, 100% { transform: rotate(-18deg); }
      20% { transform: rotate(-45deg); }
      40% { transform: rotate(-18deg); }
      60% { transform: rotate(-38deg); }
      80% { transform: rotate(-18deg); }
    }

    /* Mata */
    .book-eyes {
      position: absolute;
      top: -18px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 28px;
    }
    .eye {
      width: 34px; height: 38px;
      background: white;
      border-radius: 50%;
      position: relative;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06);
      animation: blink 4.5s ease-in-out infinite;
    }
    .eye-pupil {
      position: absolute;
      width: 17px; height: 19px;
      background: var(--text-dark);
      border-radius: 50%;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      animation: lookAround 7s ease-in-out infinite;
    }
    .eye-pupil-shine {
      position: absolute;
      width: 6px; height: 6px;
      background: white;
      border-radius: 50%;
      top: 6px; right: 5px;
    }
    .eye-pupil-shine-sm {
      position: absolute;
      width: 3px; height: 3px;
      background: white;
      border-radius: 50%;
      bottom: 8px; left: 5px;
      opacity: 0.6;
    }
    @keyframes blink {
      0%, 43%, 47%, 100% { transform: scaleY(1); }
      45% { transform: scaleY(0.08); }
    }
    @keyframes lookAround {
      0%, 100% { transform: translate(-50%, -50%); }
      20% { transform: translate(-38%, -56%); }
      40% { transform: translate(-58%, -46%); }
      60% { transform: translate(-48%, -54%); }
      80% { transform: translate(-42%, -48%); }
    }

    /* Pipi & mulut */
    .book-cheeks {
      position: absolute;
      top: 10px; left: 50%;
      transform: translateX(-50%);
      width: 115px;
      display: flex;
      justify-content: space-between;
    }
    .cheek {
      width: 22px; height: 13px;
      background: rgba(255,140,140,0.45);
      border-radius: 50%;
      animation: cheekGlow 3s ease-in-out infinite;
    }
    @keyframes cheekGlow {
      0%, 100% { opacity: 0.5; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.18); }
    }
    .book-mouth {
      position: absolute;
      top: 2px; left: 50%;
      transform: translateX(-50%);
      width: 18px; height: 9px;
      border-bottom: 3px solid var(--text-dark);
      border-radius: 0 0 50% 50%;
    }

    .book-crown {
      position: absolute;
      top: -60px; left: 50%;
      transform: translateX(-50%);
      animation: crownBob 2.5s ease-in-out infinite;
    }
    .crown-points {
      display: flex;
      align-items: flex-end;
      gap: 0;
    }
    .crown-point {
      width: 0; height: 0;
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-bottom: 14px solid var(--sun);
    }
    .crown-point.side { border-bottom-color: var(--sun); opacity: 0.8; transform: scale(0.85); }
    .crown-base {
      width: 40px; height: 6px;
      background: var(--sun);
      border-radius: 2px;
      margin-top: -1px;
      margin-left: -2px;
      box-shadow: 0 2px 6px rgba(255,217,61,0.3);
    }
    .crown-gem {
      width: 5px; height: 5px;
      border-radius: 50%;
      background: var(--coral);
      position: absolute;
      top: 8px; left: 50%;
      transform: translateX(-50%);
      box-shadow: 0 0 6px rgba(255,107,107,0.5);
      animation: gemGlow 2s ease-in-out infinite;
    }
    @keyframes crownBob {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50% { transform: translateX(-50%) translateY(-5px); }
    }
    @keyframes gemGlow {
      0%, 100% { box-shadow: 0 0 4px rgba(255,107,107,0.4); }
      50% { box-shadow: 0 0 10px rgba(255,107,107,0.7); }
    }

    .sparkle {
      position: absolute;
      width: 10px; height: 10px;
      animation: sparklePulse 2.2s ease-in-out infinite;
    }
    .sparkle::before, .sparkle::after {
      content: '';
      position: absolute;
      background: var(--sun);
      border-radius: 2px;
    }
    .sparkle::before {
      width: 100%; height: 2.5px;
      top: 50%; left: 0;
      transform: translateY(-50%);
    }
    .sparkle::after {
      width: 2.5px; height: 100%;
      left: 50%; top: 0;
      transform: translateX(-50%);
    }
    .sparkle-1 { top: -28px; right: -12px; animation-delay: 0s; }
    .sparkle-2 { bottom: 40px; left: -22px; animation-delay: 0.7s; transform: scale(0.65); }
    .sparkle-3 { top: 50px; right: -28px; animation-delay: 1.3s; transform: scale(0.5); }
    .sparkle-4 { bottom: 65px; right: -16px; animation-delay: 0.3s; transform: scale(0.55); }
    @keyframes sparklePulse {
      0%, 100% { opacity: 0.2; transform: scale(0.6) rotate(0deg); }
      50% { opacity: 1; transform: scale(1.3) rotate(45deg); }
    }

    .splash-title {
      font-family: 'Quicksand', sans-serif;
      font-weight: 700;
      font-size: clamp(2rem, 5.5vw, 3rem);
      color: var(--text-dark);
      line-height: 1.2;
      margin-bottom: 10px;
    }
    .title-line {
      display: block;
      overflow: hidden;
      padding: 0 4px;
    }
    .title-line-inner {
      display: block;
      transform: translateY(110%);
      animation: lineReveal 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .title-line:nth-child(2) .title-line-inner { animation-delay: 0.15s; }
    @keyframes lineReveal { to { transform: translateY(0); } }

    .highlight {
      position: relative;
      display: inline-block;
      color: var(--coral-deep);
    }
    .highlight-underline {
      position: absolute;
      bottom: 1px; left: -4px; right: -4px;
      height: 10px;
      background: var(--sun-soft);
      border-radius: 5px;
      z-index: -1;
      transform: scaleX(0);
      transform-origin: left;
      animation: drawLine 0.6s 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes drawLine { to { transform: scaleX(1); } }

    .splash-subtitle {
      font-family: 'Nunito', sans-serif;
      font-weight: 600;
      font-size: clamp(0.85rem, 2.2vw, 1.05rem);
      color: var(--text-mid);
      margin-bottom: 36px;
      max-width: 340px;
      line-height: 1.7;
      opacity: 0;
      animation: fadeSlideUp 0.7s 0.55s ease-out forwards;
    }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(18px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* === TOMBOL MAGNETIC === */
    .btn-container {
      position: relative;
      display: inline-block;
      opacity: 0;
      animation: fadeSlideUp 0.7s 0.75s ease-out forwards;
    }
    .btn-start {
      position: relative;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 18px 48px;
      font-family: 'Nunito', sans-serif;
      font-weight: 800;
      font-size: 1.15rem;
      color: white;
      background: linear-gradient(135deg, var(--coral) 0%, var(--coral-deep) 100%);
      border: none;
      border-radius: 60px;
      cursor: none;
      overflow: hidden;
      transition: box-shadow 0.3s ease;
      box-shadow:
        0 6px 24px rgba(232,85,85,0.3),
        0 2px 6px rgba(232,85,85,0.15),
        inset 0 1px 0 rgba(255,255,255,0.2);
      outline: none;
      will-change: transform;
    }
    .btn-start::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
      border-radius: inherit;
      pointer-events: none;
    }
    .btn-start::after {
      content: '';
      position: absolute;
      top: -50%; left: -60%;
      width: 40%; height: 200%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
      transform: skewX(-20deg);
      animation: btnShine 4.5s ease-in-out infinite;
      pointer-events: none;
    }
    @keyframes btnShine {
      0%, 65%, 100% { left: -60%; }
      82% { left: 120%; }
    }
    .btn-start:hover {
      box-shadow:
        0 12px 40px rgba(232,85,85,0.35),
        0 4px 10px rgba(232,85,85,0.2),
        inset 0 1px 0 rgba(255,255,255,0.25);
    }
    .btn-start:active {
      transition: box-shadow 0.1s;
      box-shadow:
        0 3px 12px rgba(232,85,85,0.25),
        inset 0 2px 4px rgba(0,0,0,0.1);
    }
    .btn-start:focus-visible {
      outline: 3px solid var(--sun);
      outline-offset: 4px;
    }
    .btn-start .btn-text { position: relative; z-index: 2; }
    .btn-start .btn-icon {
      position: relative; z-index: 2;
      transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
      display: flex;
    }
    .btn-start:hover .btn-icon {
      transform: translateX(5px);
    }

    .btn-pulse-ring {
      position: absolute;
      inset: -2px;
      border-radius: 60px;
      border: 2px solid var(--coral);
      animation: pulseRing 2.8s ease-out infinite;
      pointer-events: none;
    }
    .btn-pulse-ring:nth-child(2) { animation-delay: 0.9s; }
    @keyframes pulseRing {
      0% { transform: scale(1); opacity: 0.4; }
      100% { transform: scale(1.5); opacity: 0; }
    }

    /* Ripple saat klik */
    .btn-ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      transform: scale(0);
      animation: rippleOut 0.6s ease-out forwards;
      pointer-events: none;
    }
    @keyframes rippleOut {
      to { transform: scale(4); opacity: 0; }
    }

    /* === BADGE FITUR === */
    .feature-badges {
      display: flex;
      gap: 12px;
      margin-top: 32px;
      flex-wrap: wrap;
      justify-content: center;
    }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 9px 18px;
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.8);
      border-radius: 30px;
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--text-mid);
      box-shadow: 0 2px 10px rgba(45,43,61,0.05);
      opacity: 0;
      transform: translateY(20px) scale(0.85);
      animation: badgeBounceIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .badge:nth-child(1) { animation-delay: 1.0s; }
    .badge:nth-child(2) { animation-delay: 1.15s; }
    .badge:nth-child(3) { animation-delay: 1.3s; }
    @keyframes badgeBounceIn {
      to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .badge:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 6px 20px rgba(45,43,61,0.1);
    }
    .badge iconify-icon {
      font-size: 1rem;
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .badge:hover iconify-icon {
      transform: rotate(15deg) scale(1.15);
    }
    .badge-materi iconify-icon { color: var(--coral); }
    .badge-kuis iconify-icon { color: var(--mint); }
    .badge-flash iconify-icon { color: #F59E0B; }

    /* === TOAST === */
    .toast {
      position: fixed;
      bottom: 32px; left: 50%;
      transform: translateX(-50%) translateY(120px);
      background: var(--text-dark);
      color: white;
      padding: 14px 28px;
      border-radius: 16px;
      font-family: 'Nunito', sans-serif;
      font-weight: 700;
      font-size: 0.88rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      z-index: 100;
      transition: transform 0.55s cubic-bezier(0.34, 1.56, 0.64, 1);
      display: flex;
      align-items: center;
      gap: 10px;
      white-space: nowrap;
    }
    .toast.show {
      transform: translateX(-50%) translateY(0);
    }
    .toast iconify-icon { color: var(--mint); font-size: 1.1rem; }

    /* === ANIMASI MASUK KARAKTER === */
    .book-wrapper {
      opacity: 0;
      animation: charEnter 1s 0.1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes charEnter {
      from { opacity: 0; transform: translateY(40px) scale(0.8) rotate(-5deg); }
      to { opacity: 1; transform: translateY(0) scale(1) rotate(0deg); }
    }

    @media (max-width: 480px) {
      .book-character { width: 140px; height: 170px; }
      .book-body { width: 100px; height: 125px; }
      .book-eyes { gap: 20px; }
      .eye { width: 28px; height: 32px; }
      .eye-pupil { width: 14px; height: 16px; }
      .book-cheeks { width: 90px; }
      .cheek { width: 18px; height: 10px; }
      .arm { width: 13px; height: 34px; }
      .arm-left { left: calc(50% - 58px); bottom: 38px; }
      .arm-right { right: calc(50% - 58px); bottom: 42px; }
      .hand { width: 11px; height: 11px; }
      .book-crown { top: -50px; }
      .orbit-ring { width: 200px; height: 200px; }
      .orbit-ring-2 { width: 225px; height: 225px; }
      .btn-start { padding: 16px 36px; font-size: 1.05rem; }
      .feature-badges { gap: 8px; }
      .badge { padding: 7px 14px; font-size: 0.72rem; }
      .cursor-glow, .cursor-dot { display: none; }
      body { cursor: auto; }
      .btn-start { cursor: pointer; }
    }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }
  </style>
</head>
<body>

  <!-- Loading Bar -->
  <div class="loader-bar" id="loaderBar" aria-hidden="true"></div>

  <!-- Cursor kustom -->
  <div class="cursor-glow" id="cursorGlow" aria-hidden="true"></div>
  <div class="cursor-dot" id="cursorDot" aria-hidden="true"></div>

  <!-- Background -->
  <div class="bg-layer" aria-hidden="true">
    <div class="bg-gradient"></div>
    <div class="bg-orb"></div>
    <div class="bg-dots"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="blob blob-4"></div>
  </div>

  <!-- Elemen mengambang -->
  <div class="floating-elements" aria-hidden="true" id="floatingElements"></div>

  <!-- Partikel -->
  <canvas id="particleCanvas" aria-hidden="true"></canvas>

  <!-- Konten Utama -->
  <main class="splash-content" role="main">

    <!-- Karakter Buku -->
    <div class="book-wrapper" id="bookWrapper">
      <div class="orbit-ring"><div class="orbit-dot"></div></div>
      <div class="orbit-ring orbit-ring-2"><div class="orbit-dot"></div></div>
      <div class="book-character" id="bookCharacter">
        <div class="book-crown">
          <div class="crown-points">
            <div class="crown-point side"></div>
            <div class="crown-point"></div>
            <div class="crown-point side"></div>
          </div>
          <div class="crown-base"></div>
          <div class="crown-gem"></div>
        </div>
        <div class="book-eyes">
          <div class="eye">
            <div class="eye-pupil">
              <div class="eye-pupil-shine"></div>
              <div class="eye-pupil-shine-sm"></div>
            </div>
          </div>
          <div class="eye">
            <div class="eye-pupil">
              <div class="eye-pupil-shine"></div>
              <div class="eye-pupil-shine-sm"></div>
            </div>
          </div>
        </div>
        <div class="book-cheeks">
          <div class="cheek"></div>
          <div class="cheek"></div>
        </div>
        <div class="book-mouth"></div>
        <div class="arm arm-left"><div class="hand"></div></div>
        <div class="arm arm-right"><div class="hand"></div></div>
        <div class="book-body">
          <div class="book-spine"></div>
          <div class="book-page-edge"></div>
          <div class="book-lines">
            <div class="book-line"></div>
            <div class="book-line"></div>
            <div class="book-line"></div>
            <div class="book-line"></div>
            <div class="book-line"></div>
          </div>
          <div class="book-label"></div>
        </div>
        <div class="book-shadow"></div>
        <div class="sparkle sparkle-1"></div>
        <div class="sparkle sparkle-2"></div>
        <div class="sparkle sparkle-3"></div>
        <div class="sparkle sparkle-4"></div>
      </div>
    </div>

    <!-- Judul -->
    <h1 class="splash-title">
      <span class="title-line">
        <span class="title-line-inner">Selamat Datang di</span>
      </span>
      <span class="title-line">
        <span class="title-line-inner"><span class="highlight">Learnio<span class="highlight-underline"></span></span></span>
      </span>
    </h1>

    <!-- Subtitle -->
    <p class="splash-subtitle">#</p>

    <!-- Tombol -->
    <div class="btn-container">
      <div class="btn-pulse-ring"></div>
      <div class="btn-pulse-ring"></div>
      <button class="btn-start" id="btnStart" aria-label="Mulai Sekarang">
        <span class="btn-text">Mulai Sekarang</span>
        <span class="btn-icon">
          <iconify-icon icon="lucide:arrow-right" width="20"></iconify-icon>
        </span>
      </button>
    </div>

    <!-- Badge Fitur -->
    <div class="feature-badges">
      <div class="badge badge-materi" data-hoverable>
        <iconify-icon icon="lucide:book-open" width="18"></iconify-icon>
        <span>Materi</span>
      </div>
      <div class="badge badge-kuis" data-hoverable>
        <iconify-icon icon="lucide:circle-help" width="18"></iconify-icon>
        <span>Kuis</span>
      </div>
      <div class="badge badge-flash" data-hoverable>
        <iconify-icon icon="lucide:layers" width="18"></iconify-icon>
        <span>Flashcard</span>
      </div>
    </div>

  </main>

  <!-- Toast -->
  <div class="toast" id="toast" role="alert" aria-live="polite">
    <iconify-icon icon="lucide:check-circle-2" width="20"></iconify-icon>
    <span id="toastMsg">Halaman selanjutnya segera hadir!</span>
  </div>

  <script>
    (function initLoader() {
      const bar = document.getElementById('loaderBar');
      setTimeout(() => bar.classList.add('done'), 2000);
      setTimeout(() => bar.remove(), 2600);
    })();

    (function initCursor() {
      const glow = document.getElementById('cursorGlow');
      const dot = document.getElementById('cursorDot');
      let mx = -500, my = -500;
      let gx = -500, gy = -500;

      /* dot langsung ikut mouse */
      document.addEventListener('mousemove', function (e) {
        mx = e.clientX;
        my = e.clientY;
        dot.style.left = mx + 'px';
        dot.style.top = my + 'px';
      });

      /* glow mengikuti dengan sedikit delay (lerp) */
      function animateGlow() {
        gx += (mx - gx) * 0.08;
        gy += (my - gy) * 0.08;
        glow.style.left = gx + 'px';
        glow.style.top = gy + 'px';
        requestAnimationFrame(animateGlow);
      }
      requestAnimationFrame(animateGlow);
      
      const hoverables = document.querySelectorAll('[data-hoverable], button');
      hoverables.forEach(function (el) {
        el.addEventListener('mouseenter', function () { dot.classList.add('hovering'); });
        el.addEventListener('mouseleave', function () { dot.classList.remove('hovering'); });
      });
    })();

    (function initFloatingShapes() {
      var container = document.getElementById('floatingElements');
      var colors = ['#FF6B6B', '#4ECDC4', '#FFD93D', '#C4B5FD', '#FF9A8B', '#A8E6CF', '#F59E0B'];

      function createShape() {
        var el = document.createElement('div');
        el.classList.add('float-item');

        var type = Math.floor(Math.random() * 5);
        var color = colors[Math.floor(Math.random() * colors.length)];
        var scale = 0.4 + Math.random() * 0.8;
        var duration = 12 + Math.random() * 16;
        var left = Math.random() * 100;

        el.style.left = left + '%';
        el.style.animationDuration = duration + 's';
        el.style.animationDelay = (Math.random() * duration) + 's';

        var shape;
        if (type === 0) {
          /* lingkaran */
          var size = 8 + Math.random() * 10;
          shape = document.createElement('div');
          shape.style.cssText = 'width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + color + ';transform:scale(' + scale + ')';
        } else if (type === 1) {
          /* berlian */
          var s = 7 + Math.random() * 8;
          shape = document.createElement('div');
          shape.style.cssText = 'width:' + s + 'px;height:' + s + 'px;transform:rotate(45deg) scale(' + scale + ');border-radius:2px;background:' + color;
        } else if (type === 2) {
          /* buku mini */
          shape = document.createElement('div');
          shape.style.cssText = 'width:14px;height:10px;border-radius:0 2px 2px 0;background:' + color + ';position:relative;border-left:2px solid rgba(0,0,0,0.12);transform:scale(' + scale + ')';
          var pg = document.createElement('div');
          pg.style.cssText = 'position:absolute;left:-2px;top:0;width:7px;height:10px;border-radius:2px 0 0 2px;background:' + color + ';filter:brightness(0.85);transform-origin:right center;transform:skewY(-3deg)';
          shape.appendChild(pg);
        } else if (type === 3) {
          /* segitiga */
          shape = document.createElement('div');
          shape.style.cssText = 'width:0;height:0;border-left:7px solid transparent;border-right:7px solid transparent;border-bottom:13px solid ' + color + ';transform:scale(' + scale + ')';
        } else {
          /* titik kecil */
          var d = 4 + Math.random() * 5;
          shape = document.createElement('div');
          shape.style.cssText = 'width:' + d + 'px;height:' + d + 'px;border-radius:50%;background:' + color + ';opacity:0.5;transform:scale(' + scale + ')';
        }

        el.appendChild(shape);
        container.appendChild(el);
      }

      for (var i = 0; i < 28; i++) createShape();
    })();

    (function initParticles() {
      var canvas = document.getElementById('particleCanvas');
      var ctx = canvas.getContext('2d');
      var w, h;
      var particles = [];
      var COUNT = 45;
      var pColors = [
        'rgba(255,107,107,0.3)',
        'rgba(78,205,196,0.25)',
        'rgba(255,217,61,0.3)',
        'rgba(196,181,253,0.2)',
        'rgba(255,154,139,0.25)'
      ];

      function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
      }
      resize();
      window.addEventListener('resize', resize);

      for (var i = 0; i < COUNT; i++) {
        particles.push({
          x: Math.random() * w,
          y: Math.random() * h,
          r: Math.max(1.5, 1.5 + Math.random() * 2.5),
          dx: (Math.random() - 0.5) * 0.35,
          dy: (Math.random() - 0.5) * 0.25,
          color: pColors[Math.floor(Math.random() * pColors.length)],
          phase: Math.random() * Math.PI * 2
        });
      }

      function draw(time) {
        ctx.clearRect(0, 0, w, h);
        for (var i = 0; i < particles.length; i++) {
          var p = particles[i];
          p.x += p.dx;
          p.y += p.dy;
          if (p.x < -10) p.x = w + 10;
          if (p.x > w + 10) p.x = -10;
          if (p.y < -10) p.y = h + 10;
          if (p.y > h + 10) p.y = -10;

          var pulse = 1 + 0.3 * Math.sin(time * 0.0018 + p.phase);
          var r = Math.max(0.5, p.r * pulse);

          ctx.beginPath();
          ctx.arc(p.x, p.y, r, 0, Math.PI * 2);
          ctx.fillStyle = p.color;
          ctx.fill();
        }

        for (var a = 0; a < particles.length; a++) {
          for (var b = a + 1; b < particles.length; b++) {
            var dx = particles[a].x - particles[b].x;
            var dy = particles[a].y - particles[b].y;
            var dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 120) {
              ctx.beginPath();
              ctx.moveTo(particles[a].x, particles[a].y);
              ctx.lineTo(particles[b].x, particles[b].y);
              ctx.strokeStyle = 'rgba(45,43,61,' + (0.025 * (1 - dist / 120)) + ')';
              ctx.lineWidth = 0.5;
              ctx.stroke();
            }
          }
        }

        requestAnimationFrame(draw);
      }
      requestAnimationFrame(draw);
    })();

    (function initMagneticButton() {
      var btn = document.getElementById('btnStart');
      var container = btn.parentElement;
      var isHovering = false;

      btn.addEventListener('mouseenter', function () { isHovering = true; });
      btn.addEventListener('mouseleave', function () {
        isHovering = false;
        btn.style.transform = 'translate(0, 0) scale(1)';
        btn.style.transition = 'transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease';
      });
      btn.addEventListener('mousemove', function (e) {
        if (!isHovering) return;
        var rect = btn.getBoundingClientRect();
        var x = e.clientX - rect.left - rect.width / 2;
        var y = e.clientY - rect.top - rect.height / 2;
        btn.style.transition = 'transform 0.15s ease-out, box-shadow 0.3s ease';
        btn.style.transform = 'translate(' + (x * 0.25) + 'px, ' + (y * 0.25) + 'px) scale(1.03)';
      });
    })();

    (function initButtonClick() {
      var btn = document.getElementById('btnStart');
      var toast = document.getElementById('toast');
      var toastMsg = document.getElementById('toastMsg');
      var toastTimer = null;

      btn.addEventListener('click', function (e) {
        /* ripple effect di dalam tombol */
        var rect = btn.getBoundingClientRect();
        var ripple = document.createElement('div');
        ripple.classList.add('btn-ripple');
        var size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
        btn.appendChild(ripple);
        setTimeout(function () { ripple.remove(); }, 700);

        /* confetti */
        createConfetti(e.clientX, e.clientY);

        /* toast */
        toastMsg.textContent = 'Halaman selanjutnya segera hadir!';
        toast.classList.add('show');
        if (toastTimer) clearTimeout(toastTimer);
        toastTimer = setTimeout(function () {
          toast.classList.remove('show');
        }, 3000);
      });
    })();

    function createConfetti(cx, cy) {
      var colors = ['#FF6B6B', '#4ECDC4', '#FFD93D', '#C4B5FD', '#FF9A8B', '#A8E6CF', '#F59E0B'];
      var shapes = ['circle', 'rect', 'triangle'];

      for (var i = 0; i < 32; i++) {
        var dot = document.createElement('div');
        var size = 5 + Math.random() * 7;
        var angle = (Math.PI * 2 / 32) * i + (Math.random() - 0.5) * 0.6;
        var distance = 70 + Math.random() * 100;
        var color = colors[Math.floor(Math.random() * colors.length)];
        var shape = shapes[Math.floor(Math.random() * shapes.length)];
        var rotation = Math.random() * 720 - 360;
        var isCircle = shape === 'circle';
        var isTriangle = shape === 'triangle';

        var w = size, h = isCircle ? size : (isTriangle ? 0 : size * 0.55);
        var br = isCircle ? '50%' : (isTriangle ? '0' : '2px');

        dot.style.cssText =
          'position:fixed;left:' + cx + 'px;top:' + cy + 'px;' +
          'width:' + w + 'px;height:' + h + 'px;' +
          'background:' + color + ';' +
          'border-radius:' + br + ';' +
          (isTriangle ? 'border-left:' + (size/2) + 'px solid transparent;border-right:' + (size/2) + 'px solid transparent;border-bottom:' + size + 'px solid ' + color + ';width:0;height:0;background:transparent;' : '') +
          'pointer-events:none;z-index:200;' +
          'transition:all 0.75s cubic-bezier(0.22, 0.61, 0.36, 1);' +
          'opacity:1;';

        document.body.appendChild(dot);

        (function (d, a, dist, rot) {
          requestAnimationFrame(function () {
            requestAnimationFrame(function () {
              d.style.transform = 'translate(' + (Math.cos(a) * dist) + 'px,' + (Math.sin(a) * dist - 40) + 'px) rotate(' + rot + 'deg)';
              d.style.opacity = '0';
            });
          });
        })(dot, angle, distance, rotation);

        (function (d) {
          setTimeout(function () { d.remove(); }, 850);
        })(dot);
      }
    }

    (function initParallax() {
      var wrapper = document.getElementById('bookWrapper');
      var blobs = document.querySelectorAll('.blob');
      var mx = 0, my = 0;

      document.addEventListener('mousemove', function (e) {
        mx = (e.clientX / window.innerWidth - 0.5) * 2;
        my = (e.clientY / window.innerHeight - 0.5) * 2;
      });

      function animate() {
        if (wrapper) {
          wrapper.style.transform = 'translate(' + (mx * 10) + 'px, ' + (my * 8) + 'px)';
        }

        for (var i = 0; i < blobs.length; i++) {
          var f = 6 + i * 4;
          blobs[i].style.marginLeft = (-mx * f) + 'px';
          blobs[i].style.marginTop = (-my * f) + 'px';
        }
        requestAnimationFrame(animate);
      }
      requestAnimationFrame(animate);
    })();
  </script>
</body>
</html>