<?php
require_once 'config/database.php';

$clinics = mysqli_query($conn, "SELECT * FROM clinics ORDER BY name");

$pageTitle = "Our Clinic Locations";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | Clinic Name</title>
    <!-- Tailwind CSS + Google Fonts + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .clinic-card { transition: transform 0.2s, box-shadow 0.2s; }
        .clinic-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-emerald-800 to-teal-700 text-white py-20 md:py-28">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-map-marker-alt mr-1"></i> Find Us Nearby
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4">Our Clinic <span class="text-teal-200">Locations</span></h1>
            <p class="text-xl text-gray-100 max-w-2xl mx-auto">
                State‑of‑the‑art facilities, accessible from across the city. Visit us at a branch convenient for you.
            </p>
            <div class="mt-8 flex justify-center">
                <a href="#clinics-grid" class="bg-white text-emerald-800 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition shadow-md">
                    Browse Clinics <i class="fas fa-arrow-down ml-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Clinics Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <?php if(mysqli_num_rows($clinics) > 0): ?>
            <div id="clinics-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while($clinic = mysqli_fetch_assoc($clinics)): ?>
                    <div class="clinic-card bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                        <?php if(!empty($clinic['image'])): ?>
                            <img src="<?php echo $clinic['image']; ?>" alt="<?php echo htmlspecialchars($clinic['name']); ?>" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-building text-5xl"></i>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($clinic['name']); ?></h3>
                            <p class="text-gray-600 text-sm mb-2"><i class="fas fa-location-dot text-emerald-600 mr-1"></i> <?php echo htmlspecialchars(substr($clinic['address'], 0, 80)); ?>...</p>
                            <p class="text-gray-600 text-sm mb-4"><i class="fas fa-phone text-emerald-600 mr-1"></i> <?php echo htmlspecialchars($clinic['phone']); ?></p>
                            <a href="clinic-detail.php?id=<?php echo $clinic['id']; ?>" class="inline-flex items-center text-emerald-600 font-semibold hover:text-emerald-800 transition">
                                View Details <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-hospital-user text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No clinic information available yet.</p>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>