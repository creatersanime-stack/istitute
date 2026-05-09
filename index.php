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
$hero_media_url = $hero_media . '?v=' . time();

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
    <button class="mob-close" id="mobileClose" aria-label="Close menu">✕</button>
    <a href="index.php" class="mob-link">Home</a>
    <a href="about.php" class="mob-link">About</a>
    <a href="institution.php" class="mob-link">Institutions</a>
    <a href="gallery.php" class="mob-link">Gallery</a>
    <a href="contact.php" class="mob-link">Contact</a>
    <a href="form.php" class="mob-link mob-cta">Apply Now →</a>
</div>

<!-- ══════════════════ HERO ══════════════════ -->
<section id="home">
    <?php if (strpos($hero_media, '.mp4') !== false): ?>
        <video autoplay muted loop playsinline>
            <source src="<?php echo $hero_media_url; ?>" type="video/mp4">
        </video>
    <?php else: ?>
        <img src="<?php echo $hero_media_url; ?>" style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;">
    <?php endif; ?>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="badge-dot"></span>
            <?php echo $hero_badge; ?>
        </div>
        <h1 class="hero-title">
            <?php echo $hero_h1; ?><br>
            <span><?php echo $hero_sub; ?></span>
        </h1>
        <p class="hero-sub">
            <?php echo $hero_desc; ?>
        </p>
        <div class="hero-actions">
            <a href="form.php" class="btn-primary">🎓 Apply Now</a>
            <a href="#aboutUs" class="btn-outline-hero">Know More</a>
        </div>
        <div class="hero-cards">
            <div class="hero-card">
                <div class="hero-card-icon">🏛️</div>
                <div class="hero-card-num">Est. <?php echo $est_year; ?></div>
                <div class="hero-card-label">40+ Years Legacy</div>
            </div>
            <div class="hero-card">
                <div class="hero-card-icon">🌿</div>
                <div class="hero-card-num">30 Acre</div>
                <div class="hero-card-label">Karari, Kaushambi</div>
            </div>
            <div class="hero-card">
                <div class="hero-card-icon">✅</div>
                <div class="hero-card-num">Approved</div>
                <div class="hero-card-label">AICTE | BCI | NCTE</div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════ VISION & MISSION ══════════════════ -->
<section id="vision">
    <div class="section-header-center reveal">
        <div class="section-tag">Philosophy</div>
        <h2 class="section-title">Vision &amp; Mission</h2>
        <div class="divider-center"></div>
    </div>

    <!-- Chairman -->
    <div class="vision-chairman">
        <div class="reveal">
            <div class="vision-chairman-img">
                <img src="./iamges/chairman.png" alt="Dr. A. H. Rizvi — Chairman & Founder">
            </div>
        </div>
        <div class="reveal reveal-delay-2">
            <div class="section-tag">Chairman &amp; Founder</div>
            <h3 class="chairman-name-head">Dr. A. H. Rizvi</h3>
            <div class="chairman-role-text">Former Member of Parliament (Rajya Sabha) · National General Secretary, NCP</div>
            <p class="chairman-desc">
                A leading educationist of India, Dr. Rizvi holds a doctorate from the University of Mumbai and a Diploma in Business Management. His selfless dedication to education has shaped generations of students across Uttar Pradesh and Maharashtra.
            </p>
            <blockquote class="chairman-blockquote">
                "His yearning to make a substantial contribution to education has enriched the quality of education. Generation after generation will reap the benefits from the educational institutions of Dr. Akhtar Rizvi Educational Trust."
            </blockquote>
        </div>  
    </div>

    <!-- Vision & Mission Cards -->
    <div class="vision-grid">
        <div class="vision-card reveal reveal-delay-1">
            <div class="vision-icon">🎯</div>
            <h4 class="vision-card-title">Our Vision</h4>
            <p class="vision-card-text">To achieve excellence by creating globally competent leaders through world-class education. We believe every student deserves the tools and environment to thrive in an interconnected, rapidly evolving world.</p>
        </div>
        <div class="vision-card reveal reveal-delay-2">
            <div class="vision-icon">🌐</div>
            <h4 class="vision-card-title">Our Mission</h4>
            <p class="vision-card-text">To achieve excellence through experiential learning — creative, futuristic, and lifelong. This empowers participants to acquire requisite skills and tools to attain personal and organizational goals, contributing to society.</p>
        </div>
    </div>
</section>

<!-- ══════════════════ ABOUT ══════════════════ -->
<section id="aboutUs">
    <div class="about-grid">
        <div class="about-img-wrap reveal">
            <img src="./iamges/DSC_0391_resize.JPG.jpeg" alt="Rizvi Educational Campus">
        </div>
        <div class="reveal reveal-delay-2">
            <div class="section-tag">About the Trust</div>
            <h2 class="section-title">A Vision for Education<br><em>Since 1985</em></h2>
            <div class="divider"></div>
            <p class="section-desc">Dr. Akhtar Rizvi Educational Trust is a premier educational organization committed to academic excellence since 1985. Registered under the Societies Act, 1950, the Trust has been promoting education at all levels across Uttar Pradesh and Maharashtra.</p>
            <p class="section-desc" style="margin-top:1rem;">The 30-acre campus at Karari, Kaushambi — approximately 45 km from Allahabad — features lush lawns, modern hostels, Wi-Fi, and own transport. Boys' hostel seats 500+ students; Girls' hostel is also in-campus.</p>
            <div class="badges-row">
                <span class="badge-pill">✅ AICTE Approved</span>
                <span class="badge-pill">✅ BCI Approved</span>
                <span class="badge-pill">✅ NCTE Approved</span>
                <span class="badge-pill">✅ CBSE Affiliated</span>
                <span class="badge-pill">✅ AKTU Affiliated</span>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════ INSTITUTIONS ══════════════════ -->
<section id="features">
    <div class="inst-header">
        <div class="reveal">
            <div class="section-tag">Our Institutions</div>
            <h2 class="section-title">Schools &amp; Colleges</h2>
            <div class="divider"></div>
        </div>
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

<!-- ══════════════════ CAMPUS FACILITIES ══════════════════ -->
<section id="campus">
    <div class="section-header-center reveal">
        <div class="section-tag">Campus Life</div>
        <h2 class="section-title">World-Class Facilities</h2>
        <div class="divider-center"></div>
        <p class="section-desc">Our sprawling 30-acre campus is designed to nurture students holistically — academically, socially, and personally.</p>
    </div>
    <div class="campus-grid">
        <div class="campus-card reveal reveal-delay-1">
            <div class="campus-card-icon">📡</div>
            <h4>Wi-Fi Campus</h4>
            <p>Entire 30-acre campus covered with high-speed Wi-Fi for seamless digital connectivity and e-learning.</p>
        </div>
        <div class="campus-card reveal reveal-delay-2">
            <div class="campus-card-icon">🏨</div>
            <h4>Boys' Hostel</h4>
            <p>In-campus hostel accommodating 500+ students with furnished rooms, mess, and 24×7 security.</p>
        </div>
        <div class="campus-card reveal reveal-delay-3">
            <div class="campus-card-icon">🏠</div>
            <h4>Girls' Hostel</h4>
            <p>Safe and comfortable in-campus accommodation for girl students with dedicated wardens and security.</p>
        </div>
        <div class="campus-card reveal reveal-delay-1">
            <div class="campus-card-icon">🚌</div>
            <h4>Transport</h4>
            <p>Daily pick-up and drop service from Allahabad city, approximately 45 km from campus.</p>
        </div>
        <div class="campus-card reveal reveal-delay-2">
            <div class="campus-card-icon">🌿</div>
            <h4>Lush Green Campus</h4>
            <p>Sprawling lawns, playgrounds, and tree-lined paths across 30 acres in a tranquil rural setting.</p>
        </div>
        <div class="campus-card reveal reveal-delay-3">
            <div class="campus-card-icon">👨‍🏫</div>
            <h4>Faculty Residences</h4>
            <p>On-campus residential flats for teaching staff ensure accessible and dedicated faculty.</p>
        </div>
    </div>
</section>

<!-- ══════════════════ STATS BANNER ══════════════════ -->
<div id="stats-banner">
    <div class="stats-bg">
        <img src="iamges/Screenshot 2026-04-29 234715.png" alt="Campus">
    </div>
    <div class="stats-overlay"></div>
    <div class="stats-inner">
        <div class="reveal">
            <div class="stat-icon-box">🏛️</div>
            <div class="stat-big"><span class="counter2" data-target="40">0</span>+</div>
            <div class="stat-small">Years of Excellence</div>
        </div>
        <div class="reveal reveal-delay-1">
            <div class="stat-icon-box">🌿</div>
            <div class="stat-big"><span class="counter2" data-target="30">0</span></div>
            <div class="stat-small">Acre Green Campus</div>
        </div>
        <div class="reveal reveal-delay-2">
            <div class="stat-icon-box">🏫</div>
            <div class="stat-big"><span class="counter2" data-target="15">0</span>+</div>
            <div class="stat-small">Institutions</div>
        </div>
        <div class="reveal reveal-delay-3">
            <div class="stat-icon-box">🏠</div>
            <div class="stat-big"><span class="counter2" data-target="500">0</span>+</div>
            <div class="stat-small">Hostel Seats</div>
        </div>
    </div>
</div>

<!-- ══════════════════ NEWS ══════════════════ -->
<section id="screenshots">
    <div class="reveal">
        <div class="section-tag">Latest Updates</div>
        <h2 class="section-title">News &amp; Announcements</h2>
        <div class="divider"></div>
    </div>
    <div class="news-grid">
        <div class="news-card reveal reveal-delay-1">
            <div class="news-body">
                <span class="news-tag">Admissions 2025</span>
                <div class="news-title">Registrations Open for Academic Session 2025–26</div>
                <p class="news-desc">Applications are now open across all programs — B.Tech, LLB, B.Ed., B.A., B.Sc., and B.Com. Fill in the online enquiry form or call our toll-free number for assistance.</p>
                <a href="form.html" class="news-more">Apply Now →</a>
            </div>
        </div>
        <div class="news-card reveal reveal-delay-2">
            <div class="news-body">
                <span class="news-tag">Infrastructure</span>
                <div class="news-title">New Digital Classrooms &amp; Labs Inaugurated on Campus</div>
                <p class="news-desc">State-of-the-art laboratories, smart classrooms, and an expanded library have been added to the Karari campus, significantly enhancing the learning experience.</p>
                <a href="#newsletter" class="news-more">Know More →</a>
            </div>
        </div>
        <div class="news-card reveal reveal-delay-3">
            <div class="news-body">
                <span class="news-tag">Scholarships</span>
                <div class="news-title">Merit Scholarships Available for New Academic Year</div>
                <p class="news-desc">Rizvi Group offers merit-based scholarships for academically excellent students joining engineering, law, and degree programs. Contact the admissions office for eligibility.</p>
                <a href="#newsletter" class="news-more">Contact Us →</a>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════ CAMPUS GALLERY ══════════════════ -->
<section id="gallery">
    <div class="section-header-center reveal">
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
        <div class="photo-item item-5" onclick="openLightbox(4)">
            <img src="./iamges/IMG_20241203_121153.jpg.jpeg" alt="Campus 5"/>
            <div class="photo-overlay">
                <button class="expand-btn">
                    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox (single, clean) -->
<div id="lightbox">
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

<!-- ══════════════════ DOWNLOAD PROSPECTUS (DYNAMIC) ══════════════════ -->
<section id="downloads">
    <div class="reveal">
        <div class="section-tag">Resources</div>
        <h2 class="section-title">Download Prospectus</h2>
        <div class="divider"></div>
        <p class="section-desc">Download official information brochures for all our institutions.</p>
    </div>
    
    <?php if (empty($downloads)): ?>
        <div style="text-align:center; padding:40px; color:var(--text-secondary); opacity:0.6;">
            No prospectuses available.
        </div>
    <?php else: ?>
        <div class="downloads-grid">
            <?php foreach ($downloads as $idx => $d): ?>
                <?php $delay = ($idx % 3) + 1; ?>
                <a href="<?php echo $d['url']; ?>" target="_blank" rel="noopener" class="dl-card reveal reveal-delay-<?php echo $delay; ?>">
                    <div class="dl-icon-wrap"><?php echo $d['icon'] ?: '📄'; ?></div>
                    <div class="dl-info">
                        <div class="dl-name"><?php echo $d['title']; ?></div>
                        <div class="dl-meta"><?php echo $d['label']; ?></div>
                    </div>
                    <div class="dl-arrow">↓</div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<!-- ══════════════════ CONTACT ══════════════════ -->
<section id="newsletter">
    <div class="contact-grid">
        <div class="reveal">
            <div class="section-tag">Get In Touch</div>
            <h2 class="section-title">Contact Us</h2>
            <div class="divider"></div>
            <p class="section-desc">Reach out for admissions queries, campus visits, or any information. Our team is always ready to help.</p>
            <div class="contact-info-items">
                <div class="ci-row">
                    <div class="ci-icon-box">📍</div>
                    <div>
                        <div class="ci-label">Campus Address</div>
                        <div class="ci-value"><?php echo nl2br($address); ?></div>
                    </div>
                </div>
                <div class="ci-row">
                    <div class="ci-icon-box">☎️</div>
                    <div>
                        <div class="ci-label">Toll Free</div>
                        <div class="ci-value"><a href="tel:<?php echo str_replace('-','',$toll_free); ?>"><?php echo $toll_free; ?></a></div>
                    </div>
                </div>
                <div class="ci-row">
                    <div class="ci-icon-box">📞</div>
                    <div>
                        <div class="ci-label">Direct Phone</div>
                        <div class="ci-value">
                            <a href="tel:<?php echo $phone_1; ?>"><?php echo $phone_1; ?></a>, 
                            <a href="tel:<?php echo $phone_2; ?>"><?php echo $phone_2; ?></a>
                        </div>
                    </div>
                </div>
                <div class="ci-row">
                    <div class="ci-icon-box">✉️</div>
                    <div>
                        <div class="ci-label">Email</div>
                        <div class="ci-value"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
                    </div>
                </div>
                <div class="ci-row">
                    <div class="ci-icon-box">🗺️</div>
                    <div>
                        <div class="ci-label">Location</div>
                        <div class="ci-value">~45 km from Allahabad Railway Station<br>on Allahabad–Sirathu Road</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reveal reveal-delay-2">
            <div class="form-wrap">
                <div class="form-title">Send a Message</div>
                <div class="form-row-2">
                    <div class="form-group"><label for="fname">Full Name *</label><input type="text" id="fname" placeholder="Your full name" autocomplete="name"></div>
                    <div class="form-group"><label for="femail">Email Address *</label><input type="email" id="femail" placeholder="you@example.com" autocomplete="email"></div>
                </div>
                <div class="form-group"><label for="fphone">Contact Number</label><input type="tel" id="fphone" placeholder="+91 00000 00000" autocomplete="tel"></div>
                <div class="form-group"><label for="fcourse">Interested In</label><input type="text" id="fcourse" placeholder="e.g. B.Tech, LLB, B.Ed..."></div>
                <div class="form-group"><label for="fmessage">Your Message *</label><textarea id="fmessage" rows="4" placeholder="How can we help you?"></textarea></div>
                <button type="button" class="form-submit" id="formSubmit">Send Message →</button>
            </div>
        </div>
    </div>
</section>



<!-- ══════════════════ FOOTER ══════════════════ -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo-row">
                <img src="./iamges/footerlogo.pnga" alt="Dr. Akhtar Rizvi Educational Trust" class="footer-logo-img" onerror="this.style.display='none'">
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
<script src="javascript.js?v=<?php echo time(); ?>"></script>
</body>
</html>