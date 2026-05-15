<?php
require_once 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id == 0) {
    header("Location: case-studies.php");
    exit;
}

$caseStudy = mysqli_fetch_assoc(mysqli_query($conn, "SELECT cs.*, d.name as doctor_name, s.name as service_name FROM case_studies cs LEFT JOIN doctors d ON cs.doctor_id = d.id LEFT JOIN services s ON cs.service_id = s.id WHERE cs.id = $id"));
if (!$caseStudy) {
    header("HTTP/1.0 404 Not Found");
    echo "Case study not found";
    exit;
}

$images = mysqli_query($conn, "SELECT * FROM case_study_images WHERE case_study_id = $id ORDER BY is_before DESC, id ASC");

$pageTitle = htmlspecialchars($caseStudy['title']) . " - Case Study";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <!-- Tailwind CSS + Google Fonts + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-heading {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4, #8b5cf6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .info-card {
            transition: transform 0.2s;
        }
        .info-card:hover {
            transform: translateY(-3px);
        }
        .gallery-img {
            transition: all 0.3s ease;
        }
        .gallery-img:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 20px -8px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <!-- Hero Image Full Width -->
    <div class="relative w-full h-[60vh] md:h-[70vh] overflow-hidden">
        <?php if (!empty($caseStudy['featured_image'])): ?>
            <img src="<?php echo $caseStudy['featured_image']; ?>" alt="<?php echo htmlspecialchars($caseStudy['title']); ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-r from-sky-500 to-cyan-500 flex items-center justify-center">
                <i class="fas fa-image text-white text-6xl opacity-50"></i>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-semibold mb-3">
                    <i class="fas fa-chart-line mr-1"></i> Success Story
                </span>
                <h1 class="text-3xl md:text-5xl font-bold text-white drop-shadow-lg"><?php echo htmlspecialchars($caseStudy['title']); ?></h1>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Doctor & Service Info (Colorful Cards) -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div class="info-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-sky-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-md text-3xl text-sky-500"></i>
                    <div>
                        <p class="text-sm text-gray-500">Leading Doctor</p>
                        <p class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($caseStudy['doctor_name'] ?? 'Not specified'); ?></p>
                    </div>
                </div>
            </div>
            <div class="info-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-cyan-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-stethoscope text-3xl text-cyan-500"></i>
                    <div>
                        <p class="text-sm text-gray-500">Medical Service</p>
                        <p class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($caseStudy['service_name'] ?? 'General Consultation'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Case Study Description -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 gradient-heading">Treatment Journey</h2>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                <?php echo nl2br(htmlspecialchars($caseStudy['description'])); ?>
            </div>
        </div>

        <!-- Before & After Gallery -->
        <?php if (mysqli_num_rows($images) > 0): ?>
        <div>
            <h2 class="text-2xl md:text-3xl font-bold mb-6 gradient-heading text-center">Before & After Gallery</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php 
                $before = null; $after = null;
                while ($img = mysqli_fetch_assoc($images)) {
                    if ($img['is_before']) $before = $img;
                    else $after = $img;
                }
                ?>
                <?php if ($before): ?>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-xl">
                    <div class="relative h-80 overflow-hidden">
                        <img src="<?php echo $before['image_path']; ?>" alt="Before treatment" class="gallery-img w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-bold">BEFORE</div>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-gray-700"><?php echo htmlspecialchars($before['caption'] ?: 'Before treatment'); ?></p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($after): ?>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-xl">
                    <div class="relative h-80 overflow-hidden">
                        <img src="../<?php echo $after['image_path']; ?>" alt="After treatment" class="gallery-img w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-emerald-500 text-white px-3 py-1 rounded-full text-sm font-bold">AFTER</div>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-gray-700"><?php echo htmlspecialchars($after['caption'] ?: 'After treatment'); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- Additional images if more than 2 -->
            <?php 
            // reset pointer and display extra images
            mysqli_data_seek($images, 0);
            $count = mysqli_num_rows($images);
            if ($count > 2): ?>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
                $shown = 0;
                mysqli_data_seek($images, 0);
                while ($img = mysqli_fetch_assoc($images)) : 
                    if ($shown >= 2) : ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <img src="../<?php echo $img['image_path']; ?>" alt="<?php echo htmlspecialchars($img['caption']); ?>" class="w-full h-48 object-cover">
                        <div class="p-2 text-center text-sm text-gray-600"><?php echo htmlspecialchars($img['caption']); ?></div>
                    </div>
                <?php endif; $shown++; endwhile; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-10 text-gray-400">
            <i class="fas fa-images text-4xl mb-2"></i>
            <p>No gallery images available for this case study.</p>
        </div>
        <?php endif; ?>

        <!-- CTA Section (Back to Case Studies / Book Appointment) -->
        <div class="mt-16 text-center">
            <a href="case-studies.php" class="inline-flex items-center gap-2 bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-3 rounded-full font-semibold transition mr-4">
                <i class="fas fa-arrow-left"></i> Back to Case Studies
            </a>
            <a href="support.php#contact-form" class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-cyan-600 text-white px-6 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transition">
                Book a Consultation <i class="fas fa-calendar-check"></i>
            </a>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>