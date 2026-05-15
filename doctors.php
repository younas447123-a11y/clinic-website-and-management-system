<?php
require_once 'config/database.php';

$categoryFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$clinicFilter = isset($_GET['clinic']) ? (int)$_GET['clinic'] : 0;
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$sql = "SELECT d.*, c.name as clinic_name, cat.name as category_name 
        FROM doctors d 
        LEFT JOIN clinics c ON d.clinic_id = c.id 
        LEFT JOIN categories cat ON d.category_id = cat.id 
        WHERE 1=1";
if ($categoryFilter) $sql .= " AND d.category_id = $categoryFilter";
if ($clinicFilter) $sql .= " AND d.clinic_id = $clinicFilter";
if ($search) $sql .= " AND (d.name LIKE '%$search%' OR d.qualification LIKE '%$search%' OR d.bio LIKE '%$search%')";
$sql .= " ORDER BY d.name ASC";
$doctors = mysqli_query($conn, $sql);

$categories = mysqli_query($conn, "SELECT id, name FROM categories WHERE type='doctor'");
$clinics = mysqli_query($conn, "SELECT id, name FROM clinics");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Doctors</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="relative bg-gradient-to-r from-indigo-900 via-purple-800 to-indigo-900 text-white py-20">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold mb-4 backdrop-blur-sm">🌟 Your Health Partner</span>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Dr. Sarah Johnson</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">Senior Cardiology Specialist | 15+ Years of Excellence</p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <a href="support.php#contact-form" class="bg-white text-indigo-800 px-6 py-2 rounded-full font-semibold hover:shadow-lg transition">Book Consultation →</a>
            <a href="services.php" class="border border-white px-6 py-2 rounded-full font-semibold hover:bg-white/10 transition">View Profile</a>
        </div>
    </div>
</section>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Our Team | Clinic Name</title>

    <!-- Google Fonts: Inter ( professional/healthcare feel ) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 (free icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* custom smooth transition & scroll reveal fallback */
        body {
            font-family: 'Inter', sans-serif;
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.2, 0.9, 0.3, 1.1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* subtle image scale on hover (optional) */
        .team-img {
            transition: transform 0.4s ease;
        }
        .team-card:hover .team-img {
            transform: scale(1.02);
        }
        /* custom blue used in London Dermatology Centre style */
        .accent-blue {
            color: #1e63b3;
        }
        .bg-accent-blue {
            background-color: #1e63b3;
        }
    </style>
</head>
<body class="bg-white">

<!-- ================= SECTION: MEET OUR TEAM ================= -->
<section class="py-20 md:py-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">

        <!-- section header (centered) -->
        <div class="text-center max-w-2xl mx-auto mb-12 md:mb-16 reveal">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider bg-blue-50 inline-block px-4 py-1.5 rounded-full">Our experts</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mt-4 mb-4 leading-tight">
                Meet Our <span class="relative inline-block">
                    Team
                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-blue-500" viewBox="0 0 200 8" fill="currentColor" preserveAspectRatio="none">
                        <path d="M0,6 L200,6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-dasharray="10 8"/>
                    </svg>
                </span>
            </h2>
            <p class="text-lg text-gray-600">
                A dedicated group of highly skilled consultants, surgeons and specialists.
            </p>
        </div>

        <!-- split layout: left side = image , right side = description + team members -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- LEFT COLUMN : PHOTO / TEAM ATMOSPHERE (inspired by London Derm) -->
            <div class="relative reveal">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <!-- professional clinic doctor group photo (replace with your own) -->
                    <img src="assets\uploads\w-about-us1-img-1-opt.jpg" 
                         alt="Our medical team at work" 
                         class="w-full h-full object-cover team-img">
                    <!-- subtle gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent pointer-events-none"></div>
                </div>
                <!-- floating badge / trust signal -->
                <div class="absolute -bottom-4 -right-4 bg-white rounded-xl shadow-lg p-4 flex items-center gap-3 max-w-[200px]">
                    <i class="fas fa-calendar-check text-3xl text-blue-600"></i>
                    <div>
                        <p class="text-xs text-gray-500">over</p>
                        <p class="font-bold text-gray-800">10,000+ happy patients</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN : DYNAMIC CONTENT + TEAM MEMBERS PREVIEW -->
            <div class="space-y-8 reveal">
                <!-- headline + credibility -->
                <div>
                    <span class="inline-block py-1 px-3 bg-blue-50 text-blue-700 rounded-full text-sm font-medium mb-4">✨ Excellence in care</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Every patient matters, every diagnosis counts</h3>
                    <p class="text-gray-600 leading-relaxed">
                        At our clinic, we bring together leading dermatologists, plastic surgeons, and aesthetic doctors – all committed to the highest clinical standards. 
                        Our consultant-led approach ensures you receive <span class="font-semibold text-gray-800">personalised, evidence‑based care</span> tailored to your unique skin needs.
                    </p>
                </div>

                <!-- team member list (inspired by London Dermatology Centre layout with modern cards) -->
                <div class="space-y-5">
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4 hover:bg-gray-50 transition-all p-2 rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-md text-blue-700 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Prof. Dr. Sunil Chopra</h4>
                            <p class="text-sm text-gray-500">Consultant Dermatologist | GMC: 3328774</p>
                            <p class="text-sm text-gray-600 mt-1">Clinical Director, expert in surgical dermatology and complex inflammatory conditions.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4 hover:bg-gray-50 transition-all p-2 rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-stethoscope text-blue-700 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Alla Altayeb</h4>
                            <p class="text-sm text-gray-500">Consultant Dermatologist | GMC: 7490535</p>
                            <p class="text-sm text-gray-600 mt-1">Specialist in medical & surgical dermatology, graduated from University of Southampton.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4 hover:bg-gray-50 transition-all p-2 rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-syringe text-blue-700 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Ien Chan</h4>
                            <p class="text-sm text-gray-500">Consultant Dermatologist | MD, FRCP</p>
                            <p class="text-sm text-gray-600 mt-1">Paediatric dermatology, acne, eczema, psoriasis & hair loss – fully accredited.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 pb-2 pt-1 hover:bg-gray-50 transition-all p-2 rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-heartbeat text-blue-700 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Julian Emmanuel</h4>
                            <p class="text-sm text-gray-500">Consultant Endocrinologist | Obesity Medicine</p>
                            <p class="text-sm text-gray-600 mt-1">10,000+ patients treated, fusion of cutting‑edge research and compassion.</p>
                        </div>
                    </div>
                </div>

                <!-- call to action (consistent with team page style) -->
                <div class="pt-4 flex flex-wrap gap-4 items-center">
                    <a href="support.php#contact-form" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold transition shadow-md hover:shadow-lg">
                        Book a consultation <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="doctors.php" class="inline-flex items-center gap-2 text-gray-700 font-medium hover:text-blue-600 transition">
                        <i class="fas fa-users"></i> Meet all specialists
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- simple scroll animation script (Intersection Observer / reveal effect) -->
<script>
    (function() {
        const revealElements = document.querySelectorAll('.reveal');
        if (revealElements.length) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        // optional: unobserve after animation appears
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
            revealElements.forEach(el => observer.observe(el));
        }
    })();
</script>

</body>
</html>
    <main class="container">
        <h1>Our Doctors</h1>
        <form method="GET" class="filters">
            <input type="text" name="search" placeholder="Search by name or qualification" value="<?php echo htmlspecialchars($search); ?>">
            <select name="category">
                <option value="0">All Categories</option>
                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $categoryFilter == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <select name="clinic">
                <option value="0">All Clinics</option>
                <?php while($cl = mysqli_fetch_assoc($clinics)): ?>
                    <option value="<?php echo $cl['id']; ?>" <?php echo $clinicFilter == $cl['id'] ? 'selected' : ''; ?>><?php echo $cl['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Filter</button>
        </form>
        <div class="doctors-grid">
            <?php while($row = mysqli_fetch_assoc($doctors)): ?>
                <div class="doctor-card">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><strong><?php echo $row['category_name']; ?></strong></p>
                    <p><?php echo $row['clinic_name']; ?></p>
                    <p><?php echo substr(htmlspecialchars($row['qualification']), 0, 100); ?>...</p>
                    <a href="doctor-detail.php?id=<?php echo $row['id']; ?>">View Profile</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>