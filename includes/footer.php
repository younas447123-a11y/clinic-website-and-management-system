<!-- Start of Footer (Self‑contained styling) -->
<footer class="clinic-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Column 1: Brand & Contact -->
            <div class="footer-col">
                <h3>CliniCare<span class="text-light">+</span></h3>
                <p>Experience world-class medical services with our team of specialists. Your health is our priority.</p>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> 123 Healthcare Ave, Medical District</p>
                    <p><i class="fas fa-phone-alt"></i> +1 (234) 567-8900</p>
                    <p><i class="fas fa-envelope"></i> info@clinicare.com</p>
                </div>
            </div>

            <!-- Column 2: About & Services -->
            <div class="footer-col">
                <h3>About & Services</h3>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Our Services</a></li>
                    <li><a href="doctors.php">Medical Team</a></li>
                    <li><a href="clinics.php">Our Clinics</a></li>
                    <li><a href="case-studies.php">Success Stories</a></li>
                </ul>
            </div>

            <!-- Column 3: Quick Links -->
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="appointment.php">Book Appointment</a></li>
                    <li><a href="support.php">Support Center</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Use</a></li>
                </ul>
            </div>

            <!-- Column 4: Working Hours & Social -->
            <div class="footer-col">
                <h3>Working Hours</h3>
                <ul class="timings">
                    <li><span>Monday - Friday:</span> <span>9:00 AM – 8:00 PM</span></li>
                    <li><span>Saturday:</span> <span>10:00 AM – 4:00 PM</span></li>
                    <li><span>Sunday:</span> <span>Closed</span></li>
                </ul>
                <div class="social-links">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> CliniCare+. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
    /* ========== FOOTER PREMIUM STYLES (Self-contained) ========== */
    .clinic-footer {
        background: #0f172a;
        color: #cbd5e1;
        padding: 3rem 0 1rem;
        font-family: 'Inter', sans-serif;
        margin-top: 4rem;
        width: 100%;
        clear: both;
    }
    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .footer-col h3 {
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .footer-col p {
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .contact-info p {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .contact-info i {
        width: 1.25rem;
        color: #0ea5e9;
    }
    .footer-col ul {
        list-style: none;
        padding: 0;
    }
    .footer-col ul li {
        margin-bottom: 0.6rem;
    }
    .footer-col ul li a {
        color: #cbd5e1;
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.2s;
    }
    .footer-col ul li a:hover {
        color: white;
    }
    .timings li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.6rem;
        font-size: 0.875rem;
    }
    .social-links h4 {
        color: white;
        font-size: 1rem;
        margin: 1rem 0 0.5rem;
    }
    .social-icons {
        display: flex;
        gap: 1rem;
    }
    .social-icons a {
        background: #1e293b;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #cbd5e1;
        transition: all 0.2s;
        text-decoration: none;
    }
    .social-icons a:hover {
        background: #0ea5e9;
        color: white;
        transform: translateY(-2px);
    }
    .footer-bottom {
        border-top: 1px solid #1e293b;
        padding-top: 1.5rem;
        text-align: center;
        font-size: 0.75rem;
    }
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .contact-info p {
            justify-content: center;
        }
        .timings li {
            justify-content: center;
            gap: 1rem;
        }
        .social-icons {
            justify-content: center;
        }
    }
</style>

<!-- Closing tags (main, body, html are opened in header.php) -->
</main>
</body>
</html>