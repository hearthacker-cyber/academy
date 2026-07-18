<?php
session_start();
require_once 'config/config.php'; // if not already included
?>
<!DOCTYPE html>
<html lang="ta">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5" />
  <title>HIFI11 ACADEMY – Premium Ethical Hacking Bundle Pack ₹199</title>
  <meta name="description" content="Premium Digital Bundle Pack: 2 Complete Ethical Hacking Courses. Instant Download. One-Time Purchase ₹199. Worth ₹15,000+." />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <style>
    /* ---------- BASE ---------- */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background: #0a0a0f;
      color: #E6EDF3;
      overflow-x: hidden;
    }
    h1,h2,h3,h4,h5,.display-1,.display-2,.display-3,.display-4,.display-5,.display-6 {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 700;
    }
    .bg-soft-primary { background: #0d1117; }
    .text-primary { color: #00FF41 !important; }
    .text-muted { color: #8B949E !important; }
    .text-secondary { color: #8B949E !important; }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #0a0a0f; }
    ::-webkit-scrollbar-thumb { background: #00FF4130; border-radius: 10px; }

    /* ---------- PREMIUM BACKGROUND ---------- */
    .premium-bg {
      position: relative;
      background: #0a0a0f;
      overflow: hidden;
    }
    .premium-bg::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 20% 30%, rgba(0,255,65,0.03) 0%, transparent 50%),
                  radial-gradient(circle at 80% 70%, rgba(0,212,255,0.04) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }
    .grid-overlay {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(0,255,65,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,255,65,0.04) 1px, transparent 1px);
      background-size: 60px 60px;
      pointer-events: none;
      z-index: 0;
    }
    .glow-sphere {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.15;
      pointer-events: none;
      z-index: 0;
    }

    /* ---------- ANNOUNCEMENT BAR ---------- */
    .announcement-bar {
      background: linear-gradient(135deg, #003B1F, #006B2C);
      color: #00FF41;
      padding: 10px 0;
      font-size: 0.85rem;
      font-weight: 500;
      text-align: center;
      z-index: 1040;
      position: sticky;
      top: 0;
      overflow: hidden;
      border-bottom: 1px solid #00FF4130;
    }
    .announcement-bar .scroll-text {
      display: inline-block;
      animation: scrollAnnounce 18s linear infinite;
      white-space: nowrap;
    }
    @keyframes scrollAnnounce {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }

    /* ---------- NAVBAR ---------- */
    .navbar {
      backdrop-filter: blur(16px);
      background: rgba(10,10,15,0.85);
      border-bottom: 1px solid rgba(0,255,65,0.12);
      z-index: 1030;
    }
    .navbar-brand {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 700;
      font-size: 1.4rem;
      letter-spacing: -0.5px;
      color: #E6EDF3 !important;
    }
    .navbar-brand i { color: #00FF41; margin-right: 6px; }
    .navbar .nav-link { color: #8B949E !important; transition: color 0.2s; }
    .navbar .nav-link:hover { color: #00FF41 !important; }
    .btn-outline-primary-soft {
      border: 1px solid #00FF4140; color: #00FF41;
      background: rgba(0,255,65,0.06); border-radius: 40px; transition: all 0.25s;
    }
    .btn-outline-primary-soft:hover { background: #00FF41; color: #0a0a0f !important; }

    /* ---------- BUTTONS ---------- */
    .gradient-btn {
      background: linear-gradient(135deg, #00CC33 0%, #00FF41 50%, #00D4FF 100%);
      border: none;
      color: #0a0a0f !important;
      transition: all 0.3s ease;
      box-shadow: 0 8px 28px rgba(0,255,65,0.2);
      position: relative;
      overflow: hidden;
      font-weight: 700;
    }
    .gradient-btn:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 14px 36px rgba(0,255,65,0.35);
    }

    /* ---------- FLOATING ---------- */
    .float-slow { animation: floatY 7s ease-in-out infinite; }
    .float-med { animation: floatY 5s ease-in-out infinite; }
    .float-fast { animation: floatY 3.5s ease-in-out infinite; }
    @keyframes floatY {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-16px) rotate(1deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }

    /* ---------- HERO IMAGE ---------- */
    .hero-image-container {
      position: relative;
      border-radius: 32px;
      overflow: hidden;
      box-shadow: 0 30px 60px -20px rgba(0,0,0,0.5);
      transition: all 0.4s;
      border: 1px solid rgba(0,255,65,0.08);
    }
    .hero-image-container img {
      width: 100%;
      height: auto;
      display: block;
      transition: transform 0.6s;
    }
    .hero-image-container:hover img { transform: scale(1.02); }

    .cyber-float {
      position: absolute;
      background: rgba(10,10,15,0.8);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 10px 16px;
      border: 1px solid rgba(0,255,65,0.15);
      box-shadow: 0 12px 32px -8px rgba(0,0,0,0.3);
      font-weight: 500;
      font-size: 0.8rem;
      display: flex;
      align-items: center;
      gap: 8px;
      pointer-events: none;
      color: #E6EDF3;
    }
    .cyber-float i.text-primary { color: #00FF41 !important; }

    /* ---------- PRICING CARD ---------- */
    .pricing-card {
      background: #0d1117;
      border-radius: 32px;
      padding: 1.5rem 2rem;
      border: 1px solid rgba(0,255,65,0.12);
      max-width: 400px;
    }
    .pricing-card .strike { text-decoration: line-through; color: #484F58; font-size: 1.2rem; }
    .pricing-card .price { font-size: 3.2rem; font-weight: 800; color: #00FF41; }
    .pricing-card .text-muted { color: #8B949E !important; }
    .badge-save {
      background: #00FF41;
      color: #0a0a0f;
      border-radius: 40px;
      padding: 4px 16px;
      font-weight: 700;
      font-size: 0.85rem;
    }

    /* ---------- VALUE CARD ---------- */
    .value-card-wrap {
      background: #0d1117;
      border-radius: 28px;
      border: 1px solid rgba(0,255,65,0.12);
      overflow: hidden;
      box-shadow: 0 20px 60px -12px rgba(0,255,65,0.06);
      transition: all 0.3s;
    }
    .value-card-wrap:hover {
      box-shadow: 0 28px 72px -12px rgba(0,255,65,0.12);
      transform: translateY(-4px);
    }
    .value-header {
      background: linear-gradient(135deg, #003B1F, #006B2C, #00D4FF20);
      padding: 2rem 2.5rem;
      color: #00FF41;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1.5rem;
      flex-wrap: wrap;
      border-bottom: 1px solid rgba(0,255,65,0.1);
    }
    .value-tag {
      display: inline-block;
      background: rgba(0,255,65,0.12);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(0,255,65,0.25);
      padding: 4px 16px;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 2px;
      margin-bottom: 10px;
      color: #00FF41;
    }
    .value-title { font-size: 1.6rem; margin: 0; color: #E6EDF3; }
    .value-sub { margin: 4px 0 0; opacity: 0.7; font-size: 0.9rem; color: #8B949E; }
    .value-price-box { text-align: center; flex-shrink: 0; }
    .value-old-price { display: block; text-decoration: line-through; opacity: 0.5; font-size: 1rem; color: #8B949E; }
    .value-new-price { display: block; font-family: 'Space Grotesk', sans-serif; font-size: 3rem; font-weight: 800; line-height: 1; color: #00FF41; }
    .value-save-badge { display: inline-block; background: #00FF41; color: #0a0a0f; padding: 4px 16px; border-radius: 40px; font-size: 0.75rem; font-weight: 700; margin-top: 8px; }
    .value-items-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
    .value-item {
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
      border-bottom: 1px solid rgba(0,255,65,0.06);
      transition: background 0.2s;
      color: #E6EDF3;
    }
    .value-item:nth-child(odd) { border-right: 1px solid rgba(0,255,65,0.06); }
    .value-item:hover { background: rgba(0,255,65,0.03); }
    .value-item i { color: #00FF41; font-size: 1.15rem; flex-shrink: 0; }
    .value-footer {
      padding: 1.5rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      border-top: 1px solid rgba(0,255,65,0.1);
      background: #0d1117;
    }
    .value-savings { display: flex; align-items: center; gap: 10px; color: #00FF41; font-weight: 500; font-size: 0.95rem; }
    .value-savings i { font-size: 1.4rem; }
    @media (max-width: 768px) {
      .value-header { padding: 1.5rem; flex-direction: column; text-align: center; }
      .value-title { font-size: 1.3rem; }
      .value-items-grid { grid-template-columns: 1fr; }
      .value-item:nth-child(odd) { border-right: none; }
      .value-item { padding: 0.85rem 1.5rem; }
      .value-footer { flex-direction: column; text-align: center; }
      .value-footer .btn { width: 100%; }
    }

    /* ---------- GLASS CARD ---------- */
    .glass-card {
      background: rgba(13,17,23,0.7);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(0,255,65,0.12);
      border-radius: 28px;
      transition: all 0.3s;
    }
    .glass-card:hover {
      background: rgba(13,17,23,0.9);
      transform: translateY(-6px);
      box-shadow: 0 24px 48px -12px rgba(0,255,65,0.08);
    }

    /* ---------- APPLE CTA ---------- */
    .cta-apple {
      background: linear-gradient(135deg, #003B1F, #006B2C, #00D4FF20);
      border-radius: 64px;
      padding: 4rem 3rem;
      position: relative;
      overflow: hidden;
      box-shadow: 0 40px 80px -20px rgba(0,255,65,0.15);
      border: 1px solid rgba(0,255,65,0.08);
    }
    .cta-apple .glow-ring {
      position: absolute;
      width: 600px;
      height: 600px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(0,255,65,0.06) 0%, transparent 70%);
      top: -200px;
      right: -200px;
      pointer-events: none;
    }
    .cta-apple .btn-apple {
      background: #00FF41;
      color: #0a0a0f;
      border-radius: 60px;
      padding: 18px 56px;
      font-weight: 700;
      font-size: 1.2rem;
      transition: all 0.3s;
      box-shadow: 0 12px 32px rgba(0,255,65,0.25);
      letter-spacing: 0.5px;
    }
    .cta-apple .btn-apple:hover {
      transform: scale(1.04);
      box-shadow: 0 20px 40px rgba(0,255,65,0.35);
      background: #00FF41;
    }

    /* ---------- WAVE ---------- */
    .wave-divider {
      width: 100%;
      display: block;
      fill: #0d1117;
      margin: -2px 0;
    }
    .wave-divider-dark { fill: #0a0a0f; }

    /* ---------- FLOATING SOCIAL BUTTONS ---------- */
    .social-float {
      position: fixed;
      right: 24px;
      z-index: 1050;
      width: 52px;
      height: 52px;
      border-radius: 60px;
      background: rgba(13,17,23,0.85);
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.3);
      border: 1px solid rgba(0,255,65,0.12);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      color: #E6EDF3;
      transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
      text-decoration: none;
      cursor: pointer;
    }
    .social-float:hover { transform: scale(1.12) translateY(-3px); background: #0d1117; box-shadow: 0 12px 32px rgba(0,255,65,0.15); border-color: #00FF4140; }
    .social-float.whatsapp { bottom: 210px; color: #25D366; }
    .social-float.instagram { bottom: 150px; color: #E4405F; }
    .social-float.telegram { bottom: 90px; color: #0088CC; }
    .social-float.top { bottom: 28px; color: #00FF41; }
    .social-float .tooltip-text {
      position: absolute;
      right: 62px;
      background: rgba(0,0,0,0.9);
      backdrop-filter: blur(8px);
      color: #00FF41;
      padding: 4px 14px;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 500;
      white-space: nowrap;
      opacity: 0;
      transform: translateX(10px);
      transition: all 0.3s ease;
      pointer-events: none;
      border: 1px solid #00FF4130;
    }
    .social-float:hover .tooltip-text { opacity: 1; transform: translateX(0); }

    /* ---------- COUNTER ---------- */
    .counter { font-size: 2.8rem; color: #00FF41 !important; }
    .stats-section .text-muted { color: #8B949E !important; }

    /* ---------- FEATURE ICON ---------- */
    .icon-feature {
      background: #0d1117;
      border-radius: 24px;
      padding: 1.5rem 1rem;
      border: 1px solid rgba(0,255,65,0.08);
      transition: all 0.25s;
      text-align: center;
      height: 100%;
    }
    .icon-feature:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px -12px rgba(0,255,65,0.08);
      border-color: #00FF4130;
    }
    .icon-feature i { font-size: 2rem; color: #00FF41; }
    .icon-feature h6 { color: #E6EDF3; }
    .icon-feature .text-muted { color: #8B949E !important; }

    /* ---------- BONUS CARD ---------- */
    .bonus-card {
      background: #0d1117;
      border-radius: 20px;
      padding: 1.5rem;
      border: 1px solid rgba(0,255,65,0.08);
      text-align: center;
      transition: all 0.25s;
      color: #E6EDF3;
    }
    .bonus-card:hover {
      background: #0d1117;
      border-color: #00FF41;
      box-shadow: 0 12px 28px rgba(0,255,65,0.06);
      transform: translateY(-4px);
    }
    .bonus-card i { font-size: 2rem; color: #00FF41; }

    /* ---------- TRUST BADGE ---------- */
    .trust-badge {
      background: #0d1117;
      border-radius: 40px;
      padding: 6px 18px;
      border: 1px solid rgba(0,255,65,0.12);
      font-size: 0.85rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: #E6EDF3;
    }
    .trust-badge i { color: #00FF41; }

    /* ---------- STICKY MOBILE BUY ---------- */
    .sticky-mobile-buy {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(10,10,15,0.92);
      backdrop-filter: blur(12px);
      padding: 12px 16px;
      border-top: 1px solid #00FF4110;
      z-index: 1040;
      display: none;
    }
    @media (max-width: 768px) {
      .sticky-mobile-buy { display: flex; align-items: center; gap: 12px; }
      .sticky-mobile-buy .price { font-size: 1.4rem; font-weight: 700; color: #00FF41; }
      .sticky-mobile-buy .btn { flex: 1; border-radius: 40px; padding: 12px; font-weight: 600; }
      .counter { font-size: 2rem; }
      .cta-apple { padding: 2.5rem 1.5rem; border-radius: 32px; }
      .pricing-card .price { font-size: 2.4rem; }
      .social-float { width: 44px; height: 44px; font-size: 1.1rem; right: 16px; }
      .social-float.whatsapp { bottom: 180px; }
      .social-float.instagram { bottom: 128px; }
      .social-float.telegram { bottom: 76px; }
      .social-float.top { bottom: 20px; }
      .social-float .tooltip-text { display: none; }
    }

    /* ---------- LIVE DOWNLOAD NOTIFICATIONS ---------- */
    .download-notification {
      position: fixed;
      left: 20px;
      bottom: 90px;
      z-index: 1060;
      background: rgba(13,17,23,0.92);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(0,255,65,0.12);
      border-radius: 16px;
      padding: 12px 18px;
      min-width: 220px;
      max-width: 300px;
      box-shadow: 0 20px 48px -12px rgba(0,0,0,0.4);
      opacity: 0;
      transform: translateX(-30px) scale(0.95);
      transition: opacity 0.5s ease, transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
      pointer-events: none;
    }
    .download-notification.show { opacity: 1; transform: translateX(0) scale(1); pointer-events: auto; }
    .download-notification.hide { opacity: 0; transform: translateX(-30px) scale(0.95); }
    .download-notification .avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: linear-gradient(135deg, rgba(0,255,65,0.15), rgba(0,212,255,0.15));
      display: flex; align-items: center; justify-content: center;
      font-weight: 600; font-size: 0.8rem; color: #00FF41;
      flex-shrink: 0; border: 2px solid #00FF4140; box-shadow: 0 0 0 2px #00FF4130;
    }
    .download-notification .online-dot { width: 8px; height: 8px; background: #00FF41; border-radius: 50%; display: inline-block; margin-right: 4px; animation: pulse 1.5s infinite; }
    .download-notification .notif-text { font-size: 0.8rem; line-height: 1.3; color: #E6EDF3; }
    .download-notification .notif-text strong { color: #E6EDF3; }
    .download-notification .notif-text .action { color: #00FF41; font-weight: 500; }
    .download-notification .time { font-size: 0.65rem; color: #8B949E; }
    @media (max-width: 768px) {
      .download-notification { left: 12px; right: 12px; bottom: 80px; max-width: none; min-width: auto; }
    }

    /* ---------- CONTACT SECTION ---------- */
    .contact-social-links { display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; }
    .contact-social-links a {
      display: inline-flex; align-items: center; gap: 10px;
      padding: 12px 28px; border-radius: 60px;
      background: #0d1117; border: 1px solid rgba(0,255,65,0.12);
      text-decoration: none; color: #E6EDF3; font-weight: 500; transition: all 0.3s;
    }
    .contact-social-links a:hover { background: #0d1117; box-shadow: 0 8px 24px rgba(0,255,65,0.08); transform: translateY(-2px); border-color: #00FF4140; }
    .contact-social-links a i { font-size: 1.4rem; }
    .contact-social-links a.whatsapp i { color: #25D366; }
    .contact-social-links a.instagram i { color: #E4405F; }
    .contact-social-links a.telegram i { color: #0088CC; }

    /* ---------- COUNTDOWN ---------- */
    .countdown { display: flex; align-items: center; justify-content: center; gap: 16px; margin-top: 2rem; }
    .countdown .unit { display: flex; flex-direction: column; align-items: center; }
    .countdown .num {
      font-family: 'Space Grotesk', sans-serif; font-size: 3rem; font-weight: 800;
      color: #00FF41; background: rgba(0,255,65,0.06);
      backdrop-filter: blur(10px); border: 1px solid rgba(0,255,65,0.15);
      border-radius: 20px; width: 90px; height: 90px;
      display: flex; align-items: center; justify-content: center;
      line-height: 1; position: relative;
      box-shadow: 0 8px 32px rgba(0,0,0,0.15), inset 0 1px 0 rgba(0,255,65,0.06);
      transition: transform 0.3s;
    }
    .countdown .num.pulse { animation: countPulse 1s ease-in-out; }
    @keyframes countPulse { 0% { transform: scale(1); } 50% { transform: scale(1.08); background: rgba(0,255,65,0.12); } 100% { transform: scale(1); } }
    .countdown .label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; color: rgba(0,255,65,0.5); margin-top: 10px; }
    .countdown .sep { font-family: 'Space Grotesk', sans-serif; font-size: 2.5rem; font-weight: 800; color: #00FF4140; margin-bottom: 22px; animation: sepBlink 1s ease-in-out infinite; }
    @keyframes sepBlink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
    .countdown .urgent-text { font-size: 0.85rem; font-weight: 600; color: #00FF41; margin-top: 14px; display: flex; align-items: center; gap: 6px; }
    @media (max-width: 768px) {
      .countdown { gap: 10px; margin-top: 1.5rem; }
      .countdown .num { font-size: 2rem; width: 64px; height: 64px; border-radius: 14px; }
      .countdown .sep { font-size: 1.8rem; margin-bottom: 16px; }
      .countdown .label { font-size: 0.65rem; letter-spacing: 1.5px; }
    }

    /* ---------- OPENING OFFER ---------- */
    .opening-offer {
      position: relative;
      background: #0d1117;
      border: 1px solid rgba(0,255,65,0.15);
      border-radius: 32px;
      overflow: hidden;
      transition: all 0.3s;
    }
    .opening-offer:hover {
      box-shadow: 0 28px 72px -12px rgba(0,255,65,0.12);
      transform: translateY(-4px);
    }
    .opening-offer .glow-overlay {
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at 30% 20%, rgba(0,255,65,0.06) 0%, transparent 50%),
                  radial-gradient(ellipse at 70% 80%, rgba(0,212,255,0.04) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }
    .offer-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, #00CC33, #00FF41);
      border: none;
      padding: 10px 28px;
      border-radius: 40px;
      font-size: 1rem;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #0a0a0f;
      box-shadow: 0 0 20px rgba(0,255,65,0.3);
      animation: offerPulse 2s ease-in-out infinite;
    }
    @keyframes offerPulse {
      0%, 100% { box-shadow: 0 0 0 0 rgba(0,255,65,0.3); }
      50% { box-shadow: 0 0 0 8px rgba(0,255,65,0); }
    }
    .offer-headline {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 800;
      font-size: 2.8rem;
      line-height: 1.15;
      color: #E6EDF3;
    }
    .offer-headline span { color: #00FF41; }
    .offer-sub {
      font-size: 1.05rem;
      color: #8B949E;
      max-width: 560px;
      margin: 0 auto;
    }
    .offer-highlight-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      max-width: 500px;
      margin: 0 auto;
    }
    .offer-highlight-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      background: rgba(0,255,65,0.04);
      border: 1px solid rgba(0,255,65,0.1);
      border-radius: 16px;
      font-weight: 500;
      font-size: 0.9rem;
      color: #E6EDF3;
      transition: all 0.2s;
    }
    .offer-highlight-item:hover {
      background: rgba(0,255,65,0.08);
      border-color: rgba(0,255,65,0.2);
    }
    .offer-highlight-item i { color: #00FF41; font-size: 1.2rem; flex-shrink: 0; }
    .offer-warning-card {
      background: rgba(255,183,0,0.04);
      border: 1px solid rgba(255,183,0,0.2);
      border-radius: 20px;
      padding: 1.5rem 2rem;
      position: relative;
      max-width: 500px;
      margin: 0 auto;
    }
    .offer-warning-card .icon { font-size: 2rem; margin-bottom: 6px; }
    .offer-warning-card h5 { color: #FBBF24; font-weight: 700; }
    .offer-warning-card p { color: #8B949E; font-size: 0.9rem; margin-bottom: 4px; }
    .offer-cta-glow {
      animation: ctaGlow 2.5s ease-in-out infinite;
    }
    @keyframes ctaGlow {
      0%, 100% { box-shadow: 0 8px 28px rgba(0,255,65,0.2); }
      50% { box-shadow: 0 8px 40px rgba(0,255,65,0.4); }
    }
    .bell-shake {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      animation: bellRing 1.5s ease-in-out infinite;
    }
    @keyframes bellRing {
      0%, 100% { transform: rotate(0deg); }
      10%, 30% { transform: rotate(12deg); }
      20%, 40% { transform: rotate(-12deg); }
      50%, 90% { transform: rotate(0deg); }
    }
    .badge-first50 {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #00CC33, #00FF41);
      border: none;
      padding: 8px 22px;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 800;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: #0a0a0f;
      box-shadow: 0 0 20px rgba(0,255,65,0.3);
      animation: offerPulse 2s ease-in-out infinite;
    }
    @media (max-width: 768px) {
      .offer-headline { font-size: 1.8rem; }
      .offer-highlight-grid { grid-template-columns: 1fr; }
      .offer-highlight-item { font-size: 0.85rem; padding: 10px 14px; }
      .offer-warning-card { padding: 1.2rem 1.5rem; }
    }
  </style>
</head>
<body>

<div class="scanlines"></div>

<!-- ====== ANNOUNCEMENT BAR ====== -->
<div class="announcement-bar">
  <div class="scroll-text">
    🔥 PREMIUM BUNDLE PACK | 2 Complete Ethical Hacking Courses | Worth ₹15,000+ | Today Only ₹199 | Save 98% | One-Time Purchase • Instant Download 🔥
  </div>
</div>

<!-- ====== NAVBAR ====== -->
<nav class="navbar navbar-expand-lg sticky-top py-2">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-shield-fill-check"></i> HIFI11 ACADEMY</a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="color:#00FF41;font-size:1.8rem;padding:4px 8px;">
      <i class="bi bi-list"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#courses">Bundle</a></li>
        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
        <li class="nav-item"><a class="nav-link" href="#founder">Founder</a></li>
        <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
        <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
        <?php if (isLoggedIn()): ?>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item ms-lg-2"><a href="logout.php" class="btn btn-outline-primary-soft rounded-pill px-4 py-2">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item ms-lg-2"><a href="#launch" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn">Download Bundle</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- ====== HERO ====== -->
<section id="home" class="premium-bg py-5 overflow-hidden" style="position:relative;">
  <div class="glow-sphere" style="width:400px;height:400px;background:#2563EB;top:-10%;left:-5%;"></div>
  <div class="glow-sphere" style="width:300px;height:300px;background:#06B6D4;bottom:-5%;right:-5%;"></div>
  <div class="grid-overlay"></div>
  <div class="container py-4 position-relative" style="z-index:1;">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <span class="badge-hero mb-3 d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill" style="background:rgba(0,255,65,0.08);border:1px solid rgba(0,255,65,0.2);">
          <i class="bi bi-rocket-takeoff" style="color:#00FF41;"></i> 🚀 PREMIUM BUNDLE PACK — 2 COMPLETE COURSES
        </span>
        <h1 class="display-3 fw-bold lh-1 mb-3" style="color:#E6EDF3;">ETHICAL HACKING <br>BUNDLE PACK</h1>
        <p class="fw-bold text-primary fs-4">தமிழிலேயே... 2 Premium Courses • Instant Download</p>
        <p class="lead text-secondary mb-3">After payment, you'll receive the complete downloadable bundle immediately. No online platform. No monthly subscription. Own the files forever. Watch offline on any device.</p>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> 2 Complete Courses</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> Instant Download After Payment</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> One-Time Purchase</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> Offline Viewing</span>
        </div>
        
        <!-- PRICING CARD -->
        <div class="pricing-card mb-4">
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Estimated Value</span>
            <span class="strike">₹15,000+</span>
          </div>
          <div class="d-flex align-items-end gap-3">
            <span class="price">₹199</span>
            <span class="badge-save">🔥 SAVE ₹14,801 • 98% OFF</span>
          </div>
          <div class="mt-1"><span class="badge" style="background:#FBBF2430;color:#FBBF24;">⏳ Limited Launch Offer • One-Time Purchase</span></div>
          <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
            <span class="badge-first50"><i class="bi bi-star-fill"></i> FIRST 50 STUDENTS ONLY</span>
            <span class="bell-shake text-warning" style="font-weight:600;font-size:0.85rem;"><i class="bi bi-bell-fill"></i> Hurry Up!</span>
          </div>
        </div>

        <div class="d-flex flex-wrap gap-3">
          <a href="#launch" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg gradient-btn">Download Bundle <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        
        <!-- Trust badges under CTA -->
        <div class="d-flex flex-wrap gap-2 mt-3">
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> Instant Download</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> Own Forever</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> 2 Premium Courses</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> Offline Access</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> No Subscription</span>
          <span class="trust-badge"><i class="bi bi-check-circle-fill"></i> Future Updates</span>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <div class="hero-image-container float-slow" style="transform:scale(1.08);">
          <img src="assets/images/banner.png" alt="Ethical Hacker" class="img-fluid" loading="lazy" />
          <div class="cyber-float" style="bottom:12%; right:8%;"><i class="bi bi-phone text-primary"></i> Android Cyber UI</div>
          <div class="cyber-float" style="top:20%; right:6%;"><i class="bi bi-code-slash text-primary"></i> Kali Terminal</div>
          <div class="cyber-float" style="bottom:30%; left:8%;"><i class="bi bi-graph-up-arrow text-success"></i> Cyber Dashboard</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,30 1440,20 L1440,60 L0,60 Z" /></svg>

<!-- ====== STATISTICS ====== -->
<section class="stats-section py-5 bg-soft-primary">
  <div class="container">
    <div class="row text-center g-4">
      <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in">
        <span class="counter h2 fw-bold text-primary" data-target="29">0</span><span class="h2 fw-bold text-primary">+</span>
        <p class="text-muted small">Practical Modules</p>
      </div>
      <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="100">
        <span class="counter h2 fw-bold text-primary" data-target="103">0</span><span class="h2 fw-bold text-primary">+</span>
        <p class="text-muted small">HD Video Lessons</p>
      </div>
      <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="200">
        <span class="counter h2 fw-bold text-primary" data-target="10">0</span><span class="h2 fw-bold text-primary">+</span>
        <p class="text-muted small">Hours of Content</p>
      </div>
      <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="300">
        <i class="bi bi-infinity h2 text-primary"></i>
        <p class="text-muted small">Lifetime Ownership</p>
      </div>
      <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="400">
        <i class="bi bi-download h2 text-primary"></i>
        <p class="text-muted small">Instant Download</p>
      </div>
      <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="500">
        <i class="bi bi-translate h2 text-primary"></i>
        <p class="text-muted small">Tamil Language</p>
      </div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider wave-divider-dark" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,0 720,60 1080,30 C1260,15 1380,30 1440,40 L1440,0 L0,0 Z" /></svg>

<!-- ====== OPENING OFFER ====== -->
<section class="py-5 premium-bg">
  <div class="container position-relative" data-aos="fade-up">
    <div class="opening-offer p-5 text-center">
      <div class="glow-overlay"></div>
      <div class="position-relative" style="z-index:1;">

        <span class="offer-badge mb-4">&#x1F680; FIRST 50 STUDENTS ONLY</span>

        <h2 class="offer-headline mb-2">&#x1F680; <span>OPENING OFFER</span></h2>
        <p class="offer-sub mb-4">Exclusive Launch Offer for the First 50 Students Only!</p>

        <p class="text-secondary mb-4" style="max-width:600px;margin-left:auto;margin-right:auto;font-size:0.95rem;">
          This special &#x20B9;199 launch price is available only for the first 50 students.
          Once the first 50 enrollments are completed, the price will automatically increase to the regular price.
        </p>

        <div class="offer-highlight-grid mb-4">
          <div class="offer-highlight-item"><i class="bi bi-fire"></i> Limited to First 50 Students</div>
          <div class="offer-highlight-item"><i class="bi bi-gem"></i> Lifetime Access</div>
          <div class="offer-highlight-item"><i class="bi bi-box-seam"></i> Master Bundle Pack</div>
          <div class="offer-highlight-item"><i class="bi bi-lightning-charge"></i> One-Time Payment</div>
        </div>

        <div class="offer-highlight-item" style="max-width:300px;margin:0 auto 28px;justify-content:center;">
          <i class="bi bi-download"></i> Instant Download
        </div>

        <div class="offer-warning-card mb-4">
          <div class="icon">&#x26A0;&#xFE0F;</div>
          <h5>Hurry!</h5>
          <p>Only the first 50 students can claim this Opening Offer.</p>
          <p>After that, the bundle price will increase.</p>
          <p class="fw-semibold" style="color:#E6EDF3;">Don't miss your chance.</p>
        </div>

        <a href="#launch" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg gradient-btn offer-cta-glow">
          Claim Your Opening Offer Now <i class="bi bi-arrow-right ms-2"></i>
        </a>

      </div>
    </div>
  </div>
</section>

<!-- ====== VALUE COMPARISON TABLE ====== -->
<section class="py-5 premium-bg">
  <div class="container">
    <h2 class="display-5 fw-bold text-center mb-3" data-aos="fade-up">Why This Bundle is Worth ₹15,000+</h2>
    <p class="text-center text-secondary mb-5" data-aos="fade-up">Everything you get — and why it's a steal at ₹199</p>

    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-8">
        <div class="value-card-wrap">
          <div class="value-header">
            <div>
              <span class="value-tag">LAUNCH OFFER</span>
              <h3 class="value-title">Ethical Hacking Bundle Pack</h3>
              <p class="value-sub">2 Premium Courses • 103+ Lessons • 10+ Hours</p>
            </div>
            <div class="value-price-box">
              <span class="value-old-price">₹15,000+</span>
              <span class="value-new-price">₹199</span>
              <span class="value-save-badge">98% OFF</span>
            </div>
          </div>

          <div class="value-items-grid">
            <div class="value-item"><i class="bi bi-play-circle-fill"></i><span>Ethical Hacking Master in Tamil</span></div>
            <div class="value-item"><i class="bi bi-play-circle-fill"></i><span>Android Hacking Masterclass</span></div>
            <div class="value-item"><i class="bi bi-file-earmark-pdf-fill"></i><span>Premium PDF Notes</span></div>
            <div class="value-item"><i class="bi bi-folder-fill"></i><span>Practice Files & Scripts</span></div>
            <div class="value-item"><i class="bi bi-tools"></i><span>Tools Collection</span></div>
            <div class="value-item"><i class="bi bi-arrow-repeat"></i><span>Future Updates Included</span></div>
          </div>

          <div class="value-footer">
            <div class="value-savings">
              <i class="bi bi-piggy-bank-fill"></i>
              <span>You save <strong>₹14,801</strong> today — limited launch pricing</span>
            </div>
            <a href="#launch" class="btn btn-primary rounded-pill px-5 py-2 gradient-btn">Get the Bundle — ₹199</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,30 1440,20 L1440,60 L0,60 Z" /></svg>

<!-- ====== COURSE BUNDLE ====== -->
<section id="courses" class="course-section py-5 bg-soft-primary">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold">Complete Premium Bundle Pack</h2>
      <p class="lead text-secondary">This is a complete downloadable bundle. Contains 2 premium hacking courses. Download starts immediately after payment. Files belong to you forever. Offline viewing supported on any device.</p>
    </div>
    <div class="row g-5 align-items-center">
      <div class="col-lg-6" data-aos="flip-left">
        <div class="bundle-box float-slow p-4" style="background:linear-gradient(145deg,#0d1117,#0a0a0f);border-radius:40px;padding:2rem 1.5rem;box-shadow:0 20px 60px -10px rgba(0,255,65,0.06),0 0 0 1px rgba(0,255,65,0.06);transition:all 0.4s;transform:perspective(1200px) rotateY(-2deg) rotateX(2deg);">
          <div class="d-flex justify-content-between align-items-start">
            <span class="badge-launch" style="background:linear-gradient(135deg,#00CC33,#00FF41);color:#0a0a0f;padding:6px 18px;border-radius:40px;font-size:0.75rem;font-weight:700;">🚀 LAUNCH BUNDLE</span>
            <div><span class="text-muted text-decoration-line-through fs-5 me-2">₹999</span><span class="fw-bold text-primary display-5">₹199</span></div>
          </div>
          <h3 class="fw-bold mt-3">ETHICAL HACKING <br>BUNDLE PACK</h3>
          <p class="text-muted small">2 Premium Courses • Instant Download • One-Time Purchase</p>
          <div class="d-flex flex-wrap gap-2 my-3">
            <span class="badge px-3 py-2" style="background:rgba(0,255,65,0.08);color:#00FF41;border:1px solid rgba(0,255,65,0.12);">2 Courses Included</span>
            <span class="badge px-3 py-2" style="background:rgba(0,255,65,0.08);color:#00FF41;border:1px solid rgba(0,255,65,0.12);">103+ Video Lessons</span>
            <span class="badge px-3 py-2" style="background:rgba(0,255,65,0.08);color:#00FF41;border:1px solid rgba(0,255,65,0.12);">Downloadable Files</span>
            <span class="badge px-3 py-2" style="background:rgba(0,255,65,0.08);color:#00FF41;border:1px solid rgba(0,255,65,0.12);">Future Updates</span>
            <span class="badge px-3 py-2" style="background:rgba(0,255,65,0.08);color:#00FF41;border:1px solid rgba(0,255,65,0.12);">Certificate</span>
            <span class="badge px-3 py-2" style="background:rgba(0,255,65,0.08);color:#00FF41;border:1px solid rgba(0,255,65,0.12);">Offline Access</span>
          </div>
          <a href="#launch" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn w-100">Buy Bundle Pack <i class="bi bi-arrow-right ms-2"></i></a>
          <p class="text-muted small mt-2 text-center">⏳ Limited Launch Offer • Instant Download After Payment</p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row g-3">
          <div class="col-6" data-aos="fade-up" data-aos-delay="100">
            <div class="device-mockup" style="background:#0d1117;border-radius:28px;padding:1.2rem;border:1px solid rgba(0,255,65,0.08);transition:all 0.3s;box-shadow:0 8px 24px rgba(0,0,0,0.2);">
              <img src="assets/images/course 2.png" alt="Course 1" loading="lazy" class="img-fluid" style="border-radius:16px;width:100%;" />
              <h6 class="mt-2 text-center fw-bold">Course 1</h6>
              <p class="small text-muted text-center">Ethical Hacking Master in Tamil</p>
              <div class="d-flex flex-wrap gap-1 justify-content-center">
                <span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Linux</span><span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Networking</span>
                <span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Nmap</span><span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Web Hacking</span>
                <span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">CTF</span><span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Android</span>
              </div>
            </div>
          </div>
          <div class="col-6" data-aos="fade-up" data-aos-delay="200">
            <div class="device-mockup" style="background:#0d1117;border-radius:28px;padding:1.2rem;border:1px solid rgba(0,255,65,0.08);transition:all 0.3s;box-shadow:0 8px 24px rgba(0,0,0,0.2);">
              <img src="assets/images/course1.png" alt="Course 2" loading="lazy" class="img-fluid" style="border-radius:16px;width:100%;" />
              <h6 class="mt-2 text-center fw-bold">Course 2</h6>
              <p class="small text-muted text-center">Android Hacking Masterclass</p>
              <div class="d-flex flex-wrap gap-1 justify-content-center">
                <span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Metasploit</span><span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Payload</span>
                <span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">ADB</span><span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">APK</span>
                <span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Port Forward</span><span class="badge border" style="background:rgba(0,255,65,0.06);color:#00FF41;border-color:rgba(0,255,65,0.12) !important;">Automation</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider wave-divider-dark" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,0 720,60 1080,30 C1260,15 1380,30 1440,40 L1440,0 L0,0 Z" /></svg>

<!-- ====== BONUS SECTION ====== -->
<section class="py-5 premium-bg">
  <div class="container">
    <h2 class="display-5 fw-bold text-center mb-3" data-aos="fade-up">🎁 What's Included in the Bundle</h2>
    <p class="text-center text-secondary mb-5" data-aos="fade-up">Everything you need — all downloadable files, yours forever</p>
    <div class="row g-4" data-aos="fade-up">
      <div class="col-6 col-md-4 col-lg-3"><div class="bonus-card"><i class="bi bi-file-pdf"></i><h6 class="mt-2">Premium PDF Notes</h6></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="bonus-card"><i class="bi bi-folder"></i><h6 class="mt-2">Practice Files</h6></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="bonus-card"><i class="bi bi-tools"></i><h6 class="mt-2">Tools Collection</h6></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="bonus-card"><i class="bi bi-arrow-repeat"></i><h6 class="mt-2">Future Updates</h6></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="bonus-card"><i class="bi bi-award"></i><h6 class="mt-2">Certificate</h6></div></div>
      <div class="col-6 col-md-4 col-lg-3"><div class="bonus-card"><i class="bi bi-people"></i><h6 class="mt-2">Private Community</h6></div></div>
    </div>
  </div>
</section>

<!-- ====== TOOLS SHOWCASE ====== -->
<section class="py-5 bg-soft-primary">
  <div class="container">
    <h2 class="display-5 fw-bold text-center mb-3" data-aos="fade-up"><i class="bi bi-tools" style="color:#00FF41;"></i> Tools You'll Master</h2>
    <p class="text-center text-secondary mb-5" data-aos="fade-up">Hands-on training with industry-standard hacking tools</p>
    <div class="row g-3 justify-content-center" data-aos="fade-up">
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-terminal-fill"></i> Kali Linux</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-shield-fill"></i> Metasploit</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-bug-fill"></i> Burp Suite</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-hdd-network-fill"></i> Nmap</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-activity"></i> Wireshark</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-lock-fill"></i> John the Ripper</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-water"></i> Hydra</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-database-fill"></i> SQLmap</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-search"></i> Dirb</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-wifi"></i> Aircrack-ng</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-cpu-fill"></i> Hashcat</div></div>
      <div class="col-4 col-md-2"><div class="tool-badge"><i class="bi bi-eyeglasses"></i> Social Eng.</div></div>
    </div>
  </div>
</section>

<style>
.tool-badge {
  background: #0d1117;
  border: 1px solid rgba(0,255,65,0.12);
  border-radius: 14px;
  padding: 0.9rem 0.5rem;
  text-align: center;
  font-size: 0.78rem;
  font-weight: 600;
  color: #E6EDF3;
  transition: all 0.25s;
  cursor: default;
}
.tool-badge i {
  display: block;
  font-size: 1.4rem;
  color: #00FF41;
  margin-bottom: 6px;
  transition: transform 0.3s;
}
.tool-badge:hover {
  border-color: #00FF4140;
  transform: translateY(-6px);
  box-shadow: 0 12px 28px -8px rgba(0,255,65,0.1);
}
.tool-badge:hover i {
  transform: scale(1.15);
}
</style>

<!-- WAVE -->
<svg class="wave-divider" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,30 1440,20 L1440,60 L0,60 Z" /></svg>

<!-- ====== WHY HIFI11 ====== -->
<section id="features" class="why-section py-5 bg-soft-primary">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold">Why Thousands Choose HIFI11 Bundle Pack</h2>
    </div>
    <div class="row g-4">
      <div class="col-6 col-md-4 col-lg-3" data-aos="flip-up"><div class="icon-feature"><i class="bi bi-box"></i><h6 class="mt-2">Premium Bundle Pack</h6><p class="text-muted small">2 Complete Courses</p></div></div>
      <div class="col-6 col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="50"><div class="icon-feature"><i class="bi bi-download"></i><h6 class="mt-2">Instant Download</h6><p class="text-muted small">After Payment</p></div></div>
      <div class="col-6 col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="100"><div class="icon-feature"><i class="bi bi-device-ssd"></i><h6 class="mt-2">Offline Viewing</h6><p class="text-muted small">On Any Device</p></div></div>
      <div class="col-6 col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="150"><div class="icon-feature"><i class="bi bi-infinity"></i><h6 class="mt-2">Own Forever</h6><p class="text-muted small">No Subscription</p></div></div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider wave-divider-dark" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,0 720,60 1080,30 C1260,15 1380,30 1440,40 L1440,0 L0,0 Z" /></svg>

<!-- ====== FOUNDER ====== -->
<section id="founder" class="py-5 premium-bg">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-md-5" data-aos="fade-right">
        <div class="p-4 rounded-4 text-center" style="background:#0d1117;border:1px solid rgba(0,255,65,0.12);box-shadow:0 12px 40px -12px rgba(0,0,0,0.3);">
          <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:160px;height:160px;background:rgba(0,255,65,0.06);border:3px solid rgba(0,255,65,0.15);">
            <i class="bi bi-person-fill" style="font-size:4rem;color:#00FF4160;"></i>
          </div>
          <h3 class="fw-bold">SURYA PRAKASH E</h3>
          <p class="text-muted">Founder &amp; CEO — HIFI11 Technologies</p>
          <p class="text-secondary">எல்லோருக்கும் தரமான Cyber Security Education கிடைக்க வேண்டும் என்பதற்காக HIFI11 Academy உருவாக்கப்பட்டது. ₹15,000+ மதிப்புள்ள Premium Bundle Pack-ஐ Launch Offer-ஆக வெறும் ₹199-க்கு வழங்குகிறோம். இது ஒரு Limited Time Launch Offer. Instant Download.</p>
          <div class="d-flex flex-wrap gap-2 justify-content-center">
            <span class="badge p-2" style="background:rgba(0,255,65,0.12);color:#00FF41;">Founder</span>
            <span class="badge p-2" style="background:rgba(0,255,65,0.08);color:#00FF41;">CEO</span>
            <span class="badge p-2" style="background:rgba(0,255,65,0.06);color:#00FF41;">Cyber Security Trainer</span>
            <span class="badge p-2" style="background:#FBBF2430;color:#FBBF24;">Entrepreneur</span>
          </div>
        </div>
      </div>
      <div class="col-md-7" data-aos="fade-left">
        <h2 class="display-5 fw-bold">About the founder</h2>
        <p class="lead text-secondary">Making Premium Cyber Security Education Affordable for Everyone.</p>
        <img src="assets/images/about.png" alt="About us" class="img-fluid rounded-4 shadow-sm float-slow" loading="lazy" />
      </div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,30 1440,20 L1440,60 L0,60 Z" /></svg>

<!-- ====== TESTIMONIALS ====== -->
<section id="testimonials" class="py-5 bg-soft-primary">
  <div class="container">
    <h2 class="display-5 fw-bold text-center mb-5" data-aos="fade-up">What Our Customers Say</h2>
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up">
        <div class="glass-card p-4 text-center">
          <div class="mb-2"><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i></div>
          <p class="text-secondary">"₹199க்கு இவ்வளவு Premium Quality Bundle கிடைக்கும் என்று எதிர்பார்க்கவில்லை."</p>
          <div class="d-flex align-items-center justify-content-center gap-2"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face&q=80" class="rounded-circle" width="40" height="40" alt="" /><div><h6 class="mb-0">Karthik R.</h6><span class="text-muted small">Customer</span></div></div>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="glass-card p-4 text-center">
          <div class="mb-2"><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i></div>
          <p class="text-secondary">"தமிழில் Ethical Hacking கற்றுக்கொள்ள இதைவிட சிறந்த Bundle இல்லை."</p>
          <div class="d-flex align-items-center justify-content-center gap-2"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=40&h=40&fit=crop&crop=face&q=80" class="rounded-circle" width="40" height="40" alt="" /><div><h6 class="mb-0">Divya S.</h6><span class="text-muted small">Developer</span></div></div>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="glass-card p-4 text-center">
          <div class="mb-2"><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i></div>
          <p class="text-secondary">"Linux முதல் Android Hacking வரை அனைத்தும் Practical. Download உடனே கிடைச்சது."</p>
          <div class="d-flex align-items-center justify-content-center gap-2"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=40&h=40&fit=crop&crop=face&q=80" class="rounded-circle" width="40" height="40" alt="" /><div><h6 class="mb-0">Arun M.</h6><span class="text-muted small">Freelancer</span></div></div>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="glass-card p-4 text-center">
          <div class="mb-2"><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i><i class="bi bi-star-fill text-warning"></i></div>
          <p class="text-secondary">"College Students கண்டிப்பாக வாங்க வேண்டிய Bundle Pack."</p>
          <div class="d-flex align-items-center justify-content-center gap-2"><img src="https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?w=40&h=40&fit=crop&crop=face&q=80" class="rounded-circle" width="40" height="40" alt="" /><div><h6 class="mb-0">Priya V.</h6><span class="text-muted small">Beginner</span></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider wave-divider-dark" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,0 720,60 1080,30 C1260,15 1380,30 1440,40 L1440,0 L0,0 Z" /></svg>

<!-- ====== FAQ ====== -->
<section id="faq" class="py-5 premium-bg">
  <div class="container">
    <h2 class="display-5 fw-bold text-center mb-3" data-aos="fade-up">Frequently Asked Questions</h2>
    <p class="text-center text-secondary mb-5" data-aos="fade-up">Got questions? We've got answers.</p>
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-8">
        <div class="faq-list">
          <div class="faq-item">
            <button class="faq-q" onclick="faqToggle(this)">
              <span class="faq-prompt">$</span>
              <span class="faq-q-text">Is this a downloadable bundle?</span>
              <i class="bi bi-chevron-down faq-arrow"></i>
            </button>
            <div class="faq-a">Yes! This is a premium digital bundle pack. After payment, you'll receive instant download links for all files.</div>
          </div>
          <div class="faq-item">
            <button class="faq-q" onclick="faqToggle(this)">
              <span class="faq-prompt">$</span>
              <span class="faq-q-text">Is this an online course platform?</span>
              <i class="bi bi-chevron-down faq-arrow"></i>
            </button>
            <div class="faq-a">No. This is NOT an online learning platform. No monthly subscription. You get downloadable files that you own forever.</div>
          </div>
          <div class="faq-item">
            <button class="faq-q" onclick="faqToggle(this)">
              <span class="faq-prompt">$</span>
              <span class="faq-q-text">Can I watch offline?</span>
              <i class="bi bi-chevron-down faq-arrow"></i>
            </button>
            <div class="faq-a">Absolutely! All files are downloadable. Watch offline on your mobile, tablet, or PC anytime.</div>
          </div>
          <div class="faq-item">
            <button class="faq-q" onclick="faqToggle(this)">
              <span class="faq-prompt">$</span>
              <span class="faq-q-text">Is this suitable for beginners?</span>
              <i class="bi bi-chevron-down faq-arrow"></i>
            </button>
            <div class="faq-a">Yes. The bundle starts from basics and goes step-by-step. No prior experience needed.</div>
          </div>
          <div class="faq-item">
            <button class="faq-q" onclick="faqToggle(this)">
              <span class="faq-prompt">$</span>
              <span class="faq-q-text">Will I get future updates?</span>
              <i class="bi bi-chevron-down faq-arrow"></i>
            </button>
            <div class="faq-a">Yes, future bundle updates are included at no extra cost.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.faq-list { display: flex; flex-direction: column; gap: 10px; }
.faq-item {
  background: #0d1117;
  border: 1px solid rgba(0,255,65,0.1);
  border-radius: 16px;
  overflow: hidden;
  transition: border-color 0.3s;
}
.faq-item:hover { border-color: rgba(0,255,65,0.25); }
.faq-q {
  width: 100%; display: flex; align-items: center; gap: 12px;
  padding: 1.1rem 1.5rem; background: none; border: none;
  color: #E6EDF3; font-weight: 600; font-size: 0.95rem;
  text-align: left; cursor: pointer; transition: all 0.2s;
}
.faq-q:hover { background: rgba(0,255,65,0.03); }
.faq-prompt {
  font-family: 'Space Grotesk', monospace;
  color: #00FF41; font-weight: 700; font-size: 1rem;
  flex-shrink: 0;
}
.faq-q-text { flex: 1; }
.faq-arrow {
  color: #00FF4160; font-size: 0.85rem; flex-shrink: 0;
  transition: transform 0.3s;
}
.faq-item.open .faq-arrow { transform: rotate(180deg); }
.faq-a {
  max-height: 0; overflow: hidden; transition: all 0.35s ease;
  padding: 0 1.5rem 0 1.5rem; color: #8B949E; font-size: 0.9rem;
  line-height: 1.6; border-top: 0 solid rgba(0,255,65,0.08);
}
.faq-item.open .faq-a {
  max-height: 200px; padding: 0 1.5rem 1.2rem 1.5rem;
  border-top-width: 1px;
}
@media (max-width: 768px) {
  .faq-q { padding: 0.9rem 1.2rem; font-size: 0.88rem; }
  .faq-a { padding: 0 1.2rem 0 1.2rem; font-size: 0.85rem; }
  .faq-item.open .faq-a { padding: 0 1.2rem 1rem 1.2rem; }
}
</style>
<script>
function faqToggle(btn) {
  var item = btn.parentElement;
  var open = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(function(el) {
    el.classList.remove('open');
  });
  if (!open) item.classList.add('open');
}
</script>

<!-- WAVE -->
<svg class="wave-divider" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,30 1440,20 L1440,60 L0,60 Z" /></svg>

<!-- ====== CONTACT SECTION ====== -->
<section id="contact" class="py-5 bg-soft-primary">
  <div class="container">
    <h2 class="display-5 fw-bold text-center mb-4" data-aos="fade-up">Connect With Us</h2>
    <p class="text-center text-secondary mb-5" data-aos="fade-up">Reach out anytime — we're here to help!</p>
    <div class="contact-social-links" data-aos="fade-up">
      <a href="tel:+919380386500" class="whatsapp"><i class="bi bi-whatsapp"></i> +91 9380386500</a>
      <a href="https://instagram.com/_devil_heart_hacker" target="_blank" class="instagram"><i class="bi bi-instagram"></i> @_devil_heart_hacker</a>
      <a href="https://t.me/devil_heart_hack" target="_blank" class="telegram"><i class="bi bi-telegram"></i> @devil_heart_hack</a>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider wave-divider-dark" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,0 720,60 1080,30 C1260,15 1380,30 1440,40 L1440,0 L0,0 Z" /></svg>

<!-- ====== FINAL CTA ====== -->
<section id="launch" class="py-5 bg-soft-primary">
  <div class="container">
    <div class="cta-apple text-white text-center" data-aos="flip-up">
      <div class="glow-ring"></div>
      <span class="badge px-4 py-2 rounded-pill mb-3" style="background:rgba(0,255,65,0.12);color:#00FF41;border:1px solid rgba(0,255,65,0.2);">🔥 Limited Launch Offer • One-Time Purchase</span>
      <div class="mb-3 d-flex justify-content-center align-items-center gap-3 flex-wrap">
        <span class="badge-first50"><i class="bi bi-star-fill"></i> FIRST 50 STUDENTS ONLY</span>
        <span class="bell-shake text-warning" style="font-weight:600;font-size:0.95rem;"><i class="bi bi-bell-fill"></i> Hurry Up!</span>
      </div>
      <h2 class="display-3 fw-bold">Download Your Bundle Today</h2>
      <p class="lead opacity-75">இன்று Download செய்து உங்கள் Cyber Security Career-ஐ ஆரம்பியுங்கள். Instant Download After Payment.</p>
      
      <div class="d-flex justify-content-center align-items-center gap-4 my-4 flex-wrap">
        <div><span class="text-white-50 text-decoration-line-through fs-3">₹15,000+</span><br><span class="text-white-50 small">Estimated Value</span></div>
        <div><span class="fw-bold display-1">₹199</span><br><span class="small opacity-75">Today Only</span></div>
        <div><span class="badge-save" style="font-size:1.2rem;padding:8px 24px;">SAVE ₹14,801 • 98% OFF</span></div>
      </div>
      
      <a href="checkout.php" class="btn btn-apple ripple">🚀 GET DOWNLOAD NOW</a>
      <p class="mt-3 opacity-75 small">⚡ Instant Download • One-Time Payment • Own Forever • No Subscription</p>
      
      <!-- Countdown -->
      <div class="countdown mt-3" id="countdown">
        <div class="unit"><div class="num" id="hours">12</div><div class="label">Hours</div></div>
        <span class="sep">:</span>
        <div class="unit"><div class="num" id="minutes">45</div><div class="label">Minutes</div></div>
        <span class="sep">:</span>
        <div class="unit"><div class="num" id="seconds">30</div><div class="label">Seconds</div></div>
      </div>
      <div class="urgent-text"><i class="bi bi-lightning-charge-fill"></i> Hurry! Offer ends soon</div>
    </div>
  </div>
</section>

<!-- WAVE -->
<svg class="wave-divider wave-divider-dark" viewBox="0 0 1440 60" preserveAspectRatio="none"><path d="M0,30 C360,0 720,60 1080,30 C1260,15 1380,30 1440,40 L1440,0 L0,0 Z" /></svg>

<!-- ====== FOOTER ====== -->
<footer class="footer py-5" style="background:#050508;color:#8B949E;">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h5 class="fw-bold" style="color:#E6EDF3;"><i class="bi bi-shield-fill-check" style="color:#00FF41;"></i> HIFI11 ACADEMY</h5>
        <p class="small">🔥 HIFI11 Launch Batch 2026<br>Premium Digital Bundle Pack — Instant Download, Own Forever.</p>
        <p class="small"><i class="bi bi-phone me-2"></i> +91 9380386500</p>
        <p class="small"><i class="bi bi-instagram me-2"></i> <a href="https://instagram.com/_devil_heart_hacker" target="_blank" style="color:#E6EDF3;text-decoration:none;">@_devil_heart_hacker</a></p>
        <p class="small"><i class="bi bi-telegram me-2"></i> <a href="https://t.me/devil_heart_hack" target="_blank" style="color:#E6EDF3;text-decoration:none;">@devil_heart_hack</a></p>
      </div>
      <div class="col-md-2">
        <h6 style="color:#E6EDF3;">Quick Links</h6>
        <ul class="list-unstyled small">
          <li><a href="#home" style="color:#8B949E;text-decoration:none;">Home</a></li>
          <li><a href="#courses" style="color:#8B949E;text-decoration:none;">Bundle</a></li>
          <li><a href="#features" style="color:#8B949E;text-decoration:none;">Features</a></li>
          <li><a href="#founder" style="color:#8B949E;text-decoration:none;">Founder</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h6 style="color:#E6EDF3;">About</h6>
        <ul class="list-unstyled small">
          <li><a href="#testimonials" style="color:#8B949E;text-decoration:none;">Testimonials</a></li>
          <li><a href="#faq" style="color:#8B949E;text-decoration:none;">FAQ</a></li>
          <li><a href="#contact" style="color:#8B949E;text-decoration:none;">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-4 text-md-end">
        <h6 style="color:#E6EDF3;">Founder</h6>
        <p class="small mb-0">SURYA PRAKASH E</p>
        <p class="small" style="color:#484F58;">CEO, HIFI11 Technologies</p>
        <p class="small mt-3 mb-0">&copy; 2026 HIFI11 Academy. All Rights Reserved.</p>
        <p class="small" style="color:#484F58;">Made with care in Tamil Nadu, India.</p>
      </div>
    </div>
  </div>
</footer>

<!-- ====== FLOATING SOCIAL BUTTONS ====== -->
<a href="https://wa.me/919380386500" target="_blank" class="social-float whatsapp" aria-label="WhatsApp">
  <i class="bi bi-whatsapp"></i>
  <span class="tooltip-text">WhatsApp</span>
</a>
<a href="https://instagram.com/_devil_heart_hacker" target="_blank" class="social-float instagram" aria-label="Instagram">
  <i class="bi bi-instagram"></i>
  <span class="tooltip-text">Instagram</span>
</a>
<a href="https://t.me/devil_heart_hack" target="_blank" class="social-float telegram" aria-label="Telegram">
  <i class="bi bi-telegram"></i>
  <span class="tooltip-text">Telegram</span>
</a>
<a href="#" class="social-float top" id="scrollTop" aria-label="Scroll to top">
  <i class="bi bi-chevron-up"></i>
  <span class="tooltip-text">Back to top</span>
</a>

<!-- ====== STICKY MOBILE BUY ====== -->
<div class="sticky-mobile-buy">
  <div><span class="price">₹199</span> <span class="text-muted small text-decoration-line-through">₹15,000+</span></div>
  <a href="#launch" class="btn btn-primary gradient-btn">Download Bundle</a>
</div>

<!-- ====== LIVE DOWNLOAD NOTIFICATIONS ====== -->
<div class="download-notification" id="downloadNotif">
  <div class="d-flex align-items-start gap-3">
    <div class="avatar" id="notifAvatar">AK</div>
    <div class="notif-text flex-grow-1">
      <div><span class="online-dot"></span> <strong id="notifName">Aravind</strong></div>
      <div class="action" id="notifAction">just downloaded the bundle 🎉</div>
      <div class="time">Just now</div>
    </div>
  </div>
</div>

<!-- ====== SCRIPTS ====== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  (function() {
    AOS.init({ once: false, duration: 800 });

    // ====== STATISTICS COUNTERS ======
    const counters = document.querySelectorAll('.counter');
    const speed = 70;
    const animateCounter = (el) => {
      const target = parseInt(el.getAttribute('data-target'));
      let current = 0;
      const inc = Math.ceil(target / 35);
      const timer = setInterval(() => {
        current += inc;
        if (current >= target) { el.textContent = target; clearInterval(timer); } 
        else el.textContent = current;
      }, speed);
    };
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach(e => { if(e.isIntersecting) { animateCounter(e.target); counterObserver.unobserve(e.target); } });
    }, { threshold: 0.4 });
    counters.forEach(c => counterObserver.observe(c));

    // ====== LIVE DOWNLOAD NOTIFICATIONS ======
    const notif = document.getElementById('downloadNotif');
    const notifName = document.getElementById('notifName');
    const notifAction = document.getElementById('notifAction');
    const notifAvatar = document.getElementById('notifAvatar');

    const usernames = [
      'Aravind', 'Karthik', 'Priya', 'Vignesh', 'Sanjay', 'Harini', 'Dinesh', 'Ajith',
      'Gokul', 'Deepika', 'Suresh', 'Anjali', 'Vijay', 'Meena', 'Rahul', 'Kavya',
      'Arun', 'Swathi', 'Prakash', 'Nandhini', 'Murali', 'Divya', 'Sathish', 'Lakshmi',
      'Ganesh', 'Bharath', 'Sneha', 'Ravi', 'Pavithra', 'Kumar', 'Anitha', 'Selvam',
      'Jothi', 'Mani', 'Vasanthi', 'Murugan', 'Malar', 'Saravanan', 'Ezhil', 'Kayal',
      'Tharun', 'Nisha', 'Kishore', 'Janani', 'Vinoth', 'Saranya', 'Prabhu', 'Indhu',
      'Mohan', 'Rekha', 'Gowtham', 'Sowmiya', 'Devi', 'Ranjith', 'Keerthi', 'Dhanush',
      'Abirami', 'Bala', 'Chitra', 'Eswar', 'Gayathri', 'Hari', 'Ishwarya', 'Jagan'
    ];

    const actions = [
      'just downloaded the bundle 🎉',
      'purchased the bundle pack 🔥',
      'got instant download 🚀',
      'downloaded successfully ✅',
      'bought the launch bundle ⚡',
      'got the premium bundle ✨',
      'is now a HIFI11 customer 🛡️',
      'downloaded both courses 📚'
    ];

    let usedIndices = [];
    let currentTimeout = null;

    function getRandomUser() {
      if (usedIndices.length >= usernames.length) usedIndices = [];
      let idx;
      do {
        idx = Math.floor(Math.random() * usernames.length);
      } while (usedIndices.includes(idx));
      usedIndices.push(idx);
      return usernames[idx];
    }

    function getRandomAction() {
      return actions[Math.floor(Math.random() * actions.length)];
    }

    function getInitials(name) {
      return name.substring(0, 2).toUpperCase();
    }

    function showNotification() {
      const name = getRandomUser();
      const action = getRandomAction();
      
      notifName.textContent = name;
      notifAction.textContent = action;
      notifAvatar.textContent = getInitials(name);

      notif.classList.remove('hide');
      notif.classList.add('show');

      if (currentTimeout) clearTimeout(currentTimeout);
      currentTimeout = setTimeout(() => {
        notif.classList.remove('show');
        notif.classList.add('hide');
        const delay = 4000 + Math.random() * 4000;
        setTimeout(() => {
          showNotification();
        }, delay);
      }, 3500);
    }

    setTimeout(() => {
      showNotification();
    }, 3000);

    // Scroll to top
    document.getElementById('scrollTop').addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === "#") return;
        const target = document.querySelector(href);
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
      });
    });

    // Countdown timer
    let totalSeconds = 12 * 3600 + 45 * 60 + 30;
    const hoursEl = document.getElementById('hours');
    const minutesEl = document.getElementById('minutes');
    const secondsEl = document.getElementById('seconds');
    function pulseEl(el) {
      el.classList.remove('pulse');
      void el.offsetWidth;
      el.classList.add('pulse');
    }
    setInterval(() => {
      if (totalSeconds <= 0) return;
      totalSeconds--;
      const h = Math.floor(totalSeconds / 3600);
      const m = Math.floor((totalSeconds % 3600) / 60);
      const s = totalSeconds % 60;
      hoursEl.textContent = String(h).padStart(2, '0');
      minutesEl.textContent = String(m).padStart(2, '0');
      secondsEl.textContent = String(s).padStart(2, '0');
      pulseEl(secondsEl);
    }, 1000);

  })();
</script>
</body>
</html>