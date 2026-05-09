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
$notice_bar = $settings['notice_bar'] ?? '🎓 Registrations Open for Academic Session 2025–26 • 📞 Toll Free: 1800-200-5802 • ⚙️ B.Tech | ⚖️ LLB | 📖 B.Ed | 🎓 B.A. / B.Sc. / B.Com | 🏫 CBSE Schools • 🌿 30-Acre Wi-Fi Campus • 🏨 Hostel Facility Available • 📍 Karari, Kaushambi, U.P.';
$site_name = $settings['site_name'] ?? 'Rizvi Group of Institutions';
$tagline = $settings['tagline'] ?? 'Dr. Akhtar Rizvi Educational Trust';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Enquiry Form | <?php echo $site_name; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="form.css">
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
        <li><a href="index.php#features">Institutions</a></li>
        <li><a href="gallery.php" class="mob-link">Gallery</a></li>
        <li><a href="index.php#newsletter">Contact</a></li>
    </ul>
    <div class="nav-right">
        <a href="index.php" class="nav-cta">Home →</a>
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
    <a href="index.php#features" class="mob-link">Institutions</a>
    <a href="gallery.php" class="mob-link">Gallery</a>
    <a href="index.php#newsletter" class="mob-link">Contact</a>
    <a href="form.php" class="mob-link mob-cta">Apply Now →</a>
</div>
  <br> <br> <br>
<div class="gf-page">

  <!-- Header Card -->
  <div class="gf-card gf-header-card">
    <div class="gf-header-body">
      <div class="gf-form-title">Student Enquiry Form</div>
      <div class="gf-form-desc">To take admission in Dr. Rizvi Group of Institutions, Karari, Kaushambi (Uttar Pradesh)</div>
    </div>
    <div class="gf-header-divider"></div>
  
  </div>

  
  <!-- Full Name -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Full Name <span class="star">*</span></div>
      <div class="gf-input-wrap">
        <input class="gf-input" type="text" id="f-name" placeholder="Your answer"/>
      </div>
      <div class="gf-error-text" id="err-name">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#d93025"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        This is a required question
      </div>
    </div>
  </div>
  
  <!-- Father Name -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Father Name</div>
      <div class="gf-input-wrap">
        <input class="gf-input" type="text" id="f-father" placeholder="Your answer"/>
      </div>
    </div>
  </div>
  
  <!-- Email -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Email <span class="star">*</span></div>
      <div class="gf-input-wrap">
        <input class="gf-input" type="email" id="f-email" placeholder="Your email" autocomplete="email"/>
      </div>
      <div class="gf-error-text" id="err-email">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#d93025"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        This is a required question
      </div>
    </div>
  </div>
  
  <!-- Mobile Number -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Mobile Number <span class="star">*</span></div>
      <div class="gf-input-wrap">
        <input class="gf-input" type="tel" id="f-mobile" placeholder="Your answer"/>
      </div>
      <div class="gf-error-text" id="err-mobile">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#d93025"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        This is a required question
      </div>
    </div>
  </div>

  <!-- Last Class Passed -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Last Class Passed <span class="star">*</span></div>
      <div class="gf-input-wrap">
        <input class="gf-input" type="text" id="f-class" placeholder="Your answer"/>
      </div>
      <div class="gf-error-text" id="err-class">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#d93025"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        This is a required question
      </div>
    </div>
  </div>

  <!-- Address -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Address <span class="star">*</span></div>
      <div class="gf-input-wrap">
        <input class="gf-input" type="text" id="f-address" placeholder="Your answer"/>
      </div>
      <div class="gf-error-text" id="err-address">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#d93025"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        This is a required question
      </div>
    </div>
  </div>

  <!-- Want to take admission in -->
  <div class="gf-card">
    <div class="gf-question">
      <div class="gf-question-title">Want to take admission in &nbsp;<span class="star">*</span></div>
      <div class="gf-select-wrap">
        <select class="gf-select" id="f-course">
          <option value="" disabled selected>Choose</option>
          <option value="engineering">Engineering (B.Tech, MBA, Diploma)</option>
          <option value="law">Law (LLB, BALLB)</option>
          <option value="degree">Degree (BA, BSc, BCom, MA, MSc)</option>
          <option value="education">Education (B.Ed., D.El.Ed.)</option>
        </select>
        <span class="gf-select-arrow">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="#5f6368"><path d="M7 10l5 5 5-5z"/></svg>
        </span>
      </div>
      <div class="gf-error-text" id="err-course">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#d93025"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        This is a required question
      </div>
    </div>
  </div>

  <!-- Submit Row -->
  <div class="gf-card">
    <div class="gf-submit-card">
      <button class="gf-btn-submit" onclick="handleSubmit()">Submit</button>
      <button class="gf-btn-clear" onclick="handleClear()">Clear form</button>
    </div>
    <div class="gf-success" id="gf-success">
      ✅ &nbsp;Your response has been recorded.
    </div>
  </div>

 

</div>

 <br> <br>
  <!-- ══════════════════ FOOTER ══════════════════ -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo-row">
                <img src="./iamges/footerlogo.png" alt="Dr. Akhtar Rizvi Educational Trust" class="footer-logo-img" onerror="this.style.display='none'">
                <div>
                    <div class="footer-brand-name">Dr. Akhtar Rizvi<br>Educational Trust</div>
                    <div class="footer-brand-year">Est. 1985 · Kaushambi, Uttar Pradesh</div>
                </div>
            </div>
            <p class="footer-brand-desc">Building a knowledge-driven society through excellence in engineering, law, arts, science, education &amp; schooling across Uttar Pradesh and Maharashtra.</p>
            <a href="tel:18002005802" class="footer-toll-free">☎️ Toll Free: 1800-200-5802</a>
            <div class="footer-social">
                <a href="#" aria-label="Facebook">f</a>
                <a href="#" aria-label="Twitter">𝕏</a>
                <a href="#" aria-label="Instagram">ig</a>
                <a href="#" aria-label="YouTube">▶</a>
                <a href="#" aria-label="LinkedIn">in</a>
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
                        <div class="fc-label">Address</div>Karari, Kaushambi,<br>Uttar Pradesh – 212 206
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="fc-icon">📞</div>
                    <div class="fc-text">
                        <div class="fc-label">Phone</div><a href="tel:7080205245">7080205245</a> / <a href="tel:7080205246">7080205246</a>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="fc-icon">✉️</div>
                    <div class="fc-text">
                        <div class="fc-label">Email</div><a href="mailto:contactus@drce.org">contactus@drce.org</a><br><a href="mailto:rizvi_education@hotmail.com">rizvi_education@hotmail.com</a>
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


<script>
    document.getElementById('f-course').addEventListener('change', function () {
    this.classList.add('has-value');
    clearErr('f-course', 'err-course');
  });

  ['f-email','f-name','f-mobile','f-class','f-address'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', function() {
      clearErr(id, 'err-' + id.replace('f-',''));
    });
  });

  function clearErr(inputId, errId) {
    var el = document.getElementById(inputId);
    var er = document.getElementById(errId);
    if (el) el.classList.remove('error');
    if (er) er.classList.remove('show');
  }

  // Navbar scroll effect
  window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 32) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  function handleSubmit() {
    var required = [
      { id:'f-email',   err:'err-email' },
      { id:'f-name',    err:'err-name' },
      { id:'f-mobile',  err:'err-mobile' },
      { id:'f-class',   err:'err-class' },
      { id:'f-address', err:'err-address' },
    ];
    var valid = true;
    var firstBad = null;

    required.forEach(function(f) {
      var el = document.getElementById(f.id);
      var er = document.getElementById(f.err);
      if (!el.value.trim()) {
        el.classList.add('error');
        er.classList.add('show');
        if (!firstBad) firstBad = el;
        valid = false;
      } else {
        el.classList.remove('error');
        er.classList.remove('show');
      }
    });

    var sel    = document.getElementById('f-course');
    var selErr = document.getElementById('err-course');
    if (!sel.value) {
      sel.classList.add('error');
      selErr.classList.add('show');
      if (!firstBad) firstBad = sel;
      valid = false;
    } else {
      sel.classList.remove('error');
      selErr.classList.remove('show');
    }

    if (!valid) {
      firstBad.scrollIntoView({ behavior:'smooth', block:'center' });
      return;
    }

    const formData = new FormData();
    formData.append('name', document.getElementById('f-name').value);
    formData.append('father_name', document.getElementById('f-father').value);
    formData.append('email', document.getElementById('f-email').value);
    formData.append('mobile', document.getElementById('f-mobile').value);
    formData.append('last_class', document.getElementById('f-class').value);
    formData.append('address', document.getElementById('f-address').value);
    formData.append('course', document.getElementById('f-course').value);

    fetch('backend.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById('gf-success').style.display = 'block';
        document.getElementById('gf-success').scrollIntoView({ behavior:'smooth', block:'center' });
        // Optional: clear form
        setTimeout(handleClear, 3000);
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(err => {
      console.error(err);
      alert('Failed to submit form. Please try again.');
    });
  }

  function handleClear() {
    ['f-email','f-name','f-father','f-mobile','f-class','f-address'].forEach(function(id) {
      var el = document.getElementById(id);
      el.value = '';
      el.classList.remove('error');
    });
    ['err-email','err-name','err-mobile','err-class','err-address'].forEach(function(id) {
      var el = document.getElementById(id);
      if (el) el.classList.remove('show');
    });
    var sel = document.getElementById('f-course');
    sel.selectedIndex = 0;
    sel.classList.remove('has-value','error');
    document.getElementById('err-course').classList.remove('show');
    document.getElementById('gf-success').style.display = 'none';
  }
</script>

<script src="javascript.js"></script>
</body>
</html>
