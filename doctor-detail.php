<?php
require_once 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id == 0) {
    header("Location: doctors.php");
    exit;
}

// Fetch doctor details with clinic and category
$query = "SELECT d.*, c.name as clinic_name, c.address, c.phone, cat.name as category_name 
          FROM doctors d 
          LEFT JOIN clinics c ON d.clinic_id = c.id 
          LEFT JOIN categories cat ON d.category_id = cat.id 
          WHERE d.id = $id";
$doctor = mysqli_fetch_assoc(mysqli_query($conn, $query));
if (!$doctor) {
    header("HTTP/1.0 404 Not Found");
    echo "Doctor not found";
    exit;
}

// Fetch services offered by this doctor
$services = mysqli_query($conn, "SELECT s.* FROM services s 
                                 JOIN doctor_services ds ON s.id = ds.service_id 
                                 WHERE ds.doctor_id = $id");

// Fetch schedule
$schedule = mysqli_query($conn, "SELECT * FROM doctor_schedule WHERE doctor_id = $id ORDER BY day_of_week");
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Fetch approved reviews
$reviews = mysqli_query($conn, "SELECT * FROM reviews WHERE doctor_id = $id AND is_approved = 1 ORDER BY created_at DESC");

$pageTitle = htmlspecialchars($doctor['name']) . " - Doctor Profile";
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
        .gradient-text {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .info-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -8px rgba(0,0,0,0.1);
        }
        .schedule-table td, .schedule-table th {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .service-tag {
            transition: all 0.2s;
        }
        .service-tag:hover {
            background: #0ea5e9;
            color: white;
            transform: translateY(-2px);
        }
        .review-card {
            transition: all 0.2s;
        }
        .review-card:hover {
            transform: translateX(5px);
            background: #f8fafc;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section (Doctor Profile Banner) -->
    <div class="relative bg-gradient-to-r from-sky-700 to-cyan-700 text-white py-16 md:py-20">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <!-- Doctor Image -->
                <div class="w-40 h-40 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white shadow-xl">
                    <img src="../<?php echo !empty($doctor['image']) ? $doctor['image'] : 'assets/uploads/default-avatar.png'; ?>" 
                         alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
                         class="w-full h-full object-cover">
                </div>
                <!-- Doctor Basic Info -->
                <div class="text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-semibold mb-2 backdrop-blur-sm">
                        <i class="fas fa-user-md mr-1"></i> Senior Specialist
                    </span>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold"><?php echo htmlspecialchars($doctor['name']); ?></h1>
                    <p class="text-xl text-sky-100 mt-2"><?php echo htmlspecialchars($doctor['category_name']); ?></p>
                    <div class="mt-4 flex flex-wrap gap-3 justify-center md:justify-start">
                        <a href="support.php#contact-form?doctor=<?php echo $doctor['id']; ?>" class="bg-white text-sky-700 hover:bg-gray-100 px-5 py-2 rounded-full font-semibold transition shadow-md">
                            <i class="fas fa-calendar-check mr-2"></i> Book Appointment
                        </a>
                        <a href="#reviews" class="border border-white/50 hover:bg-white/10 px-5 py-2 rounded-full font-semibold transition">
                            <i class="fas fa-star mr-2"></i> Patient Reviews
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Info Cards Row (Clinic, Experience, Qualification) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="info-card bg-white rounded-2xl shadow-md p-5 flex items-start gap-3 border-l-4 border-sky-500">
                <i class="fas fa-hospital-user text-3xl text-sky-500"></i>
                <div>
                    <h3 class="font-semibold text-gray-500 text-sm">Clinic / Branch</h3>
                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars($doctor['clinic_name'] ?? 'Not assigned'); ?></p>
                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($doctor['address'] ?? ''); ?></p>
                </div>
            </div>
            <div class="info-card bg-white rounded-2xl shadow-md p-5 flex items-start gap-3 border-l-4 border-cyan-500">
                <i class="fas fa-briefcase text-3xl text-cyan-500"></i>
                <div>
                    <h3 class="font-semibold text-gray-500 text-sm">Experience</h3>
                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($doctor['experience'] ?? 'Not specified')); ?></p>
                </div>
            </div>
            <div class="info-card bg-white rounded-2xl shadow-md p-5 flex items-start gap-3 border-l-4 border-indigo-500">
                <i class="fas fa-graduation-cap text-3xl text-indigo-500"></i>
                <div>
                    <h3 class="font-semibold text-gray-500 text-sm">Qualification</h3>
                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($doctor['qualification'] ?? 'Not specified')); ?></p>
                </div>
            </div>
        </div>

        <!-- Bio Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 gradient-text">
                <i class="fas fa-notes-medical mr-2"></i> About Dr. <?php echo htmlspecialchars($doctor['name']); ?>
            </h2>
            <div class="text-gray-700 leading-relaxed space-y-4">
                <?php echo nl2br(htmlspecialchars($doctor['bio'] ?? 'No biography provided yet.')); ?>
            </div>
        </div>

        <!-- Services Offered -->
        <?php if (mysqli_num_rows($services) > 0): ?>
        <div class="mb-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 gradient-text text-center">
                <i class="fas fa-stethoscope mr-2"></i> Services Offered
            </h2>
            <div class="flex flex-wrap gap-3 justify-center">
                <?php while ($s = mysqli_fetch_assoc($services)): ?>
                    <span class="service-tag bg-sky-50 text-sky-700 px-4 py-2 rounded-full text-sm font-semibold shadow-sm transition cursor-default">
                        <?php echo htmlspecialchars($s['name']); ?>
                    </span>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Schedule Table -->
        <?php if (mysqli_num_rows($schedule) > 0): ?>
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 gradient-text">
                <i class="fas fa-clock mr-2"></i> Weekly Schedule
            </h2>
            <div class="overflow-x-auto">
                <table class="schedule-table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left font-semibold text-gray-600">Day</th>
                            <th class="text-left font-semibold text-gray-600">Timings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($sch = mysqli_fetch_assoc($schedule)): ?>
                        <tr>
                            <td class="font-medium"><?php echo $days[$sch['day_of_week']]; ?></td>
                            <td><?php echo date('h:i A', strtotime($sch['start_time'])); ?> – <?php echo date('h:i A', strtotime($sch['end_time'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- Patient Reviews -->
        <?php if (mysqli_num_rows($reviews) > 0): ?>
        <div id="reviews" class="mb-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 gradient-text text-center">
                <i class="fas fa-star text-yellow-500 mr-2"></i> What Patients Say
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php while ($rev = mysqli_fetch_assoc($reviews)): ?>
                <div class="review-card bg-white rounded-xl shadow-md p-5 transition">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="text-yellow-500">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php echo $i <= $rev['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                            <?php endfor; ?>
                        </div>
                        <span class="text-xs text-gray-400"><?php echo date('M d, Y', strtotime($rev['created_at'])); ?></span>
                    </div>
                    <p class="text-gray-700 italic">“<?php echo htmlspecialchars($rev['comment']); ?>”</p>
                    <p class="mt-3 font-semibold text-gray-800">– <?php echo htmlspecialchars($rev['patient_name']); ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Appointment CTA -->
        <div id="appointment" class="bg-gradient-to-r from-sky-600 to-cyan-600 rounded-2xl p-8 text-center text-white shadow-xl">
            <h3 class="text-2xl font-bold mb-2">Ready to consult Dr. <?php echo htmlspecialchars($doctor['name']); ?>?</h3>
            <p class="text-sky-100 mb-6">Book your appointment online in just a few clicks.</p>
            <a href="support.php#contact-form?doctor=<?php echo $doctor['id']; ?>" class="inline-flex items-center gap-2 bg-white text-sky-700 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition shadow-md">
                <i class="fas fa-calendar-alt"></i> Book an Appointment
            </a>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>