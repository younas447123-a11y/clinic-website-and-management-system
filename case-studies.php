<?php
require_once 'config/database.php';
$caseStudies = mysqli_query($conn, "SELECT cs.*, d.name as doctor_name FROM case_studies cs LEFT JOIN doctors d ON cs.doctor_id = d.id ORDER BY cs.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Case Studies</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="relative bg-cover bg-center py-24" style="background-image: linear-gradient(135deg, #1e1b4b, #312e81);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-200 rounded-full text-sm font-semibold mb-4">📖 Real Results</span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">From Chronic Pain to Active Life</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">How our physiotherapy and laser treatment helped John recover full mobility.</p>
        <div class="mt-6 flex justify-center gap-4">
            <a href="#" class="bg-emerald-500 hover:bg-emerald-600 px-6 py-2 rounded-full font-semibold transition">Read Full Story</a>
            <a href="#" class="border border-white/60 px-6 py-2 rounded-full font-semibold hover:bg-white/10">Similar Cases</a>
        </div>
    </div>
</section>
    <main class="container">
        <h1>Medical Case Studies</h1>
        <div class="case-studies-grid">
            <?php while($cs = mysqli_fetch_assoc($caseStudies)): ?>
                <div class="case-study-card">
                    <img src="<?php echo $cs['featured_image']; ?>" alt="<?php echo $cs['title']; ?>">
                    <h3><?php echo htmlspecialchars($cs['title']); ?></h3>
                    <p>Doctor: <?php echo $cs['doctor_name']; ?></p>
                    <a href="case-study-detail.php?id=<?php echo $cs['id']; ?>">View Full Study</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>