<?php
$conn = @mysqli_connect("localhost", "root", "", "your_db", 3308);
$settings = [];
if ($conn) {
    $res = @mysqli_query($conn, "SELECT * FROM site_settings");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
}
// Default values if not in DB
$hero_badge = $settings['hero_badge'] ?? 'Admissions 2026-27 Open';
$hero_h1 = $settings['hero_h1'] ?? 'A Vision for Education';
$hero_sub = $settings['hero_sub'] ?? 'Since 1985';
$hero_desc = $settings['hero_desc'] ?? 'Dr. Akhtar Rizvi Educational Trust — Excellence in Engineering, Law, Education, Arts, Science & CBSE Schooling on a 30-acre campus.';
$notice_bar = $settings['notice_bar'] ?? '🎓 Registrations Open for Academic Session 2025–26 • 📞 Toll Free: 1800-200-5802 • ⚙️ B.Tech | ⚖️ LLB | 📖 B.Ed | 🎓 B.A. / B.Sc. / B.Com | 🏫 CBSE Schools • 🌿 30-Acre Wi-Fi Campus • 🏨 Hostel Facility Available • 📍 Karari, Kaushambi, U.P.';
$hero_media = $settings['hero_media'] ?? './iamges/HOSTEL ALL.mp4';

// Site Info
$site_name = $settings['site_name'] ?? 'Rizvi Group of Institutions';
$tagline = $settings['tagline'] ?? 'Dr. Akhtar Rizvi Educational Trust';
$est_year = $settings['est_year'] ?? '1985';
$meta_desc = $settings['meta_desc'] ?? 'Rizvi Group of Institutions — Dr. Akhtar Rizvi Educational Trust. Engineering, Law, Education, Degree College, and CBSE Schools in Uttar Pradesh.';

// Contact
$toll_free = $settings['toll_free'] ?? '1800-200-5802';
$phone_1 = $settings['phone_1'] ?? '7080205245';
$phone_2 = $settings['phone_2'] ?? '7080205246';
$email = $settings['email'] ?? 'contactus@drce.org';
$address = $settings['address'] ?? 'Karari, Kaushambi, Uttar Pradesh – 212 206';

// Social
$social_fb = $settings['social_fb'] ?? '#';
$social_ig = $settings['social_ig'] ?? '#';
$social_yt = $settings['social_yt'] ?? '#';
$social_li = $settings['social_li'] ?? '#';

// Fetch gallery images
$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $meta_desc; ?>">
           <title><?php echo $site_name; ?> | <?php echo $tagline; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <!-- ══════════════════ NOTICE BAR ══════════════════ -->
<div class="notice-bar">    
    <span class="notice-label">NOTICE</span>
    <div class="notice-ticker">
        <span class="notice-text">
            <?php echo $notice_bar; ?>
        </span>
    </div>
</div>

<!-- ══════════════════ NAVIGATION ══════════════════ -->
<nav id="navbar">
    <div class="nav-logo-wrap">
        <img src="./iamges/logo.png" alt="Rizvi Group" style="height:40px;width:auto;border-radius:4px;" onerror="this.style.display='none'">
        <div class="nav-logo-text">
            <?php echo $site_name; ?>
            <small><?php echo $tagline; ?></small>
        </div>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="institution.php">Institutions</a></li>
        <li><a href="gallery.php" class="mob-link">Gallery</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="nav-right">
        <a href="form.php" class="nav-cta">Apply Now →</a>
    </div>
    <div class="hamburger" id="hamburger" aria-label="Open menu">
        <span></span><span></span><span></span>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <button class="mob-close" id="mobileClose" onclick="document.getElementById('mobileMenu').classList.remove('open');document.getElementById('hamburger').classList.remove('active');document.body.style.overflow='';">✕</button>
    <a href="index.php" class="mob-link">Home</a>
    <a href="about.php" class="mob-link">About</a>
    <a href="institution.php" class="mob-link">Institutions</a>
    <a href="gallery.php" class="mob-link">Gallery</a>
    <a href="contact.php" class="mob-link">Contact</a>
    <a href="form.php" class="mob-link mob-cta">Apply Now →</a>
</div>


<!-- ══════════════════ CAMPUS GALLERY ══════════════════ -->
<section id="gallery">
    <div class="section-header-center reveal" style="padding-top:55px">
        <div class="section-tag">Campus Tour</div>
        <h2 class="section-title">Take a Campus Tour</h2>
        <div class="divider-center"></div>
    </div>
    <div class="photo-grid">
        <div class="photo-item item-1" onclick="openLightbox(0)">
            <img src="./iamges/IMG_20241203_121147.jpg.jpeg" alt="Campus 1"/>
            <div class="photo-overlay">
                <button class="expand-btn">
                    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
            </div>
        </div>
        <div class="photo-item item-2" onclick="openLightbox(1)">
            <img src="./iamges/DSC_7284.JPG.jpeg" alt="Campus 2"/>
            <div class="photo-overlay">
                <button class="expand-btn">
                    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
            </div>
        </div>
        <div class="photo-item item-3" onclick="openLightbox(2)">
            <img src="./iamges/IMG_20241203_115257.jpg.jpeg" alt="Campus 3"/>
            <div class="photo-overlay">
                <button class="expand-btn">
                    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
            </div>
        </div>
        <div class="photo-item item-4" onclick="openLightbox(3)">
            <img src="./iamges/IMG_20241203_120704.jpg.jpeg" alt="Campus 4"/>
            <div class="photo-overlay">
                <button class="expand-btn">
                    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
            </div>
        </div>
        <div class="photo-item item-5">
            <img src="./iamges/IMG_20241203_121153.jpg.jpeg" alt="Campus 5"/>
            <div class="photo-overlay">
                <button class="expand-btn">
                    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
            </div>
        </div>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="photo-item">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Campus Image">
                <div class="photo-overlay">
                    <button class="expand-btn">
                        <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    </button>
                </div>
            </div>
        <?php } ?>

    </div>
</section>

<!-- Lightbox (single, clean) -->
<div id="lightbox">
    <div id="preview"></div>
    <div id="lb-counter"></div>
    <button id="lb-close" onclick="closeLightbox()">✕</button>
    <button class="lb-btn" id="lb-prev" onclick="prevImg()">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <img id="lightbox-image" src="" alt=""/>
    <button class="lb-btn" id="lb-next" onclick="nextImg()">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </button>
</div>

      <!-- ══════════════════ FOOTER ══════════════════ -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo-row">
                <img src="./iamges/footerlogo.png" alt="Dr. Akhtar Rizvi Educational Trust" class="footer-logo-img" onerror="this.style.display='none'">
                <div>
                    <div class="footer-brand-name"><?php echo $site_name; ?></div>
                    <div class="footer-brand-year">Est. <?php echo $est_year; ?> · Kaushambi, Uttar Pradesh</div>
                </div>
            </div>
            <p class="footer-brand-desc"><?php echo $meta_desc; ?></p>
            <a href="tel:<?php echo str_replace('-','',$toll_free); ?>" class="footer-toll-free">☎️ Toll Free: <?php echo $toll_free; ?></a>
            <div class="footer-social">
                <a href="<?php echo $social_fb; ?>" aria-label="Facebook">f</a>
                <a href="<?php echo $social_ig; ?>" aria-label="Instagram">ig</a>
                <a href="<?php echo $social_yt; ?>" aria-label="YouTube">▶</a>
                <a href="<?php echo $social_li; ?>" aria-label="LinkedIn">in</a>
            </div>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Institutions</div>
            <ul>
                <li><a href="http://www.drce.org" target="_blank" rel="noopener">Engineering College</a></li>
                <li><a href="http://rizvilaw.in" target="_blank" rel="noopener">Law College</a></li>
                <li><a href="http://www.rizvidegree.co.in" target="_blank" rel="noopener">Degree College</a></li>
                <li><a href="http://www.rizvidegree.co.in/bed.html" target="_blank" rel="noopener">College of Education</a></li>
                <li><a href="http://www.drsf.co.in" target="_blank" rel="noopener">Springfield School</a></li>
                <li><a href="http://www.rlajnp.co.in" target="_blank" rel="noopener">Learners' Academy</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Quick Links</div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#aboutUs">About Us</a></li>
                <li><a href="#features">Institutions</a></li>
                <li><a href="#campus">Campus Life</a></li>
                <li><a href="#downloads">Downloads</a></li>
                <li><a href="#">Apply Now</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Contact Us</div>
            <div class="footer-contact-list">
                <div class="footer-contact-item">
                    <div class="fc-icon">📍</div>
                    <div class="fc-text">
                        <div class="fc-label">Address</div><?php echo nl2br($address); ?>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="fc-icon">📞</div>
                    <div class="fc-text">
                        <div class="fc-label">Phone</div><a href="tel:<?php echo $phone_1; ?>"><?php echo $phone_1; ?></a> / <a href="tel:<?php echo $phone_2; ?>"><?php echo $phone_2; ?></a>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="fc-icon">✉️</div>
                    <div class="fc-text">
                        <div class="fc-label">Email</div><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="fc-icon">🕘</div>
                    <div class="fc-text">
                        <div class="fc-label">Office Hours</div>Mon – Sat, 9:00 AM – 5:00 PM
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3602.1!2d81.423434!3d25.460318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb3a1c2d4e5f6a7b8!2sRizvi+Educational+Campus!5e0!3m2!1sen!2sin!4v1!5m2!1sen!2sin"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Rizvi Educational Campus Location">
        </iframe>
    </div>
    <div class="footer-bottom">
        <div class="footer-bottom-left">
            © 2025 <span><?php echo $site_name; ?></span>. All Rights Reserved. · Dr. Akhtar Rizvi Educational Trust
        </div>
        <div class="footer-bottom-right">
            <a href="#">Privacy Policy</a>
            <span class="sep">|</span>
            <a href="#">Terms of Use</a>
            <span class="sep">|</span>
            <a href="#">Sitemap</a>
            <span class="sep">|</span>
            <a href="#newsletter">Contact</a>
        </div>
    </div>
</footer>
<div id="preview"></div>
<script src="javascript.js"></script>

<!-- Gallery logic handled by javascript.js -->
    </body>
    </html>
