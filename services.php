<?php
require_once 'config/database.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Fetch all service categories
$categories = mysqli_query($conn, "SELECT * FROM categories WHERE type='service' ORDER BY name");

// Fetch services (filtered by category if selected)
$sql = "SELECT s.*, c.name as category_name FROM services s 
        LEFT JOIN categories c ON s.category_id = c.id 
        WHERE c.type='service'";
if ($category_id > 0) {
    $sql .= " AND s.category_id = $category_id";
}
$sql .= " ORDER BY s.name ASC";
$services = mysqli_query($conn, $sql);

$pageTitle = "Our Medical Services";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | Clinic Name</title>

    <!-- Tailwind CSS + Google Fonts + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Override Tailwind's default font -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        .category-filter a {
            transition: all 0.2s ease;
        }
        .service-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">

    <?php include 'includes/header.php'; ?>

    <!-- ========== NEW HERO SECTION ========== -->
    <section class="relative bg-gradient-to-r from-blue-900 via-indigo-800 to-blue-900 text-white py-20 md:py-28">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold mb-4 backdrop-blur-sm">
                <i class="fas fa-stethoscope mr-1"></i> Comprehensive Care
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4">
                Our Medical <span class="text-cyan-300">Services</span>
            </h1>
            <p class="text-xl text-gray-100 max-w-2xl mx-auto">
                From preventive checkups to advanced surgeries – we offer a full spectrum of healthcare services tailored to your needs.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="#services-grid" class="bg-white text-blue-800 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition shadow-md">
                    Explore Services <i class="fas fa-arrow-down ml-1"></i>
                </a>
                <a href="support.php#contact-form" class="border border-white hover:bg-white/10 px-6 py-3 rounded-full font-semibold transition">
                    Book a Consultation → 
                </a>
            </div>
        </div>
    </section>

    <!-- ========== SERVICES CONTENT ========== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        
        <!-- Category Filter (Pills) -->
        <div class="category-filter flex flex-wrap justify-center gap-2 md:gap-3 mb-12">
            <a href="services.php" class="<?php echo $category_id == 0 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> px-4 py-2 rounded-full text-sm font-medium transition">
                All Services
            </a>
            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                <a href="?category=<?php echo $cat['id']; ?>" 
                   class="<?php echo $category_id == $cat['id'] ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> px-4 py-2 rounded-full text-sm font-medium transition">
                    <?php echo htmlspecialchars($cat['name']); ?>
                </a>
            <?php endwhile; ?>
        </div>

        <!-- Services Grid -->
        <?php if(mysqli_num_rows($services) > 0): ?>
            <div id="services-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while($service = mysqli_fetch_assoc($services)): ?>
                    <div class="service-card bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                        <!-- Service Image -->
                        <div class="h-48 overflow-hidden bg-gray-200">
                            <?php if(!empty($service['image'])): ?>
                                <img src="<?php echo $service['image']; ?>" alt="<?php echo htmlspecialchars($service['name']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-5xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-6">
                            <!-- Category badge -->
                            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full mb-3">
                                <?php echo htmlspecialchars($service['category_name']); ?>
                            </span>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($service['name']); ?></h3>
                            
                            <p class="text-gray-600 text-sm mb-4">
                                <?php echo substr(htmlspecialchars($service['description']), 0, 100); ?>...
                            </p>
                            
                            <?php if($service['price']): ?>
                                <p class="text-blue-600 font-bold mb-4">From $<?php echo number_format($service['price'], 2); ?></p>
                            <?php endif; ?>
                            
                            <a href="service-detail.php?id=<?php echo $service['id']; ?>" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                                Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-notes-medical text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No services found in this category.</p>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>