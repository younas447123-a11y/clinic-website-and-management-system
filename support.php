<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Contact Us & FAQs</title>
    <!-- Google Fonts + Tailwind + Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS to override/refine Tailwind defaults -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Smooth custom transition for FAQ accordion */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.33, 1, 0.68, 1);
        }
        .faq-answer.active {
            max-height: 400px; /* enough for the longest answer */
        }
        /* Contact form field focus effect */
        .contact-input:focus, .contact-textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            outline: none;
        }
        /* Hide default number spinners */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-50">

    <?php include 'includes/header.php'; ?>
<section class="bg-gradient-to-r from-slate-800 to-slate-900 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <i class="fas fa-headset text-5xl text-blue-400 mb-4"></i>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">How Can We Help?</h1>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto">Your questions, concerns, and feedback matter to us. Reach out anytime.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="#contact-form" class="bg-blue-500 hover:bg-blue-600 px-8 py-3 rounded-full font-semibold transition">Submit a Ticket</a>
            <a href="tel:080052737" class="border border-white/50 px-8 py-3 rounded-full font-semibold hover:bg-white/10 transition"><i class="fas fa-phone-alt mr-2"></i> Call Support</a>
        </div>
    </div>
</section>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Two-column layout: Contact Form (left) + FAQ (right) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- ================= LEFT COLUMN: CONTACT FORM ================= -->
            <div id="contact-form">
                <!-- Form header with subtle decorative line -->
                <div class="mb-8">
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Get in touch</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1">We're here to help</h2>
                    <div class="w-16 h-1 bg-blue-600 mt-3 rounded-full"></div>
                </div>

                <form id="supportForm" class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full name</label>
                        <input type="text" id="name" name="name" required
                               class="contact-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white focus:border-blue-600 transition-colors"
                               placeholder="e.g., Ahmad Raza">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <input type="email" id="email" name="email" required
                               class="contact-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white focus:border-blue-600 transition-colors"
                               placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
                        <input type="tel" id="phone" name="phone"
                               class="contact-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white focus:border-blue-600 transition-colors"
                               placeholder="+92 XXX XXXXXXX">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" id="subject" name="subject" required
                               class="contact-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white focus:border-blue-600 transition-colors"
                               placeholder="How can we assist you?">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" required
                                  class="contact-textarea w-full px-4 py-3 border border-gray-300 rounded-xl bg-white focus:border-blue-600 transition-colors"
                                  placeholder="Please describe your query in detail..."></textarea>
                    </div>
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Submit Ticket
                    </button>
                    <div id="supportResponse" class="text-center text-sm"></div>
                </form>

                <!-- Additional contact info (optional) -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2"><i class="fas fa-phone-alt text-blue-500"></i> +92 300 1234567</div>
                    <div class="flex items-center gap-2"><i class="fas fa-envelope text-blue-500"></i> support@hedoxclinic.com</div>
                    <div class="flex items-center gap-2"><i class="fas fa-clock text-blue-500"></i> Mon-Sat: 9AM – 8PM</div>
                </div>
            </div>
            
            <!-- ================= RIGHT COLUMN: FAQ ACCORDION ================= -->
            <div>
                <div class="mb-8">
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">knowledge base</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1">Frequently asked questions</h2>
                    <div class="w-16 h-1 bg-blue-600 mt-3 rounded-full"></div>
                    <p class="text-gray-600 mt-4">Find quick answers to common questions about our clinic, services and appointments.</p>
                </div>
                
                <div class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-question w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-lg font-semibold text-gray-800">How do I book an appointment?</span>
                            <i class="fas fa-plus text-blue-500 transition-transform duration-200"></i>
                        </button>
                        <div class="faq-answer px-6 pb-4 text-gray-600">
                            <p class="pt-2">You can book an appointment online through our website by visiting the Appointments page. Simply select your preferred service, doctor, and available time slot. You can also call our clinic directly to schedule an appointment.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-question w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-lg font-semibold text-gray-800">What services do you offer?</span>
                            <i class="fas fa-plus text-blue-500"></i>
                        </button>
                        <div class="faq-answer px-6 pb-4 text-gray-600">
                            <p class="pt-2">We offer a wide range of medical services including general consultation, cardiology, dermatology, physiotherapy, laboratory tests, and specialized surgeries. Visit our Services page for a complete list.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-question w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-lg font-semibold text-gray-800">Do you accept insurance?</span>
                            <i class="fas fa-plus text-blue-500"></i>
                        </button>
                        <div class="faq-answer px-6 pb-4 text-gray-600">
                            <p class="pt-2">Yes, we accept most major insurance plans. Please contact our billing department or bring your insurance card to your appointment for verification.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-question w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-lg font-semibold text-gray-800">What are your clinic hours?</span>
                            <i class="fas fa-plus text-blue-500"></i>
                        </button>
                        <div class="faq-answer px-6 pb-4 text-gray-600">
                            <p class="pt-2">Our clinic is open Monday to Friday from 9:00 AM to 8:00 PM and Saturday from 10:00 AM to 4:00 PM. We are closed on Sundays.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-question w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-lg font-semibold text-gray-800">How can I cancel or reschedule my appointment?</span>
                            <i class="fas fa-plus text-blue-500"></i>
                        </button>
                        <div class="faq-answer px-6 pb-4 text-gray-600">
                            <p class="pt-2">You can cancel or reschedule your appointment by calling our clinic at least 24 hours in advance. Alternatively, you can log into your account and manage your appointments online.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-question w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-lg font-semibold text-gray-800">What should I bring to my first visit?</span>
                            <i class="fas fa-plus text-blue-500"></i>
                        </button>
                        <div class="faq-answer px-6 pb-4 text-gray-600">
                            <p class="pt-2">Please bring a valid ID, your insurance card, any relevant medical records or test results, and a list of medications you are currently taking.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Clinics - Locations & Contact</title>
    <!-- Tailwind CSS CDN + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom override for hover transitions -->
    <style>
        .clinic-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .clinic-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    Our Clinics
                </h2>
                <p class="text-lg text-gray-600">
                    Visit us at a location convenient for you. Our doors are open.
                </p>
                <div class="w-20 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Clinics Grid (3 Columns Responsive) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- 1. Islamabad Golra Morr Clinic -->
                <div class="clinic-card bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                            <h3 class="text-xl font-bold text-gray-800">Islamabad Clinic</h3>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Golra Morr, Islamabad</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-location-dot text-blue-500 mt-1 w-5"></i>
                            <address class="text-gray-600 not-italic text-sm leading-relaxed">
                                Younas Laser Pain Therapy Clinic,<br>
                                Bank Al Habib Building,<br>
                                Main Grand Trunk Rd, Golra Morr,<br>
                                Islamabad, Pakistan
                            </address>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-blue-500 w-5"></i>
                            <a href="tel:03099237685" class="text-gray-600 hover:text-blue-600 transition">
                                03099237685
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-envelope text-blue-500 w-5"></i>
                            <a href="mailto:younas447123@gmail.com" class="text-gray-600 hover:text-blue-600 transition">
                                younas447123@gmail.com
                            </a>
                        </div>
                        <a href="https://maps.google.com/?q=Bioflex+Pakistan+Islamabad+Golra+Morr" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 mt-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                            <i class="fas fa-map-marked-alt"></i> Get Directions
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- 2. Karachi Clinic -->
                <div class="clinic-card bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                            <h3 class="text-xl font-bold text-gray-800">Karachi Clinic</h3>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Defence Housing Authority (DHA)</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-location-dot text-blue-500 mt-1 w-5"></i>
                            <address class="text-gray-600 not-italic text-sm leading-relaxed">
                                Younas Laser Pain Therapy Clinic,<br>
                                DHA Phase 2,<br>
                                Karachi, Pakistan
                            </address>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-blue-500 w-5"></i>
                            <a href="tel:03099237685" class="text-gray-600 hover:text-blue-600 transition">
                                03099237685
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-envelope text-blue-500 w-5"></i>
                            <a href="mailto:younas447123@gmail.com" class="text-gray-600 hover:text-blue-600 transition">
                                younas447123@gmail.com
                            </a>
                        </div>
                        <a href="https://maps.google.com/?q=younas+Laser+Pain+Therapy+Clinic+Karachi" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 mt-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                            <i class="fas fa-map-marked-alt"></i> Get Directions
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- 3. Peshawar Clinic -->
                <div class="clinic-card bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                            <h3 class="text-xl font-bold text-gray-800">Peshawar Clinic</h3>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">University Rd, Peshawar</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-location-dot text-blue-500 mt-1 w-5"></i>
                            <address class="text-gray-600 not-italic text-sm leading-relaxed">
                               seez,<br>
                                Afridi Medical hospital, Third Floor,<br>
                                Tehkal, University Road,<br>
                                Peshawar, Pakistan
                            </address>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-phone-alt text-blue-500 w-5"></i>
                            <a href="tel:03099237685" class="text-gray-600 hover:text-blue-600 transition">
                                03099237685
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-envelope text-blue-500 w-5"></i>
                            <a href="mailto:younas447123@gmail.com" class="text-gray-600 hover:text-blue-600 transition">
                               younas447123@gmail.com
                            </a>
                        </div>
                        <a href="https://maps.google.com/?q= younas+Complexflex" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 mt-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                            <i class="fas fa-map-marked-alt"></i> Get Directions
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript: Form submission + Exclusive Accordion (one open at a time) -->
    <script>
        // ========== FAQ ACCORDION: close others when one is opened ==========
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const currentAnswer = button.nextElementSibling;
                const currentIcon = button.querySelector('i');
                // Check if the clicked FAQ is already active
                const isCurrentlyActive = currentAnswer.classList.contains('active');
                
                // First, close all FAQ answers and reset all icons to plus
                document.querySelectorAll('.faq-answer').forEach(answer => {
                    if (answer.classList.contains('active')) {
                        answer.classList.remove('active');
                        // Find the corresponding icon inside the previous sibling button
                        const siblingButton = answer.previousElementSibling;
                        if (siblingButton && siblingButton.classList.contains('faq-question')) {
                            const siblingIcon = siblingButton.querySelector('i');
                            if (siblingIcon) {
                                siblingIcon.classList.remove('fa-minus');
                                siblingIcon.classList.add('fa-plus');
                            }
                        }
                    }
                });
                
                // If the clicked FAQ was NOT active, open it and change its icon to minus
                if (!isCurrentlyActive) {
                    currentAnswer.classList.add('active');
                    currentIcon.classList.remove('fa-plus');
                    currentIcon.classList.add('fa-minus');
                } else {
                    // If it was active and now closed, ensure icon is plus (already handled by global reset, but reset explicitly)
                    currentIcon.classList.remove('fa-minus');
                    currentIcon.classList.add('fa-plus');
                }
            });
        });

        // ========== CONTACT FORM SUBMISSION (AJAX) ==========
        const supportForm = document.getElementById('supportForm');
        const responseDiv = document.getElementById('supportResponse');
        
        if (supportForm) {
            supportForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('api/submit-support.php', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        responseDiv.innerHTML = `<p class="${data.success ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50'} p-3 rounded-lg mt-3">${data.message}</p>`;
                        if (data.success) this.reset();
                        setTimeout(() => { responseDiv.innerHTML = ''; }, 5000);
                    })
                    .catch(err => {
                        responseDiv.innerHTML = '<p class="text-red-600 bg-red-50 p-3 rounded-lg mt-3">Network error. Please try again.</p>';
                    });
            });
        }
    </script>
</body>
</html>