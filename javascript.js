
(function () {
    'use strict';

    /* ── Nav Scroll ── */
    var navbar = document.getElementById('navbar');
    function onScroll() { navbar.classList.toggle('scrolled', window.scrollY > 0); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ── Mobile Menu ── */
    var hamburger = document.getElementById('hamburger');
    var mobileMenu = document.getElementById('mobileMenu');
    var closeBtn = document.getElementById('mobileClose');

    function openMenu() {
        mobileMenu.classList.add('open');
        hamburger.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeMenu() {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('active');
        document.body.style.overflow = '';
    }

    function toggleMenu() {
        if (mobileMenu.classList.contains('open')) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMenu();
        });
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                closeMenu();
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu.classList.contains('open') && !mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
                closeMenu();
            }
        });

        document.querySelectorAll('.mob-link').forEach(function (a) {
            a.addEventListener('click', function () { closeMenu(); });
        });
        
        document.addEventListener('keydown', function (e) { 
            if (e.key === 'Escape' && mobileMenu.classList.contains('open')) closeMenu(); 
        });
    }

    /* ── Reveal on Scroll ── */
    var revealObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function (el) { revealObs.observe(el); });

    /* ── Counter Animation ── */
    function animCounter(el, target) {
        var start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / 1600, 1);
            var e2 = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(e2 * target);
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target;
        }
        requestAnimationFrame(step);
    }
    var cntObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) { if (e.isIntersecting) { animCounter(e.target, parseInt(e.target.dataset.target)); cntObs.unobserve(e.target); } });
    }, { threshold: 0.5 });
    document.querySelectorAll('.counter2').forEach(function (el) { cntObs.observe(el); });

    /* ── Active Nav ── */
    var navLinks = document.querySelectorAll('.nav-links a');
    var spyObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                navLinks.forEach(function (a) {
                    a.style.color = a.getAttribute('href') === '#' + e.target.id ? 'var(--primary)' : '';
                });
            }
        });
    }, { threshold: 0.35 });
    document.querySelectorAll('section[id]').forEach(function (s) { spyObs.observe(s); });

    /* ── Form Submit ── */
    var btn = document.getElementById('formSubmit');
    if (btn) {
        btn.addEventListener('click', function () {
            var n = document.getElementById('fname').value.trim();
            var em = document.getElementById('femail').value.trim();
            var ph = document.getElementById('fphone').value.trim();
            var cr = document.getElementById('fcourse').value.trim();
            var msg = document.getElementById('fmessage').value.trim();
            
            if (!n || !em || !msg) {
                btn.textContent = '⚠ Please fill required fields';
                btn.style.background = 'linear-gradient(135deg,#ef4444,#dc2626)';
                setTimeout(function () { btn.textContent = 'Send Message →'; btn.style.background = ''; }, 2500);
                return;
            }

            btn.textContent = 'Sending...';
            btn.disabled = true;

            const formData = new FormData();
            formData.append('name', n);
            formData.append('email', em);
            formData.append('phone', ph);
            formData.append('interest', cr);
            formData.append('message', msg);

            fetch('backend.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.textContent = '✓ Message Submitted!';
                    btn.style.background = 'linear-gradient(135deg,#22c55e,#16a34a)';
                    
                    // Clear form after delay
                    setTimeout(function () {
                        btn.textContent = 'Send Message →'; 
                        btn.style.background = ''; 
                        btn.disabled = false;
                        ['fname', 'femail', 'fphone', 'fcourse', 'fmessage'].forEach(function (id) { 
                            const el = document.getElementById(id);
                            if(el) el.value = ''; 
                        });
                    }, 2000);
                } else {
                    btn.textContent = 'Error: ' + data.message;
                    btn.style.background = 'linear-gradient(135deg,#ef4444,#dc2626)';
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                btn.textContent = 'Failed to send';
                btn.style.background = 'linear-gradient(135deg,#ef4444,#dc2626)';
                btn.disabled = false;
            });
        });
    }

    /* ── Smooth Scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var t = document.querySelector(a.getAttribute('href'));
            if (t) {
                e.preventDefault();
                closeMenu();
                setTimeout(function () { t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 50);
            }
        });
    });

})();
/* ── Institutions Cards ── */
var colleges = [
    {
        title: "Dr. Rizvi College of Engineering & Management",
        affil: "AICTE Approved · AKTU, Lucknow · Code: 310",
        desc: "Full-time AICTE-approved B.Tech programs in Computer Science, Civil, Electronics & Communication, Electrical & Electronics, and Mechanical Engineering. Also offers MBA and 3-year Polytechnic Diploma.",
        tags: ["B.Tech (CS)", "B.Tech (CE)", "B.Tech (EC)", "B.Tech (ME)", "MBA", "Polytechnic"],
        image: "./iamges/DSC_0391_resize.JPG.jpeg",
        website: "http://www.drce.org"
    },
    {
        title: "Dr. Rizvi Springfield School",
        affil: "CBSE Affiliated · New Delhi · Karari, Kaushambi",
        desc: "English medium CBSE school offering holistic education from Classes I–XII with highly qualified faculty, modern facilities, and an environment that goes beyond classroom learning.",
        tags: ["Classes I–XII", "CBSE"],
        image: "./iamges/Dr. Rizvi Springfield School.jpg",
        website: "http://www.drsf.co.in"
    },
    {
        title: "Dr. Rizvi College of Education",
        affil: "NCTE Approved · SCERT, Uttar Pradesh",
        desc: "Two-year B.Ed. and D.El.Ed. programs approved by National Council for Teacher Education, shaping tomorrow's educators with modern pedagogy and hands-on training.",
        tags: ["B.Ed.", "D.El.Ed."],
        image: "./iamges/Dr. Rizvi College of Education.png",
        website: "http://www.rizvidegree.co.in"
    },
    {
        title: "Dr. A. H. Rizvi Degree College",
        affil: "Rajju Bhaiya University · Code: 03063",
        desc: "Three-year graduation programs in Arts, Science & Commerce with wide subject combinations including Hindi, English, History, Economics, Mathematics, and Biological Science.",
        tags: ["B.A.", "B.Sc.", "B.Com."],
        image: "./iamges/Dr. A. H. Rizvi Degree College.png",
        website: "http://www.rizvidegree.co.in"
    },
    {
        title: "Dr. Rizvi College of Law",
        affil: "BCI Approved · Rajju Bhaiya University · Code: 03060",
        desc: "Bar Council of India approved 3-year LLB and 5-year integrated BA.LLB programs affiliated to Prof. Rajendra Singh (Rajju Bhaiya) University, Prayagraj.",
        tags: ["LL.B. (3 Years)", "BA.LLB (5 Years)"],
        image: "./iamges/dr-rizvi-college-of-law-karari-kaushambi-colleges-S0STMe6cUr.avif",
        website: "http://rizvilaw.in"
    },
    {
        title: "Dr. Rizvi Learners' Academy",
        affil: "CBSE Affiliated · Jaunpur, Uttar Pradesh",
        desc: "English medium CBSE school in Jaunpur dedicated to academic excellence and student development with qualified educators and comprehensive school facilities.",
        tags: ["Classes I–XII", "CBSE"],
        image: "./iamges/Dr. Rizvi Learners' Academy.png",
        website: "http://www.rlajnp.co.in"
    }
];

function renderCards() {
    var grid = document.getElementById('cardsGrid');
    if (!grid) return;
    grid.innerHTML = colleges.map(function (c, i) {
        return '<div class="card">' +
            '<img class="card-image" src="' + c.image + '" alt="' + c.title + '" loading="lazy"/>' +
            '<div class="card-body">' +
            '<div class="card-title">' + c.title + '</div>' +
            '<div class="card-affil">' + c.affil + '</div>' +
            '<div class="tags-row">' + c.tags.map(function (t) { return '<span class="tag">' + t + '</span>'; }).join('') + '</div>' +
            '</div>' +
            '<div class="card-footer">' +
            '<a class="visit-link" href="' + c.website + '" target="_blank">Visit Website →</a>' +
            '<button class="read-more-btn" onclick="openModal(' + i + ')">Read More <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M6 2l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>' +
            '</div></div>';
    }).join('');
}

function openModal(i) {
    var c = colleges[i];
    document.getElementById('mImg').src = c.image;
    document.getElementById('mTitle').textContent = c.title;
    document.getElementById('mAffil').textContent = c.affil;
    document.getElementById('mDesc').textContent = c.desc;
    document.getElementById('mVisit').href = c.website;
    document.getElementById('mTags').innerHTML = c.tags.map(function (t) { return '<span class="tag">' + t + '</span>'; }).join('');
    document.getElementById('mContact').innerHTML = 'Write to us<br>Rizvi Educational Campus, Karari, Kaushambi (U. P.) - 212 206<br><span class="contact-phone">Phone No. - 7080205252</span>';
    document.getElementById('modalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(e) {
    if (!e || e.target === document.getElementById('modalOverlay')) {
        document.getElementById('modalOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }
}

renderCards();

// Build gallery images dynamically
var galleryImgs = [];
var photoItems = document.querySelectorAll('.photo-item');
photoItems.forEach(function (item, index) {
    var imgEl = item.querySelector('img');
    if (imgEl) {
        galleryImgs.push(imgEl.getAttribute('src'));
    }
    item.removeAttribute('onclick'); // prevent double-triggering if static onclick is present
    item.addEventListener('click', function () {
        openLightbox(index);
    });
});

/* ── Lightbox (single clean implementation) ── */
var curImg = 0;

function openLightbox(i) {
    curImg = i;
    var lb = document.getElementById('lightbox');
    var img = document.getElementById('lightbox-image');
    img.src = galleryImgs[curImg];
    document.getElementById('lb-counter').textContent = (curImg + 1) + ' / ' + galleryImgs.length;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}

function prevImg() {
    curImg = (curImg - 1 + galleryImgs.length) % galleryImgs.length;
    updateLightbox();
}

function nextImg() {
    curImg = (curImg + 1) % galleryImgs.length;
    updateLightbox();
}

function updateLightbox() {
    var img = document.getElementById('lightbox-image');
    img.style.opacity = 0;
    setTimeout(function () {
        img.src = galleryImgs[curImg];
        document.getElementById('lb-counter').textContent = (curImg + 1) + ' / ' + galleryImgs.length;
        img.style.opacity = 1;
    }, 150);
}

document.getElementById('lightbox').addEventListener('click', function (e) {
    if (e.target === this) closeLightbox();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeLightbox(); }
    if (e.key === 'ArrowLeft') { prevImg(); }
    if (e.key === 'ArrowRight') { nextImg(); }
});








// function openLightbox(src){
//     document.getElementById("lightbox").style.display = "flex";
//     document.getElementById("lightbox-image").src = src;
// }

// function closeLightbox(){
//     document.getElementById("lightbox").style.display = "none";
// }
