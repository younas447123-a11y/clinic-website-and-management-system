<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $pageTitle ?? 'Clinic Management System'; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (only for layout, not for mobile menu) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* ========== HEADER (STICKY, GLASS) ========== */
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            z-index: 1000;
            transition: all 0.3s;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .site-header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo a {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-decoration: none;
        }
        /* Desktop nav */
        .nav-desktop {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-desktop a {
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-desktop a:hover {
            color: #0ea5e9;
        }
        .btn-book {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            color: white !important;
            padding: 0.5rem 1.2rem;
            border-radius: 9999px;
            font-weight: 600;
        }
        /* Hamburger button (mobile only) */
        .menu-btn {
            display: none;
            background: #0ea5e9;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 8px;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        /* ========== MOBILE MENU (SOLID WHITE) ========== */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            width: 280px;
            height: 100%;
            background: #ffffff;  /* SOLID WHITE */
            box-shadow: -5px 0 25px rgba(0,0,0,0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1100;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        .mobile-menu .close-mobile {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        .mobile-menu a {
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 1rem;
        }
        .mobile-menu a:last-of-type {
            border-bottom: none;
        }
        .mobile-menu .mobile-book {
            margin-top: 1.5rem;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            color: white !important;
            text-align: center;
            padding: 0.7rem;
            border-radius: 9999px;
            border-bottom: none;
        }
        /* Overlay */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1050;
            display: none;
        }
        .menu-overlay.active {
            display: block;
        }
        /* Responsive */
        @media (max-width: 1024px) {
            .nav-desktop {
                display: none;
            }
            .menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        @media (min-width: 1025px) {
            .mobile-menu, .menu-overlay {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<header class="site-header" id="mainHeader">
    <div class="header-container">
        <div class="logo">
            <a href="index.php">CliniCare+</a>
        </div>
        
        <div class="nav-desktop">
            <a href="index.php">Home</a>
            <a href="doctors.php">Doctors</a>
            <a href="services.php">Services</a>
            <a href="clinics.php">Clinics</a>
            <a href="case-studies.php">Case Studies</a>
            <a href="support.php">Support</a>
            <a href="appointment.php" class="btn-book">Book Now</a>
        </div>
        
        <button class="menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<!-- Mobile Menu Panel (Solid White) -->
<div id="mobileMenuPanel" class="mobile-menu">
    <button class="close-mobile" id="closeMobileBtn">&times;</button>
    <a href="index.php">Home</a>
    <a href="doctors.php">Doctors</a>
    <a href="services.php">Services</a>
    <a href="clinics.php">Clinics</a>
    <a href="case-studies.php">Case Studies</a>
    <a href="support.php">Support</a>
    <a href="appointment.php" class="mobile-book">Book Appointment</a>
</div>
<div id="menuOverlay" class="menu-overlay"></div>

<script>
    (function() {
        const menuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenuPanel');
        const closeBtn = document.getElementById('closeMobileBtn');
        const overlay = document.getElementById('menuOverlay');
        
        function openMenu() {
            mobileMenu.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeMenu() {
            mobileMenu.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (menuBtn) menuBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);
        
        // Sticky header effect
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        });
    })();
</script>

<main class="pt-20">