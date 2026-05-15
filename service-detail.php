<?php
require_once 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id == 0) {
    header("Location: services.php");
    exit;
}

$service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT s.*, c.name as cat_name FROM services s LEFT JOIN categories c ON s.category_id = c.id WHERE s.id = $id"));
if(!$service) {
    header("HTTP/1.0 404 Not Found");
    echo "Service not found";
    exit;
}

// Doctors offering this service
$doctors = mysqli_query($conn, "SELECT d.* FROM doctors d JOIN doctor_services ds ON d.id = ds.doctor_id WHERE ds.service_id = $id");

$pageTitle = htmlspecialchars($service['name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | Clinic Name</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .doctor-card { transition: transform 0.2s; }
        .doctor-card:hover { transform: translateY(-3px); }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section for Service -->
    <section class="relative bg-gradient-to-r from-blue-800 to-cyan-700 text-white py-20 md:py-28">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-stethoscope mr-1"></i> <?php echo htmlspecialchars($service['cat_name']); ?>
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4"><?php echo htmlspecialchars($service['name']); ?></h1>
            <p class="text-xl text-gray-100 max-w-2xl mx-auto">
                <?php echo substr(htmlspecialchars($service['description']), 0, 150); ?>...
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="support.php#contact-form?service=<?php echo $service['id']; ?>" class="bg-white text-blue-800 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition shadow-md">
                    Book This Service <i class="fas fa-calendar-check ml-2"></i>
                </a>
                <a href="doctors.php" class="border border-white hover:bg-white/10 px-6 py-3 rounded-full font-semibold transition">
                    Meet Specialists <i class="fas fa-arrow-down ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Service details and image -->
            <div class="lg:col-span-2 space-y-6">
                <?php if(!empty($service['image'])): ?>
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="<?php echo $service['image']; ?>" alt="<?php echo htmlspecialchars($service['name']); ?>" class="w-full h-80 object-cover">
                    </div>
                <?php endif; ?>
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Service Overview</h3>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($service['description'])); ?>
                    </div>
                    <?php if($service['price']): ?>
                        <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                            <p class="text-blue-800 font-semibold"><i class="fas fa-tag mr-2"></i> Estimated Price: <span class="text-2xl font-bold">$<?php echo number_format($service['price'], 2); ?></span></p>
                            <p class="text-sm text-blue-600 mt-1">*Price may vary based on patient assessment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right: Doctors who offer this service -->
            <div id="doctors" class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-user-md text-blue-600 mr-2"></i> Our Specialists</h3>
                <?php if(mysqli_num_rows($doctors) > 0): ?>
                    <div class="space-y-4">
                        <?php while($doc = mysqli_fetch_assoc($doctors)): ?>
                            <div class="doctor-card flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition">
                                <img src="<?php echo !empty($doc['image']) ? $doc['image'] : 'assets/uploads/default-avatar.png'; ?>" class="w-14 h-14 rounded-full object-cover border-2 border-blue-200">
                                <div>
                                    <a href="doctor-detail.php?id=<?php echo $doc['id']; ?>" class="font-bold text-gray-800 hover:text-blue-600"><?php echo htmlspecialchars($doc['name']); ?></a>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($doc['qualification'], 0, 60)); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No doctors currently assigned to this service.</p>
                <?php endif; ?>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="support.php#contact-form?service=<?php echo $service['id']; ?>" class="block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full font-semibold transition">
                        Book Appointment →
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>