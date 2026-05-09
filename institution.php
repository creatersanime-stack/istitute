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

// Fetch Downloads
$downloads = [];
if ($conn) {
    $res_dl = mysqli_query($conn, "SELECT * FROM downloads ORDER BY id DESC");
    if ($res_dl) {
        while ($row = mysqli_fetch_assoc($res_dl)) {
            $downloads[] = $row;
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

<!-- ══════════════════ INSTITUTIONS ══════════════════ -->
<section id="features">
    <div class="section-header-center reveal" style="margin-top:55px; ">
        <div class="section-tag">OUR INSTITUTIONS</div>
        <h2 class="section-title">Schoools &amp; Colleges</h2>
        <div class="divider-center"></div>
    </div>
    <div class="cards-grid" id="cardsGrid"></div>
</section>
<!-- Modal -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal-box" id="modalBox">
        <img id="mImg" class="modal-img" src="" alt=""/>
        <div class="modal-content">
            <div class="modal-title" id="mTitle"></div>
            <div class="modal-affil" id="mAffil"></div>
            <p class="modal-desc" id="mDesc"></p>
            <div class="modal-tags" id="mTags"></div>
            <div class="modal-contact" id="mContact"></div>
            <div class="modal-footer">
                <a id="mVisit" class="modal-visit " href="#" target="_blank">Visit Website →</a>
                <button class="modal-close" onclick="closeModal()">✕</button>  
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════ OTHER INSTITUTIONS ══════════════════ -->
<section id="other-inst">
    <div class="reveal">
        <div class="section-tag">Extended Family</div>
        <h2 class="section-title">Other Institutions</h2>
        <div class="divider"></div>
        <p class="section-desc">Rizvi Group's reach extends across Mumbai and Jaunpur, with over a dozen more affiliated institutions.</p>
    </div>
    <div class="other-inst-grid">
        <div class="other-inst-item reveal reveal-delay-1"><span class="other-inst-dot"></span>Rizvi College of Art, Science &amp; Commerce, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-2"><span class="other-inst-dot"></span>Rizvi College of Engineering, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-3"><span class="other-inst-dot"></span>Rizvi Institute of Management Studies &amp; Research, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-1"><span class="other-inst-dot"></span>Rizvi Academy of Business Management, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-2"><span class="other-inst-dot"></span>Rizvi College of Architecture, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-3"><span class="other-inst-dot"></span>Rizvi College of Hotel Management &amp; Catering Technology, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-1"><span class="other-inst-dot"></span>Rizvi Academy of Hospitality Management, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-2"><span class="other-inst-dot"></span>Rizvi Springfield High School, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-3"><span class="other-inst-dot"></span>Rizvi Law College, Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-1"><span class="other-inst-dot"></span>Rizvi College of Education (B.Ed.), Mumbai</div>
        <div class="other-inst-item reveal reveal-delay-2"><span class="other-inst-dot"></span>Dr. A. H. Rizvi College of Science &amp; Commerce, Jaunpur</div>
        <div class="other-inst-item reveal reveal-delay-3"><span class="other-inst-dot"></span>Meena Rizvi High School &amp; Inter College, Jaunpur</div>
        <div class="other-inst-item reveal reveal-delay-1"><span class="other-inst-dot"></span>D. M. Raza Boys School &amp; Inter College, Jaunpur</div>
    </div>
</section>

<!-- ══════════════════ DOWNLOADS ══════════════════ -->
<section id="downloads" style="padding: 80px 0; background: var(--card2);">
    <div class="container mx-auto px-4">
        <div class="section-header-center reveal">
            <div class="section-tag">RESOURCES</div>
            <h2 class="section-title">Download Prospectus</h2>
            <div class="divider-center"></div>
            <p class="section-desc" style="max-width: 600px; margin: 0 auto 40px;">Access official institution prospectuses, admission forms, and academic resources.</p>
        </div>
        
        <?php if (empty($downloads)): ?>
            <div style="text-align:center; padding:40px; color:var(--text-secondary); opacity:0.6;">
                <i class="fa fa-folder-open" style="font-size:3rem; margin-bottom:1rem; display:block;"></i>
                No download resources available at the moment.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($downloads as $d): ?>
                    <div class="reveal" style="background: var(--card); padding: 24px; border-radius: 12px; border: 1px solid var(--border); display: flex; align-items: center; gap: 16px; transition: transform 0.3s, border-color 0.3s;" onmouseover="this.style.borderColor='var(--accent)';this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='var(--border)';this.style.transform='translateY(0)'">
                        <div style="font-size: 2.5rem;"><?php echo $d['icon'] ?: '📄'; ?></div>
                        <div style="flex: 1;">
                            <h3 style="font-weight: 700; color: var(--text); margin-bottom: 4px;"><?php echo $d['title']; ?></h3>
                            <p style="font-size: 0.85rem; color: var(--text-secondary);"><?php echo $d['label']; ?></p>
                        </div>
                        <a href="<?php echo $d['url']; ?>" target="_blank" style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Download PDF">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
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
                <li><a href="form.html">Apply Now</a></li>
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
            © 2025 <span>Rizvi Group of Institutions</span>. All Rights Reserved. · Dr. Akhtar Rizvi Educational Trust
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

<!-- ══════════════════ JAVASCRIPT ══════════════════ -->
<script src="javascript.js"></script>
</body>
</html>