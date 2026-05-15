<?php
require_once '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id == 0) {
    header("Location: clinics.php");
    exit;
}

$clinic = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM clinics WHERE id = $id"));
if(!$clinic) {
    header("HTTP/1.0 404 Not Found");
    echo "Clinic not found";
    exit;
}

// Doctors working at this clinic
$doctors = mysqli_query($conn, "SELECT * FROM doctors WHERE clinic_id = $id ORDER BY name");

$pageTitle = htmlspecialchars($clinic['name']);
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
        .doctor-card { transition: all 0.2s; }
        .doctor-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <!-- Hero Section (specific to clinic) -->
    <section class="relative bg-gradient-to-r from-amber-800 to-yellow-700 text-white py-16 md:py-24">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold mb-3">
                        <i class="fas fa-location-dot mr-1"></i> Our Branch
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold mb-3"><?php echo htmlspecialchars($clinic['name']); ?></h1>
                    <p class="text-lg text-gray-100 max-w-xl"><?php echo htmlspecialchars($clinic['address']); ?></p>
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="support.php" class="bg-white text-amber-800 hover:bg-gray-100 px-6 py-2 rounded-full font-semibold transition">
                            <i class="fas fa-phone-alt mr-2"></i> Call Now
                        </a>
                        <a href="doctors.php#doctors" class="border border-white hover:bg-white/10 px-6 py-2 rounded-full font-semibold transition">
                            Meet Our Doctors <i class="fas fa-arrow-down ml-2"></i>
                        </a>
                    </div>
                </div>
                <?php if(!empty($clinic['image'])): ?>
                    <img src="../<?php echo $clinic['image']; ?>" alt="<?php echo htmlspecialchars($clinic['name']); ?>" class="w-48 h-48 object-cover rounded-full shadow-xl border-4 border-white">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left column: Clinic details & Map -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Address & Contact -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-info-circle text-amber-600 mr-2"></i> Contact Information</h3>
                    <div class="space-y-3 text-gray-600">
                        <p><i class="fas fa-map-pin text-amber-600 w-5"></i> <strong>Address:</strong> <?php echo nl2br(htmlspecialchars($clinic['address'])); ?></p>
                        <p><i class="fas fa-phone-alt text-amber-600 w-5"></i> <strong>Phone:</strong> <a href="tel:<?php echo $clinic['phone']; ?>" class="hover:text-amber-600"><?php echo htmlspecialchars($clinic['phone']); ?></a></p>
                        <?php if(!empty($clinic['email'])): ?>
                            <p><i class="fas fa-envelope text-amber-600 w-5"></i> <strong>Email:</strong> <a href="mailto:<?php echo $clinic['email']; ?>" class="hover:text-amber-600"><?php echo htmlspecialchars($clinic['email']); ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Google Map (iframe) -->
                <?php if(!empty($clinic['google_map_iframe'])): ?>
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-map text-amber-600 mr-2"></i> Location Map</h3>
                        <div class="rounded-xl overflow-hidden h-80">
                            <?php echo $clinic['google_map_iframe']; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Right column: Doctors at this clinic -->
            <div id="doctors" class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-user-md text-amber-600 mr-2"></i> Our Doctors</h3>
                <?php if(mysqli_num_rows($doctors) > 0): ?>
                    <div class="space-y-4">
                        <?php while($doc = mysqli_fetch_assoc($doctors)): ?>
                            <div class="doctor-card flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition">
                                <img src="../<?php echo !empty($doc['image']) ? $doc['image'] : 'assets/uploads/default-avatar.png'; ?>" alt="<?php echo htmlspecialchars($doc['name']); ?>" class="w-14 h-14 rounded-full object-cover border-2 border-amber-200">
                                <div>
                                    <a href="doctor-detail.php?id=<?php echo $doc['id']; ?>" class="font-bold text-gray-800 hover:text-amber-600"><?php echo htmlspecialchars($doc['name']); ?></a>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($doc['qualification'], 0, 60)); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No doctors currently assigned to this clinic.</p>
                <?php endif; ?>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="support.php#contact-form?clinic=<?php echo $clinic['id']; ?>" class="block text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-full font-semibold transition">
                        Book Appointment at this Clinic →
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>