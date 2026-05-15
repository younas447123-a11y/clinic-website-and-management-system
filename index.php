<?php
require_once 'config/database.php';

// Fetch featured doctors (limit 4)
$featuredDoctors = mysqli_query($conn, "SELECT * FROM doctors WHERE featured = 1 LIMIT 4");

// Fetch services grouped by category (for homepage, get 6 recent)
$services = mysqli_query($conn, "SELECT s.*, c.name as cat_name FROM services s LEFT JOIN categories c ON s.category_id = c.id WHERE c.type='service' ORDER BY s.id DESC LIMIT 6");

// Fetch case studies (latest 3)
$caseStudies = mysqli_query($conn, "SELECT cs.*, d.name as doctor_name FROM case_studies cs LEFT JOIN doctors d ON cs.doctor_id = d.id ORDER BY cs.id DESC LIMIT 3");

// Fetch testimonials (approved reviews)
$testimonials = mysqli_query($conn, "SELECT * FROM reviews WHERE is_approved = 1 ORDER BY id DESC LIMIT 3");

$pageTitle = "Home - Premium Clinic";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts: Inter & Outfit premium combo -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <style>
        /* ---------- Custom Premium Medical UI ---------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1e293b;
            scroll-behavior: smooth;
        }
        /* Glassmorphism Navbar (works with existing header.php) */
        .site-header {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(12px) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
            transition: all 0.3s ease;
        }
        .site-header.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 8px 30px rgba(0,0,0,0.05) !important;
        }
        /* Custom card hover animations */
        .service-card, .doctor-card, .case-study-card, .testimonial-card {
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .service-card:hover, .doctor-card:hover, .case-study-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 35px -12px rgba(0, 0, 0, 0.15);
            border-color: rgba(14, 165, 233, 0.3);
        }
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.1);
        }
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        /* Hero floating shapes */
        .floating-shape {
            position: absolute;
            background: radial-gradient(circle, rgba(14,165,233,0.15) 0%, rgba(6,182,212,0.05) 100%);
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
            pointer-events: none;
        }
        /* Animated button hover */
        .btn-gradient {
            background: linear-gradient(95deg, #0ea5e9, #06b6d4);
            transition: all 0.3s ease;
            background-size: 200% auto;
        }
        .btn-gradient:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(14,165,233,0.4);
        }
        /* Section titles */
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
            position: relative;
            display: inline-block;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #0ea5e9, #06b6d4);
            border-radius: 3px;
        }
        /* Image hover zoom */
        .card-img-hover {
            overflow: hidden;
            border-radius: 1rem 1rem 0 0;
        }
        .card-img-hover img {
            transition: transform 0.5s ease;
        }
        .service-card:hover .card-img-hover img,
        .doctor-card:hover .card-img-hover img,
        .case-study-card:hover .card-img-hover img {
            transform: scale(1.05);
        }
        /* Responsive tweaks */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem !important;
            }
            .section-title {
                font-size: 1.8rem;
            }
        }
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        /* Animated counters (if any numbers appear) */
        .counter {
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="antialiased">

<?php include 'includes/header.php'; ?>

<main class="overflow-hidden">
    
    <!-- ========== HERO SECTION (Enhanced) ========== -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-white via-sky-50 to-white pt-20">
        <!-- Floating background shapes -->
        <div class="floating-shape w-96 h-96 -top-20 -left-20">
    
        </div>
        <div class="floating-shape w-96 h-96 bottom-0 right-0 opacity-60"></div>
        <div class="absolute top-1/4 right-10 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-5 py-16 lg:py-24 z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm rounded-full px-4 py-1.5 shadow-sm border border-gray-100 mb-6">
                        <i class="fas fa-stethoscope text-sky-600 text-sm"></i>
                        <span class="text-sm font-semibold text-gray-700">Excellence in Healthcare</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
                        Welcome to <span class="gradient-text">Your Health</span><br>Our Priority
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-lg">
                        Experience world‑class medical services with our team of specialists. Book your appointment online and receive personalized care.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="support.php" class="btn-gradient inline-flex items-center gap-2 text-white px-7 py-3 rounded-full font-semibold shadow-lg transition">
                            Book Appointment <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="services.php" class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-7 py-3 rounded-full font-semibold transition shadow-sm">
                            Explore Services
                        </a>
                    </div>
                    <!-- Trust badges -->
                    <div class="mt-10 flex flex-wrap gap-6 text-sm text-gray-500">
                        <div class="flex items-center gap-2"><i class="fas fa-user-md text-sky-600"></i> <span>50+ Specialists</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-smile text-sky-600"></i> <span>98% Satisfaction</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-calendar-check text-sky-600"></i> <span>24/7 Booking</span></div>
                    </div>
                </div>
                <div class="relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="assets\uploads\Adobe Express - file (1).png" alt="Medical consultation" class="w-full h-auto object-cover">
                    </div>
                    <div class="absolute -bottom-5 -left-5 bg-white rounded-xl shadow-lg p-3 flex items-center gap-3 backdrop-blur-sm border border-gray-100">
                        <i class="fas fa-star text-yellow-500"></i>
                        <div><p class="text-xs text-gray-500">Rated 4.9/5</p><p class="font-bold text-gray-800">by 2,500+ patients</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SERVICES SECTION ========== -->
    <section class="py-20 bg-white" data-aos="fade-up" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center mb-14">
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">What We Offer</span>
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-900 mt-2">Our Medical Services</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Advanced diagnostics, personalized treatments, and compassionate care.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while($service = mysqli_fetch_assoc($services)): ?>
                <div class="service-card bg-white rounded-2xl shadow-md overflow-hidden transition-all">
                    <div class="card-img-hover h-48 bg-gray-100">
                        <?php if($service['image']): ?>
                            <img src="<?php echo $service['image']; ?>" alt="<?php echo htmlspecialchars($service['name']); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-notes-medical text-4xl"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <div class="inline-block text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-1 rounded-full"><?php echo htmlspecialchars($service['cat_name']); ?></div>
                        <h3 class="text-xl font-bold text-gray-800 mt-3 mb-2"><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo substr(htmlspecialchars($service['description']), 0, 100); ?>...</p>
                        <a href="service-detail.php?id=<?php echo $service['id']; ?>" class="inline-flex items-center text-sky-600 font-semibold mt-4 hover:gap-2 transition-all gap-1">Learn More <i class="fas fa-arrow-right text-xs"></i></a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Why Choose Us - Hedox Style</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles for refined elegance */
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .gradient-border {
            position: relative;
            background: white;
            transition: all 0.3s ease;
        }
        .gradient-border:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        .gradient-border::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #D4AF37, #B8860B);
            transition: width 0.4s ease;
        }
        .gradient-border:hover::after {
            width: 80px;
        }
        .icon-gradient {
            background: linear-gradient(135deg, #F5E6D3, #E8D5B7);
        }
        .text-gold {
            color: #C6A43B;
        }
        .bg-gold-light {
            background: rgba(198, 164, 59, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Hero Section with Natural Results Focus -->
    <div class="relative bg-gradient-to-br from-white via-gray-50 to-white overflow-hidden">
        <!-- Abstract background element -->
        <div class="absolute right-0 top-0 -mt-20 -mr-20 w-96 h-96 bg-gold-light rounded-full blur-3xl opacity-30"></div>
        <div class="absolute left-0 bottom-0 -mb-20 -ml-20 w-96 h-96 bg-gold-light rounded-full blur-3xl opacity-30"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8">
            <!-- Tagline -->
            <div class="text-center mb-6">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gold-light text-gold text-sm font-medium tracking-wide">
                    <i class="fas fa-leaf text-xs"></i>
                    NATURAL RESULTS
                </span>
            </div>
            
            <!-- Main Headline -->
            <div class="text-center max-w-3xl mx-auto mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Achieve 
                    <span class="relative inline-block">
                        <span class="relative z-10">Natural Results</span>
                        <svg class="absolute bottom-2 left-0 w-full h-3 text-gold z-0" viewBox="0 0 200 10" fill="currentColor" opacity="0.3">
                            <path d="M0,5 C20,2 40,8 60,5 C80,2 100,8 120,5 C140,2 160,8 180,5 L200,5" stroke="currentColor" stroke-width="3" fill="none"/>
                        </svg>
                    </span>
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Experience advanced aesthetic treatments for a <span class="font-medium text-gold">refreshed and rejuvenated</span> look.
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                <!-- Card 1: Natural Results -->
                <div class="gradient-border rounded-2xl p-8 text-center bg-white shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="icon-gradient w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-spa text-2xl text-gold"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Achieve Natural Results</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Experience advanced aesthetic treatments for a refreshed and rejuvenated look.
                    </p>
                </div>
                
                <!-- Card 2: Safe & Effective -->
                <div class="gradient-border rounded-2xl p-8 text-center bg-white shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="icon-gradient w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-shield-alt text-2xl text-gold"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Safe and Effective Treatments</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Our highly trained Doctors provide safe and effective treatments.
                    </p>
                </div>
                
                <!-- Card 3: Enhance Beauty -->
                <div class="gradient-border rounded-2xl p-8 text-center bg-white shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="icon-gradient w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-gem text-2xl text-gold"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Enhance Your Beauty</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Discover a range of treatments to enhance your natural beauty.
                    </p>
                </div>
                
                <!-- Card 4: Relaxed Atmosphere -->
                <div class="gradient-border rounded-2xl p-8 text-center bg-white shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="icon-gradient w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-peace text-2xl text-gold"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Relaxed Atmosphere</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Enjoy a low-key and relaxed atmosphere during your visit at Hedox Clinic.
                    </p>
                </div>
            </div>
            
            <!-- Bottom Statement (Natural Results Promise) -->
            <div class="mt-20 text-center">
                <div class="inline-block p-6 rounded-2xl bg-white border border-gray-100 shadow-sm max-w-2xl">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <i class="fas fa-quote-left text-gold text-2xl opacity-70"></i>
                        <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider">The Hedox Promise</span>
                        <i class="fas fa-quote-right text-gold text-2xl opacity-70"></i>
                    </div>
                    <p class="text-gray-700 text-lg italic">
                        "Our treatments leave you looking refreshed and great, not fake — that's the <span class="font-semibold text-gold">people-notice-but-can't-place</span> look."
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

    <!-- ========== FEATURED DOCTORS SECTION ========== -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white" data-aos="fade-up" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center mb-14">
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">Meet Our Experts</span>
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-900 mt-2">Experienced Specialists</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Dedicated professionals committed to your well-being.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php while($doctor = mysqli_fetch_assoc($featuredDoctors)): ?>
                <div class="doctor-card bg-white rounded-2xl shadow-md overflow-hidden transition-all text-center">
                    <div class="card-img-hover h-56 w-full">
                        <img src="<?php echo !empty($doctor['image']) ? $doctor['image'] : 'assets/uploads/default-avatar.png'; ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($doctor['name']); ?></h3>
                        <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars(substr($doctor['qualification'], 0, 60)); ?></p>
                        <a href="doctor-detail.php?id=<?php echo $doctor['id']; ?>" class="inline-block mt-4 text-sky-600 font-medium hover:text-sky-800 transition">View Profile →</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- ========== CASE STUDIES SECTION ========== -->
    <section class="py-20 bg-white" data-aos="fade-up" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center mb-14">
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">Success Stories</span>
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-900 mt-2">Case Studies</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Real patients, real results – see how we've transformed lives.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while($case = mysqli_fetch_assoc($caseStudies)): ?>
                <div class="case-study-card bg-white rounded-2xl shadow-md overflow-hidden transition-all">
                    <div class="card-img-hover h-48">
                        <img src="<?php echo !empty($case['featured_image']) ? $case['featured_image'] : 'https://placehold.co/600x400/0891b2/ffffff?text=Case+Study'; ?>" alt="<?php echo htmlspecialchars($case['title']); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($case['title']); ?></h3>
                        <p class="text-sm text-gray-500 mt-1">By Dr. <?php echo htmlspecialchars($case['doctor_name']); ?></p>
                        <a href="case-study-detail.php?id=<?php echo $case['id']; ?>" class="inline-flex items-center text-sky-600 font-semibold mt-3 hover:gap-2 transition-all gap-1">Read Story <i class="fas fa-arrow-right text-xs"></i></a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- ========== TESTIMONIALS SECTION ========== -->
    <?php if(mysqli_num_rows($testimonials) > 0): ?>
    <section class="py-20 bg-gradient-to-r from-sky-50 to-cyan-50" data-aos="fade-up" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center mb-14">
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">What Our Patients Say</span>
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-900 mt-2">Testimonials</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while($test = mysqli_fetch_assoc($testimonials)): ?>
                <div class="testimonial-card bg-white p-6 rounded-2xl shadow-lg transition-all">
                    <div class="flex gap-1 text-yellow-500 mb-4">
                        <?php for($i=1; $i<=5; $i++): echo $i <= $test['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; endfor; ?>
                    </div>
                    <p class="text-gray-700 italic">“<?php echo htmlspecialchars(substr($test['comment'], 0, 150)); ?>”</p>
                    <h4 class="font-bold text-gray-900 mt-4">- <?php echo htmlspecialchars($test['patient_name']); ?></h4>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== BOTTOM CTA SECTION (Trust & Booking) ========== -->
    <section class="py-20 bg-gradient-to-r from-slate-800 to-slate-900 text-white" data-aos="fade-up">
        <div class="max-w-5xl mx-auto text-center px-5">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to prioritize your health?</h2>
            <p class="text-lg text-gray-300 mb-8">Book an appointment with our expert doctors today.</p>
            <a href="support.php" class="inline-flex items-center gap-2 bg-white text-slate-900 hover:bg-gray-100 px-8 py-3 rounded-full font-semibold transition shadow-lg">Schedule Your Visit <i class="fas fa-calendar-check"></i></a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

<!-- Initialize AOS & additional animations -->
<script>
    AOS.init({ duration: 800, once: true, offset: 100 });
    // Sticky navbar effect (adds .scrolled class)
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.site-header');
        if (header) {
            if (window.scrollY > 50) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        }
    });
    // Hover counters (if any)
    document.querySelectorAll('.counter').forEach(el => {
        const updateCounter = () => { /* optional */ };
    });
</script>
</body>
</html>