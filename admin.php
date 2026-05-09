<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rizvi Group — Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="style1.css">
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🎓</div>
    <div class="logo-text">Rizvi Group
      <small>Admin Dashboard</small>
    </div>
    <button class="sidebar-close" onclick="document.getElementById('sidebar').classList.remove('open')"><i class="fa fa-times"></i></button>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section-label">Main</div>
    <div class="nav-item active" onclick="navigate('dashboard',this)">
      <span class="nav-icon"><i class="fa fa-th-large"></i></span> Dashboard
    </div>
    <div class="nav-section-label">Content</div>
    <div class="nav-item" onclick="navigate('gallery',this)">
      <span class="nav-icon"><i class="fa fa-images"></i></span> Gallery
    </div>
    <div class="nav-item" onclick="navigate('hero',this)">
      <span class="nav-icon"><i class="fa fa-film"></i></span> Hero / Banner
    </div>
    <div class="nav-section-label">Admissions</div>
    <div class="nav-item" onclick="navigate('applications',this)">
      <span class="nav-icon"><i class="fa fa-file-alt"></i></span> Applications
      <span class="badge" id="badge-apps">0</span>
    </div>
    <div class="nav-item" onclick="navigate('contacts',this)">
      <span class="nav-icon"><i class="fa fa-envelope"></i></span> Messages
      <span class="badge" id="badge-msgs">0</span>
    </div>
    <div class="nav-section-label">Settings</div>
    <div class="nav-item" onclick="navigate('downloads',this)">
      <span class="nav-icon"><i class="fa fa-download"></i></span> Downloads / PDFs
    </div>
    <div class="nav-item" onclick="navigate('settings',this)">
      <span class="nav-icon"><i class="fa fa-cog"></i></span> Site Settings
    </div>
  </nav>
  <div class="sidebar-footer">
    <div class="admin-profile">
      <div class="admin-avatar"><?php echo substr($_SESSION['admin_name'] ?? 'A', 0, 1); ?></div>
      <div class="admin-info">
        <div class="admin-name"><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></div>
        <div class="admin-role">Administrator</div>
      </div>
      <button class="btn-icon btn btn-outline" title="Logout" onclick="logout()"><i class="fa fa-sign-out-alt"></i></button>
    </div>
  </div>
</aside>

<!-- MAIN -->
<div class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left">
      <button class="topbar-btn sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
        <i class="fa fa-bars"></i>
      </button>
      <div>
        <div class="page-title" id="pageTitle">Dashboard</div>
        <div class="breadcrumb"><span>Rizvi Admin</span> <i class="fa fa-chevron-right" style="font-size:9px"></i> <span id="breadcrumb">Dashboard</span></div>
      </div>
    </div>
    <div class="topbar-right">
      <a href="http://localhost/new12345/index.php" target="_blank">
        <button class="btn btn-outline btn-sm"><i class="fa fa-external-link-alt"></i> View Site</button>
      </a>
      <div class="topbar-btn" title="Notifications" onclick="toggleNotifs(event)">
        <i class="fa fa-bell"></i>
        <span class="notif-dot" id="topbar-notif-dot"></span>
        <div class="notif-dropdown" id="notif-dropdown">
          <div class="notif-header">Notifications <span id="notif-count-label" style="color:var(--accent)">0</span></div>
          <div class="notif-list" id="notif-list">
            <!-- Items injected via JS -->
          </div>
          <div style="padding:10px;text-align:center;border-top:1px solid var(--border)">
            <button class="btn btn-outline btn-sm" style="width:100%" onclick="navigate('contacts')">View All Messages</button>
          </div>
        </div>
      </div>
      <div class="topbar-btn" title="Search" onclick="openGlobalSearch(event)">
        <i class="fa fa-search"></i>
      </div>
    </div>
  </div>

  <div class="content">

    <!-- ═══ DASHBOARD PAGE ═══ -->
    <div class="page active" id="page-dashboard">
      <div class="stats-row">
        <div class="stat-card green">
          <div class="stat-top">
            <div class="stat-label">Applications</div>
            <div class="stat-icon green"><i class="fa fa-file-alt"></i></div>
          </div>
          <div class="stat-num" id="dashAppCount">0</div>
          <div class="stat-sub"><span>+18%</span> this month</div>
        </div>
        <div class="stat-card blue">
          <div class="stat-top">
            <div class="stat-label">Gallery Images</div>
            <div class="stat-icon blue"><i class="fa fa-images"></i></div>
          </div>
          <div class="stat-num" id="dashImgCount">0</div>
          <div class="stat-sub">Across all albums</div>
        </div>
        <div class="stat-card red">
          <div class="stat-top">
            <div class="stat-label">New Messages</div>
            <div class="stat-icon red"><i class="fa fa-envelope"></i></div>
          </div>
          <div class="stat-num" id="dashMsgCount">0</div>
          <div class="stat-sub">Unread inquiries</div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="section-title"><span class="dot"></span> Quick Actions</div>
      <div class="quick-actions">
        <div class="qa-card" onclick="resetDlModal(); openModal('addPDF')">
          <div class="qa-icon" style="background:#f59e0b"><i class="fa fa-file-pdf"></i></div>
          <div class="qa-title">Add PDF / Prospectus</div>
        </div>
        <div class="qa-card" onclick="navigate('gallery',document.querySelector('[onclick*=gallery]')); openModal('uploadImg');">
          <div class="qa-icon">📷</div>
          <div class="qa-label">Upload Image</div>
        </div>
        <div class="qa-card" onclick="navigate('gallery',document.querySelector('[onclick*=gallery]')); document.getElementById('galleryFolderInput').click();">
          <div class="qa-icon">📂</div>
          <div class="qa-label">Upload Folder</div>
        </div>

        <div class="qa-card" onclick="navigate('applications',document.querySelector('[onclick*=applications]'))">
          <div class="qa-icon">📋</div>
          <div class="qa-label">View Applications</div>
        </div>
        <div class="qa-card" onclick="navigate('downloads',document.querySelector('[onclick*=downloads]'))">
          <div class="qa-icon">📄</div>
          <div class="qa-label">Manage PDFs</div>
        </div>
      </div>

      <div class="grid-2">
        <!-- Applications Chart -->
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Applications This Year</div>
          <div class="bar-chart" id="barChart"></div>
          <div style="height:24px"></div>
        </div>
        <!-- Activity Feed -->
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Recent Activity</div>
          <div class="activity-item">
            <div class="activity-dot green"></div>
            <div><div class="activity-text">New application from <strong>Rahul Sharma</strong> — B.Tech</div><div class="activity-time">2 minutes ago</div></div>
          </div>
          <div class="activity-item">
            <div class="activity-dot blue"></div>
            <div><div class="activity-text">Gallery updated: 3 new images added to Campus Tour</div><div class="activity-time">1 hour ago</div></div>
          </div>
          <div class="activity-item">
            <div class="activity-dot amber"></div>
            <div><div class="activity-text">Contact message from <strong>Priya Mishra</strong> about LLB admission</div><div class="activity-time">3 hours ago</div></div>
          </div>
          <div class="activity-item">
            <div class="activity-dot green"></div>
            <div><div class="activity-text">News post published: <em>Merit Scholarships 2025–26</em></div><div class="activity-time">Yesterday</div></div>
          </div>
          <div class="activity-item">
            <div class="activity-dot red"></div>
            <div><div class="activity-text">Application from <strong>Amir Khan</strong> marked as rejected</div><div class="activity-time">2 days ago</div></div>
          </div>
        </div>
      </div>

      <!-- Recent Applications -->
      <div class="panel">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
          <div class="section-title" style="margin:0"><span class="dot"></span> Recent Applications</div>
          <button class="btn btn-outline btn-sm" onclick="navigate('applications',document.querySelector('[onclick*=applications]'))">View All</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>#</th><th>Name</th><th>Program</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
            <tbody id="recentApps"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ INSTITUTIONS PAGE ═══ -->


    <!-- ═══ GALLERY PAGE ═══ -->
    <div class="page" id="page-gallery">
      <!-- Top bar -->
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px">
        <div class="section-title" style="margin:0"><span class="dot"></span> Gallery Manager</div>
        <div style="display:flex;gap:8px;align-items:center">
          <span id="galleryCount" style="font-size:13px;color:var(--muted)">0 images</span>
          <button class="btn btn-outline" onclick="document.getElementById('galleryFolderInput').click()"><i class="fa fa-folder-open"></i> Upload Folder</button>
          <button class="btn btn-primary" onclick="openModal('uploadImg')"><i class="fa fa-upload"></i> Upload Images</button>
        </div>
      </div>
      <input type="file" id="galleryFolderInput" webkitdirectory mozdirectory directory multiple style="display:none" onchange="handleGalleryUpload(this)">

      <!-- Filter bar -->
      <div style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;align-items:center">
        <div class="search-bar" style="flex:1;min-width:180px;margin:0">
          <i class="fa fa-search"></i>
          <input type="text" id="gallerySearch" placeholder="Search by name..." oninput="filterGallery()">
        </div>
        <button class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display:none" onclick="bulkDeleteSelected()">
          <i class="fa fa-trash"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>
      </div>

      <!-- Gallery panel -->
      <div class="panel" id="galleryPanel">
        <!-- Empty state -->
        <div id="galleryEmpty" style="text-align:center;padding:60px 20px;display:none">
          <div style="font-size:48px;margin-bottom:16px;opacity:.3"><i class="fa fa-images"></i></div>
          <div style="font-size:16px;color:var(--muted);margin-bottom:8px">No images uploaded yet</div>
          <div style="font-size:13px;color:var(--muted);margin-bottom:20px">Click "Upload Images" to add photos to the gallery</div>
          <button class="btn btn-primary" onclick="openModal('uploadImg')"><i class="fa fa-upload"></i> Upload Now</button>
        </div>
        <!-- Grid -->
        <div id="galleryGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px"></div>
      </div>
    </div>

    <!-- ═══ HERO / BANNER PAGE ═══ -->
    <div class="page" id="page-hero">
      <div class="grid-2">
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Hero Video / Image</div>
          <div class="upload-zone" onclick="document.getElementById('heroFileInput').click()">
            <input type="file" id="heroFileInput" accept="video/*,image/*" style="display:none" onchange="handleHeroUpload(this)">
            <div class="upload-icon"><i class="fa fa-film"></i></div>
            <strong>Upload Hero Video or Image</strong>
            <p>MP4 video or JPG/PNG image<br>Recommended: 1920×1080px</p>
          </div>
          <div id="heroPreview" style="margin-top:14px"></div>
        </div>
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Hero Text Content</div>
          <div class="form-group"><label>Hero Badge Text</label><input type="text" value="Admissions 2026-27 Open" id="heroBadge"></div>
          <div class="form-group"><label>Main Headline</label><input type="text" value="A Vision for Education" id="heroH1"></div>
          <div class="form-group"><label>Subtitle Line</label><input type="text" value="Since 1985" id="heroSub"></div>
          <div class="form-group"><label>Description</label><textarea id="heroDesc">Dr. Akhtar Rizvi Educational Trust — Excellence in Engineering, Law, Education, Arts, Science & CBSE Schooling on a 30-acre campus.</textarea></div>
          <div class="form-group"><label>Primary Button Text</label><input type="text" value="🎓 Apply Now"></div>
          <div class="form-group"><label>Primary Button Link</label><input type="text" value="form.php"></div>
          <button class="btn btn-primary" onclick="saveHeroSettings()"><i class="fa fa-save"></i> Save Changes</button>
        </div>
      </div>
      <div class="panel">
        <div class="section-title"><span class="dot"></span> Notice Bar</div>
        <div class="form-group"><label>Notice Bar Text</label>
          <textarea rows="3" id="noticeTxt">🎓 Registrations Open for Academic Session 2025–26 • 📞 Toll Free: 1800-200-5802 • ⚙️ B.Tech | ⚖️ LLB | 📖 B.Ed | 🎓 B.A. / B.Sc. / B.Com | 🏫 CBSE Schools • 🌿 30-Acre Wi-Fi Campus • 🏨 Hostel Facility Available • 📍 Karari, Kaushambi, U.P.</textarea>
        </div>
        <button class="btn btn-primary" onclick="saveSettings({notice_bar: document.getElementById('noticeTxt').value})"><i class="fa fa-save"></i> Update Notice Bar</button>
      </div>
    </div>

    <!-- ═══ APPLICATIONS PAGE ═══ -->
    <div class="page" id="page-applications">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
        <div class="section-title" style="margin:0"><span class="dot"></span> Application Management</div>
        <div style="display:flex;gap:8px">
          <button class="btn btn-outline btn-sm"><i class="fa fa-download"></i> Export CSV</button>
          <button class="btn btn-primary btn-sm" onclick="openModal('addApp')"><i class="fa fa-plus"></i> Add Manual</button>
        </div>
      </div>
      <div class="stats-row">
        <div class="stat-card gold"><div class="stat-top"><div class="stat-label">Total</div><div class="stat-icon gold"><i class="fa fa-users"></i></div></div><div class="stat-num" id="appTotalCount">0</div><div class="stat-sub">All applications</div></div>
        <div class="stat-card green"><div class="stat-top"><div class="stat-label">Approved</div><div class="stat-icon green"><i class="fa fa-check"></i></div></div><div class="stat-num">189</div><div class="stat-sub"><span>76%</span> approval rate</div></div>
        <div class="stat-card blue"><div class="stat-top"><div class="stat-label">Pending</div><div class="stat-icon blue"><i class="fa fa-clock"></i></div></div><div class="stat-num" id="appPendingCount">0</div><div class="stat-sub">Awaiting review</div></div>
        <div class="stat-card red"><div class="stat-top"><div class="stat-label">Rejected</div><div class="stat-icon red"><i class="fa fa-times"></i></div></div><div class="stat-num">12</div><div class="stat-sub">This semester</div></div>
      </div>
      <div class="panel">
        <div style="display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap">
          <div class="search-bar" style="flex:1;min-width:200px;margin:0">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search applications..." oninput="filterTable(this,'appTable')">
          </div>
          <select style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:9px 12px;color:var(--text);font-family:inherit;font-size:13px" onchange="filterByProgram(this.value)">
            <option value="">All Programs</option>
            <option>B.Tech</option><option>LLB</option><option>BA.LLB</option>
            <option>B.Ed</option><option>B.A.</option><option>B.Sc.</option><option>B.Com</option>
          </select>
        </div>
        <div class="table-wrap">
          <table id="appTable">
            <thead><tr><th>#</th><th>Name</th><th>Phone</th><th>Program</th><th>Applied On</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody id="appBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ CONTACTS / MESSAGES PAGE ═══ -->
    <div class="page" id="page-contacts">
      <div class="section-title"><span class="dot"></span> Contact Messages</div>
      <div class="panel">
        <div class="table-wrap">
          <table>
            <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Interest</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
            <tbody id="contactBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ DOWNLOADS PAGE ═══ -->
    <div class="page" id="page-downloads">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
        <div class="section-title" style="margin:0"><span class="dot"></span> Downloads & Prospectus</div>
        <button class="btn btn-primary" onclick="openModal('addPDF')"><i class="fa fa-plus"></i> Add PDF</button>
      </div>
      <div class="panel">
        <div class="table-wrap">
          <table>
            <thead><tr><th>Title</th><th>Label</th><th>File URL</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody id="dlBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ SETTINGS PAGE ═══ -->
    <div class="page" id="page-settings">
      <div class="grid-2">
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Site Information</div>
          <div class="form-group"><label>Site Name</label><input type="text" id="set-site-name" value="Rizvi Group of Institutions"></div>
          <div class="form-group"><label>Tagline</label><input type="text" id="set-tagline" value="Dr. Akhtar Rizvi Educational Trust"></div>
          <div class="form-group"><label>Est. Year</label><input type="text" id="set-est-year" value="1985"></div>
          <div class="form-group"><label>Meta Description</label><textarea id="set-meta-desc" rows="3">Rizvi Group of Institutions — Dr. Akhtar Rizvi Educational Trust. Engineering, Law, Education, Degree College, and CBSE Schools in Uttar Pradesh.</textarea></div>
          <button class="btn btn-primary" onclick="saveSettings({
            site_name: document.getElementById('set-site-name').value,
            tagline: document.getElementById('set-tagline').value,
            est_year: document.getElementById('set-est-year').value,
            meta_desc: document.getElementById('set-meta-desc').value
          })"><i class="fa fa-save"></i> Save</button>
        </div>
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Contact Details</div>
          <div class="form-group"><label>Toll Free</label><input type="text" id="set-toll-free" value="1800-200-5802"></div>
          <div class="form-row">
            <div class="form-group" style="margin:0"><label>Phone 1</label><input type="text" id="set-phone-1" value="7080205245"></div>
            <div class="form-group" style="margin:0"><label>Phone 2</label><input type="text" id="set-phone-2" value="7080205246"></div>
          </div>
          <div class="form-group"><label>Email</label><input type="text" id="set-email" value="contactus@drce.org"></div>
          <div class="form-group"><label>Address</label><textarea id="set-address" rows="2">Karari, Kaushambi, Uttar Pradesh – 212 206</textarea></div>
          <button class="btn btn-primary" onclick="saveSettings({
            toll_free: document.getElementById('set-toll-free').value,
            phone_1: document.getElementById('set-phone-1').value,
            phone_2: document.getElementById('set-phone-2').value,
            email: document.getElementById('set-email').value,
            address: document.getElementById('set-address').value
          })"><i class="fa fa-save"></i> Save</button>
        </div>
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Social Media Links</div>
          <div class="form-group"><label><i class="fab fa-facebook" style="color:#4267B2"></i> Facebook</label><input type="text" id="set-fb" placeholder="https://facebook.com/..."></div>
          <div class="form-group"><label><i class="fab fa-instagram" style="color:#E1306C"></i> Instagram</label><input type="text" id="set-ig" placeholder="https://instagram.com/..."></div>
          <div class="form-group"><label><i class="fab fa-youtube" style="color:#FF0000"></i> YouTube</label><input type="text" id="set-yt" placeholder="https://youtube.com/..."></div>
          <div class="form-group"><label><i class="fab fa-linkedin" style="color:#0077B5"></i> LinkedIn</label><input type="text" id="set-li" placeholder="https://linkedin.com/..."></div>
          <button class="btn btn-primary" onclick="saveSettings({
            social_fb: document.getElementById('set-fb').value,
            social_ig: document.getElementById('set-ig').value,
            social_yt: document.getElementById('set-yt').value,
            social_li: document.getElementById('set-li').value
          })"><i class="fa fa-save"></i> Save</button>
        </div>
        <div class="panel">
          <div class="section-title"><span class="dot"></span> Admin Account & Security</div>
          <div class="form-group"><label>Username</label><input type="text" id="set-admin-user" placeholder="admin"></div>
          <div class="form-group"><label>Full Name</label><input type="text" id="set-admin-name" placeholder="Super Admin"></div>
          <hr style="margin:20px 0;border:0;border-top:1px solid var(--border)">
          <div class="form-group"><label>Current Password (Required for any change)</label><input type="password" id="set-curr-pass" placeholder="••••••••"></div>
          <div class="form-group"><label>New Password (Leave blank to keep current)</label><input type="password" id="set-new-pass" placeholder="••••••••"></div>
          <div class="form-group"><label>Confirm New Password</label><input type="password" id="set-conf-pass" placeholder="••••••••"></div>
          <button class="btn btn-primary" onclick="updateAdminProfile()"><i class="fa fa-shield-alt"></i> Update Profile & Security</button>
        </div>
      </div>
    </div>

  </div><!-- /content -->
</div><!-- /main -->

<!-- ═══ MODALS ═══ -->

<div class="modal-bg" id="modal-uploadImg">
  <div class="modal" style="width:560px">
    <form action="backend.php" method="POST" enctype="multipart/form-data" id="galleryUploadForm">
      <div class="modal-header">
        <div class="modal-title">Upload Images to Gallery</div>
        <button type="button" class="modal-close" onclick="closeModal('uploadImg')"><i class="fa fa-times"></i></button>
      </div>
      <input type="hidden" name="album" value="Gallery">
      <div class="upload-zone" id="uploadZone"
        onclick="document.getElementById('galleryFileInput').click()"
        ondragover="event.preventDefault();this.style.borderColor='var(--accent)'"
        ondragleave="this.style.borderColor='var(--border)'"
        ondrop="handleDrop(event)">
        <input type="file" name="images[]" id="galleryFileInput" accept="image/*" multiple style="display:none" onchange="handleGalleryUpload(this)">
        <div class="upload-icon"><i class="fa fa-cloud-upload-alt"></i></div>
        <strong>Click or Drag & Drop Images</strong>
        <p>JPG, PNG, WebP, GIF · Multiple files allowed</p>
        <div style="margin-top:15px">
          <button type="button" class="btn btn-outline btn-sm" onclick="event.stopPropagation();document.getElementById('galleryFolderInput').click()"><i class="fa fa-folder"></i> Or Select Folder</button>
        </div>
      </div>
      <!-- Preview queue -->
      <div id="uploadPreviewWrap" style="display:none;margin-top:14px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
          <span style="font-size:12px;color:var(--muted)" id="previewCountLabel">0 files selected</span>
          <button type="button" class="btn btn-outline btn-sm" onclick="clearUploadQueue()"><i class="fa fa-times"></i> Clear</button>
        </div>
        <div id="uploadPreview" style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;max-height:200px;overflow-y:auto"></div>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px">
        <button type="button" class="btn btn-outline" onclick="closeModal('uploadImg')">Cancel</button>
        <button type="submit" class="btn btn-primary" id="saveGalleryBtn" disabled style="opacity:.5">
          <i class="fa fa-save"></i> Save to Gallery
        </button>
      </div>
    </form>
  </div>
</div>


<div class="modal-bg" id="modal-addApp">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Add Application</div><button class="modal-close" onclick="closeModal('addApp')"><i class="fa fa-times"></i></button></div>
    <div class="form-row">
      <div class="form-group" style="margin:0"><label>Full Name</label><input type="text" id="appName" placeholder="Student name"></div>
      <div class="form-group" style="margin:0"><label>Phone</label><input type="tel" id="appPhone" placeholder="Mobile number"></div>
    </div>
    <div class="form-row">
      <div class="form-group" style="margin:0"><label>Program</label><select id="appProgram"><option>B.Tech</option><option>LLB</option><option>BA.LLB</option><option>B.Ed</option><option>B.A.</option><option>B.Sc.</option><option>B.Com</option></select></div>
      <div class="form-group" style="margin:0"><label>Status</label><select id="appStatus"><option>Pending</option><option>Approved</option><option>Rejected</option></select></div>
    </div>
    <div class="form-group"><label>Email</label><input type="email" id="appEmail" placeholder="Email address"></div>
    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
      <button class="btn btn-outline" onclick="closeModal('addApp')">Cancel</button>
      <button class="btn btn-primary" onclick="addApplication()"><i class="fa fa-save"></i> Save</button>
    </div>
  </div>
</div>

<div class="modal-bg" id="modal-addPDF">
  <div class="modal">
    <div class="modal-header"><div class="modal-title" id="dlModalTitle">Add Download / PDF</div><button class="modal-close" onclick="closeModal('addPDF')"><i class="fa fa-times"></i></button></div>
    <input type="hidden" id="dlEditId" value="">
    <div class="form-group"><label>Title *</label><input type="text" id="dlTitle" placeholder="e.g. Engineering Prospectus"></div>
    <div class="form-group"><label>Label / Description</label><input type="text" id="dlLabel" placeholder="e.g. PDF · B.Tech, MBA"></div>
    <div class="form-row">
      <div class="form-group"><label>Category</label><select id="dlCat"><option>Engineering</option><option>Law</option><option>Education</option><option>Degree</option><option>School</option><option>General</option></select></div>
      <div class="form-group"><label>Icon (emoji)</label><input type="text" id="dlIcon" placeholder="📄" value="📄"></div>
    </div>
    <div class="form-group">
      <label>Upload PDF File <span id="dlFileNote" style="font-size:10px;color:var(--muted)">(Optional if URL provided)</span></label>
      <input type="file" id="dlFile" accept=".pdf">
      <div id="dlCurrentFile" style="margin-top:8px; font-size:12px; display:none;">
        <span style="color:var(--muted)">Current File:</span> <a href="#" id="dlCurrentFileLink" target="_blank" style="color:var(--accent);text-decoration:underline">view file</a>
      </div>
    </div>
    <div class="form-group" id="dlUrlGroup"><label>OR PDF URL</label><input type="text" id="dlUrl" placeholder="https://..."></div>
    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:10px">
      <button class="btn btn-outline" onclick="closeModal('addPDF')">Cancel</button>
      <button class="btn btn-primary" onclick="addDownload()"><i class="fa fa-save"></i> <span id="dlSubmitBtnText">Save Download</span></button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">
  <span class="toast-icon"><i class="fa fa-check-circle"></i></span>
  <span id="toastMsg">Action completed</span>
</div>

<script>
// ═══════════════════════════════════════════════════════
// DATA
// ═══════════════════════════════════════════════════════
let applications = [];
let contacts = [];
let downloads = [];
let galleryImages = [];
let gallerySelected = new Set(); // ids of checked images
let uploadQueue = [];            // files staged in modal
let toastTimer;
let currentMsgIdx = -1;
let currentAppIdx = -1;

// ─── NAVIGATION ────────────────────────────────────────
function navigate(page, el){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
  document.getElementById('page-'+page).classList.add('active');
  if(el) el.classList.add('active');
  const title = page.charAt(0).toUpperCase()+page.slice(1).replace(/([A-Z])/g,' $1');
  document.getElementById('pageTitle').textContent = title;
  document.getElementById('breadcrumb').textContent = title;
  if(page==='gallery'){ gallerySelected.clear(); renderGalleryPage(); }
  if(window.innerWidth<900) document.getElementById('sidebar').classList.remove('open');
}

// ═══════════════════════════════════════════════════════
// GALLERY RENDER
// ═══════════════════════════════════════════════════════
function renderGalleryPage(){
  renderGalleryGrid();
}


function renderApplications(){
  const tb=document.getElementById('appBody'); tb.innerHTML='';
  if (applications.length === 0) {
    tb.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">No applications found in database.</td></tr>';
    return;
  }
  applications.forEach((a,idx)=>{
    const s=a.status==='Approved'?'active':a.status==='Pending'?'pending':'inactive';
    const tr=document.createElement('tr');
    tr.innerHTML=`<td style="color:var(--muted)">#${a.id}</td><td><strong style="color:var(--text)">${a.name}</strong></td><td>${a.phone}</td><td><span class="tag new">${a.program}</span></td><td style="color:var(--muted)">${a.date}</td><td><span class="tag ${s}">${a.status}</span></td><td><div style="display:flex;gap:6px"><button class="btn btn-outline btn-sm btn-icon" onclick="viewApplication(${idx})"><i class="fa fa-eye"></i></button><button class="btn btn-danger btn-sm btn-icon" onclick="deleteApplication(${idx})"><i class="fa fa-trash"></i></button></div></td>`;
    tb.appendChild(tr);
  });
}

function renderContacts(){
  const tb=document.getElementById('contactBody'); tb.innerHTML='';
  if (contacts.length === 0) {
    tb.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">No contacts found in database.</td></tr>';
    return;
  }
  contacts.forEach((c,idx)=>{
    const s = c.status === 'New' ? 'pending' : 'active';
    const tagClass = c.status === 'New' ? 'tag new' : 'tag inactive';
    const tr=document.createElement('tr');
    tr.innerHTML=`<td><strong style="color:var(--text)">${c.name}</strong></td><td style="color:var(--muted)">${c.email}</td><td>${c.phone}</td><td><span class="${tagClass}">${c.interest}</span></td><td style="color:var(--muted)">${c.date}</td><td><span class="tag ${s}">${c.status}</span></td><td><div style="display:flex;gap:6px"><button class="btn btn-outline btn-sm btn-icon" onclick="viewMessage(${idx})"><i class="fa fa-eye"></i></button><button class="btn btn-danger btn-sm btn-icon" onclick="deleteMessage(${idx})"><i class="fa fa-trash"></i></button></div></td>`;
    tb.appendChild(tr);
  });
}

function renderDownloads(){
  const tb=document.getElementById('dlBody'); 
  if(!tb) return;
  tb.innerHTML='';
  if (downloads.length === 0) {
    tb.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">No downloads found in database.</td></tr>';
    return;
  }
  downloads.forEach((d,idx)=>{
    const tr=document.createElement('tr');
    tr.innerHTML=`<td><span style="font-size:18px">${d.icon || '📄'}</span> <strong style="color:var(--text);margin-left:8px">${d.title}</strong></td><td style="color:var(--muted);font-size:12px">${d.label}</td><td><a href="${d.url}" target="_blank" style="color:var(--accent);font-size:12px;word-break:break-all">${d.url}</a></td><td><span class="tag new">${d.category}</span></td><td><span class="tag active">Active</span></td><td><div style="display:flex;gap:6px"><button class="btn btn-outline btn-sm btn-icon" onclick="openEditDownload(${idx})"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-sm btn-icon" onclick="deleteDownload(${idx})"><i class="fa fa-trash"></i></button></div></td>`;
    tb.appendChild(tr);
  });
}

function getFilteredImages(){
  const q = (document.getElementById('gallerySearch')||{value:''}).value.toLowerCase().trim();
  return galleryImages.filter(img=>{
    return !q || img.name.toLowerCase().includes(q);
  });
}

function filterGallery(){
  renderGalleryGrid();
}

function renderGalleryGrid(){
  const grid = document.getElementById('galleryGrid');
  const empty = document.getElementById('galleryEmpty');
  const countEl = document.getElementById('galleryCount');
  if(!grid) return;

  const filtered = getFilteredImages();
  const total = galleryImages.length;

  if(countEl) countEl.textContent = `${total} image${total!==1?'s':''}`;
  const dashImg = document.getElementById('dashImgCount');
  if(dashImg) dashImg.textContent = total;

  grid.innerHTML = '';

  if(total===0){
    empty.style.display='block';
    grid.style.display='none';
    return;
  }
  empty.style.display='none';
  grid.style.display='grid';

  if(filtered.length===0){
    grid.innerHTML=`<div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--muted)">
      <i class="fa fa-search" style="font-size:28px;margin-bottom:12px;display:block;opacity:.4"></i>
      No images match your search
    </div>`;
    return;
  }

  filtered.forEach(img=>{
    const isSelected = gallerySelected.has(img.id);
    const card = document.createElement('div');
    card.style.cssText='position:relative;border-radius:var(--radius-sm);overflow:hidden;background:var(--card2);aspect-ratio:1;cursor:pointer;border:2px solid '+(isSelected?'var(--accent)':'transparent')+';transition:border-color .2s';
    card.innerHTML = `
      <img src="${img.src}" alt="${img.name}"
        style="width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s"
        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
      <!-- Select checkbox -->
      <div style="position:absolute;top:7px;left:7px;z-index:2" onclick="event.stopPropagation();toggleSelect('${img.id}')">
        <div style="width:20px;height:20px;border-radius:4px;background:${isSelected?'var(--accent)':'rgba(0,0,0,.55)'};border:2px solid ${isSelected?'var(--accent)':'rgba(255,255,255,.6)'};display:flex;align-items:center;justify-content:center;transition:all .15s">
          ${isSelected?'<i class="fa fa-check" style="font-size:10px;color:#0f1117"></i>':''}
        </div>
      </div>
      <!-- Name badge -->
      <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.75));padding:20px 8px 7px;pointer-events:none">
        <div style="font-size:11px;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${img.name}</div>
      </div>
      <!-- Delete btn -->
      <div style="position:absolute;top:7px;right:7px;opacity:0;transition:opacity .2s" class="del-btn">
        <button onclick="event.stopPropagation();deleteGalleryImage('${img.id}')"
          style="width:26px;height:26px;border-radius:6px;background:var(--danger);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    `;
    card.onmouseover = ()=>{ card.querySelector('.del-btn').style.opacity='1'; };
    card.onmouseout  = ()=>{ card.querySelector('.del-btn').style.opacity='0'; };
    card.onclick = ()=>{ openLightboxGallery(img); };
    grid.appendChild(card);
  });
}

function toggleSelect(id){
  if(gallerySelected.has(id)) gallerySelected.delete(id);
  else gallerySelected.add(id);
  updateBulkBar();
  renderGalleryGrid();
}

function updateBulkBar(){
  const btn = document.getElementById('bulkDeleteBtn');
  const sc = document.getElementById('selectedCount');
  const count = gallerySelected.size;
  if(btn){ btn.style.display = count>0?'flex':'none'; }
  if(sc){ sc.textContent = count; }
}

function bulkDeleteSelected(){
  if(!gallerySelected.size) return;
  const cnt = gallerySelected.size;
  galleryImages = galleryImages.filter(img=>!gallerySelected.has(img.id));
  gallerySelected.clear();
  updateBulkBar();
  renderGalleryPage();
  showToast(`${cnt} image${cnt>1?'s':''} deleted`);
}



// ─── LIGHTBOX ──────────────────────────────────────────
let lbIndex = 0;
function openLightboxGallery(img){
  const filtered = getFilteredImages();
  lbIndex = filtered.findIndex(i=>i.id===img.id);
  showLightboxAt(lbIndex, filtered);
}
function showLightboxAt(idx, arr){
  if(!arr) arr = getFilteredImages();
  if(idx<0||idx>=arr.length) return;
  lbIndex = idx;
  const img = arr[idx];
  let lb = document.getElementById('adminLightbox');
  if(!lb){
    lb = document.createElement('div');
    lb.id='adminLightbox';
    lb.style.cssText='position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px';
    lb.onclick=e=>{if(e.target===lb)closeLightboxGallery();};
    document.body.appendChild(lb);
  }
  lb.style.display='flex';
  lb.innerHTML=`
    <button onclick="closeLightboxGallery()" style="position:absolute;top:20px;right:24px;background:rgba(255,255,255,.1);border:none;color:#fff;width:38px;height:38px;border-radius:50%;cursor:pointer;font-size:18px">✕</button>
    <div style="position:absolute;top:20px;left:24px;font-size:13px;color:rgba(255,255,255,.6)">${idx+1} / ${arr.length}</div>
    <button onclick="showLightboxAt(${idx-1})" ${idx===0?'disabled':''}
      style="position:absolute;left:20px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:44px;height:44px;border-radius:50%;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center">‹</button>
    <img src="${img.src}" alt="${img.name}" style="max-width:90vw;max-height:80vh;object-fit:contain;border-radius:8px">
    <div style="text-align:center">
      <div style="color:#fff;font-size:14px;font-weight:500">${img.name}</div>
      <div style="color:rgba(255,255,255,.5);font-size:12px;margin-top:3px">${img.addedAt}</div>
    </div>
    <button onclick="showLightboxAt(${idx+1})" ${idx===arr.length-1?'disabled':''}
      style="position:absolute;right:20px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:44px;height:44px;border-radius:50%;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center">›</button>
  `;
}
function closeLightboxGallery(){
  const lb=document.getElementById('adminLightbox');
  if(lb) lb.style.display='none';
}

// ═══════════════════════════════════════════════════════
// UPLOAD MODAL LOGIC
// ═══════════════════════════════════════════════════════
function handleGalleryUpload(input) {
  console.log('Files selected:', input.files.length);
  const extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  const files = Array.from(input.files).filter(f => {
    const ext = f.name.split('.').pop().toLowerCase();
    return f.type.startsWith('image/') || extensions.includes(ext);
  });
  console.log('Image files filtered:', files.length);
  
  if (files.length > 0) {
    files.forEach(file => {
      uploadQueue.push({file, url: URL.createObjectURL(file)});
    });
    openModal('uploadImg', true);
    renderUploadPreview();
  } else {
    showToast('No valid images found in selection');
  }
  input.value = '';
}

function handleDrop(e){
  e.preventDefault();
  document.getElementById('uploadZone').style.borderColor='var(--border)';
  const files = Array.from(e.dataTransfer.files).filter(f=>f.type.startsWith('image/'));
  files.forEach(file=>{
    uploadQueue.push({file, url: URL.createObjectURL(file)});
  });
  renderUploadPreview();
}

function renderUploadPreview(){
  const wrap = document.getElementById('uploadPreviewWrap');
  const prev = document.getElementById('uploadPreview');
  const saveBtn = document.getElementById('saveGalleryBtn');
  const label = document.getElementById('previewCountLabel');
  if(!uploadQueue.length){
    wrap.style.display='none';
    saveBtn.disabled=true; saveBtn.style.opacity='.5';
    return;
  }
  wrap.style.display='block';
  saveBtn.disabled=false; saveBtn.style.opacity='1';
  label.textContent = uploadQueue.length+' file'+(uploadQueue.length>1?'s':'')+' ready to upload';
  prev.innerHTML='';
  const maxPreview = 30;
  uploadQueue.slice(0, maxPreview).forEach((item,idx)=>{
    const d=document.createElement('div');
    d.style.cssText='position:relative;aspect-ratio:1;border-radius:6px;overflow:hidden;background:var(--card2)';
    d.innerHTML=`<img src="${item.url}" style="width:100%;height:100%;object-fit:cover">
      <button onclick="removeFromQueue(${idx})" style="position:absolute;top:3px;right:3px;width:20px;height:20px;border-radius:50%;background:var(--danger);border:none;color:#fff;cursor:pointer;font-size:10px;display:flex;align-items:center;justify-content:center">✕</button>`;
    prev.appendChild(d);
  });
  if (uploadQueue.length > maxPreview) {
    const more = document.createElement('div');
    more.style.cssText = 'display:flex;align-items:center;justify-content:center;background:var(--card2);font-size:11px;color:var(--muted);border-radius:6px';
    more.textContent = `+${uploadQueue.length - maxPreview} more`;
    prev.appendChild(more);
  }
}

function removeFromQueue(idx){
  URL.revokeObjectURL(uploadQueue[idx].url);
  uploadQueue.splice(idx,1);
  renderUploadPreview();
}

function clearUploadQueue(){
  uploadQueue.forEach(i=>URL.revokeObjectURL(i.url));
  uploadQueue=[];
  renderUploadPreview();
}

async function fetchGalleryImages() {
  console.log('Fetching gallery images...');
  try {
    const response = await fetch('backend.php?v=' + Date.now());
    const data = await response.json();
    console.log('Gallery Data:', data);
    if (data.success) {
      galleryImages = data.images || [];
      renderGalleryPage();
    } else {
      console.error('Gallery Fetch Error:', data.message);
    }
  } catch (error) {
    console.error('Error fetching gallery:', error);
  }
}

async function fetchApplications() {
  console.log('Fetching applications...');
  try {
    const response = await fetch('backend.php?type=admissions&v=' + Date.now());
    const data = await response.json();
    console.log('Admissions Data:', data);
    if (data.success) {
      applications = (data.admissions || []).map((a, idx) => ({
        id: a.id,
        idx: idx,
        name: a.name,
        father: a.father_name,
        email: a.email,
        phone: a.mobile,
        class: a.last_class,
        address: a.address,
        program: a.course,
        date: new Date(a.created_at).toLocaleDateString('en-IN'),
        status: a.status || 'Pending',
        rawDate: new Date(a.created_at)
      }));
      renderApplications();
      renderRecentApps();
      renderChart();
      updateDashboardStats();
      renderNotifications();
    }
  } catch (error) {
    console.error('Error fetching applications:', error);
  }
}

async function fetchMessages() {
  console.log('Fetching messages...');
  try {
    const response = await fetch('backend.php?type=messages&v=' + Date.now());
    const data = await response.json();
    console.log('Messages Data:', data);
    if (data.success) {
      contacts = (data.messages || []).map(m => ({
        id: m.id,
        name: m.name,
        email: m.email,
        phone: m.phone,
        interest: m.interest,
        date: new Date(m.created_at).toLocaleDateString('en-IN'),
        status: m.status || 'New'
      }));
      renderContacts();
      updateDashboardStats();
      renderNotifications();
    }
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
}

function updateDashboardStats() {
  const appTotal = applications.length;
  const appPending = applications.filter(a => a.status === 'Pending').length;
  const msgNew = contacts.filter(c => c.status === 'New').length;
  const msgTotal = contacts.length;
  const imgTotal = galleryImages.length;
  
  // Update badges
  // Update badges via IDs
  const bApps = document.getElementById('badge-apps');
  const bMsgs = document.getElementById('badge-msgs');
  
  if (bApps) {
    bApps.textContent = appPending;
    bApps.style.display = appPending > 0 ? 'block' : 'none';
  }
  if (bMsgs) {
    bMsgs.textContent = msgNew;
    bMsgs.style.display = msgNew > 0 ? 'block' : 'none';
  }
  
  // Update dashboard stat cards
  const dApp = document.getElementById('dashAppCount');
  const dImg = document.getElementById('dashImgCount');
  const dMsg = document.getElementById('dashMsgCount');
  const aTot = document.getElementById('appTotalCount');
  const aPen = document.getElementById('appPendingCount');

  if (dApp) dApp.textContent = appTotal;
  if (dImg) dImg.textContent = imgTotal;
  if (dMsg) {
    dMsg.textContent = msgNew;
    const sub = dMsg.closest('.stat-card').querySelector('.stat-sub');
    if (sub) sub.innerHTML = `<span style="color:${msgNew>0?'var(--danger)':'var(--success)'}">${msgNew} Pending</span> / ${msgTotal} Total`;
    const card = dMsg.closest('.stat-card');
    if (card) {
      if (msgNew === 0) {
        card.classList.remove('red');
        card.classList.add('green'); 
      } else {
        card.classList.add('red');
        card.classList.remove('green');
      }
    }
  }
  
  const appCard = dApp ? dApp.closest('.stat-card') : null;
  if (appCard) {
    const sub = appCard.querySelector('.stat-sub');
    if (sub) sub.innerHTML = `<span style="color:${appPending>0?'var(--danger)':'var(--success)'}">${appPending} Pending</span> / ${appTotal} Total`;
    if (appPending === 0) {
      appCard.classList.remove('red');
      appCard.classList.add('green');
    } else {
      appCard.classList.add('red');
      appCard.classList.remove('green');
    }
  }
  if (aTot) aTot.textContent = appTotal;
  if (aPen) aPen.textContent = appPending;
}

async function markReplied(idx) {
  const msg = contacts[idx];
  try {
    const formData = new FormData();
    formData.append('action', 'update_status');
    formData.append('type', 'messages');
    formData.append('id', msg.id);
    formData.append('status', 'Replied');
    const response = await fetch('backend.php', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    if (data.success) {
      showToast('Status updated to Replied');
      fetchMessages();
    }
  } catch (error) {
    console.error(error);
  }
}

async function updateAppStatus(idx, status) {
  const app = applications[idx];
  try {
    const formData = new FormData();
    formData.append('action', 'update_status');
    formData.append('type', 'admissions');
    formData.append('id', app.id);
    formData.append('status', status);
    const response = await fetch('backend.php', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    if (data.success) {
      showToast('Application status updated');
      fetchApplications();
    }
  } catch (error) {
    console.error(error);
  }
}

function viewApplication(idx) {
  currentAppIdx = idx;
  const a = applications[idx];
  const content = `
    <div style="padding:10px">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
        <div><div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Full Name</div><div style="font-weight:600">${a.name}</div></div>
        <div><div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Father's Name</div><div style="font-weight:600">${a.father || 'N/A'}</div></div>
        <div><div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Phone Number</div><div style="font-weight:600">${a.phone}</div></div>
        <div><div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Email Address</div><div style="font-weight:600">${a.email || 'N/A'}</div></div>
        <div><div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Interested In</div><div style="font-weight:600"><span class="tag new">${a.program}</span></div></div>
        <div><div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Last Class/School</div><div style="font-weight:600">${a.class || 'N/A'}</div></div>
      </div>
      <div style="margin-bottom:20px">
        <div style="font-size:11px;color:var(--muted);text-transform:uppercase;margin-bottom:4px">Full Address</div>
        <div style="background:var(--card2);padding:12px;border-radius:8px;font-size:14px;line-height:1.5">${a.address || 'N/A'}</div>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;padding-top:15px;border-top:1px solid var(--border)">
        <div><span style="font-size:12px;color:var(--muted)">Applied on ${a.date}</span></div>
        <div>Status: <span class="tag ${a.status==='Approved'?'active':a.status==='Pending'?'pending':'inactive'}">${a.status}</span></div>
      </div>
    </div>
  `;
  document.getElementById('viewAppContent').innerHTML = content;
  openModal('viewApp');
}

function viewMessage(idx) {
  currentMsgIdx = idx;
  const m = contacts[idx];
  const content = `
    <div style="padding:10px">
      <div style="margin-bottom:15px"><strong>From:</strong> ${m.name} (${m.email})</div>
      <div style="margin-bottom:15px"><strong>Phone:</strong> ${m.phone}</div>
      <div style="margin-bottom:15px"><strong>Interested In:</strong> ${m.interest}</div>
      <div style="margin-bottom:15px"><strong>Date:</strong> ${m.date}</div>
      <div style="border-top:1px solid var(--border);padding-top:15px">
        <strong>Message:</strong><br>
        <p style="margin-top:10px;line-height:1.6;color:var(--text)">${m.message || 'No message content'}</p>
      </div>
    </div>
  `;
  document.getElementById('viewMsgContent').innerHTML = content;
  openModal('viewMsg');
}

async function deleteMessage(idx) {
  if (!confirm('Are you sure you want to delete this message?')) return;
  const msg = contacts[idx];
  try {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', msg.id);
    formData.append('type', 'messages');
    const response = await fetch('backend.php', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    if (data.success) {
      showToast('Message deleted');
      fetchMessages();
    }
  } catch (error) {
    console.error(error);
  }
}

async function deleteApplication(idx) {
  if (!confirm('Are you sure you want to delete this application?')) return;
  const app = applications[idx];
  try {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', app.id);
    formData.append('type', 'admissions');
    const response = await fetch('backend.php', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    if (data.success) {
      showToast('Application deleted');
      fetchApplications();
    }
  } catch (error) {
    console.error(error);
  }
}

document.getElementById('galleryUploadForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  if (uploadQueue.length === 0) return;
  
  const batchSize = 10;
  const totalFiles = uploadQueue.length;
  let successCount = 0;
  
  try {
    showToast(`Uploading ${totalFiles} images in batches...`);
    const album = this.querySelector('[name="album"]').value;
    
    for (let i = 0; i < totalFiles; i += batchSize) {
      const batch = uploadQueue.slice(i, i + batchSize);
      const formData = new FormData();
      formData.append('album', album);
      
      batch.forEach(item => {
        formData.append('images[]', item.file);
      });
      
      const response = await fetch('backend.php', {
        method: 'POST',
        body: formData
      });
      const data = await response.json();
      
      if (data.success) {
        successCount += batch.length;
        showToast(`Uploaded ${Math.min(i + batchSize, totalFiles)} / ${totalFiles}...`);
      } else {
        showToast('Batch failed: ' + (data.message || 'Unknown error'));
      }
    }
    
    showToast('Upload complete!');
    closeModal('uploadImg');
    fetchGalleryImages();
    clearUploadQueue();
    
  } catch (error) {
    showToast('Upload failed');
    console.error(error);
  }
});

async function deleteGalleryImage(id) {
  if (!confirm('Are you sure you want to delete this image?')) return;
  try {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);
    const response = await fetch('backend.php', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    if (data.success) {
      showToast('Image deleted');
      fetchGalleryImages();
    } else {
      showToast('Error: ' + data.message);
    }
  } catch (error) {
    showToast('Delete failed');
  }
}


// ═══════════════════════════════════════════════════════
// ACTIONS
// ═══════════════════════════════════════════════════════
async function fetchDownloads() {
  try {
    const response = await fetch('backend.php?type=downloads&v=' + Date.now());
    const data = await response.json();
    if (data.success) {
      downloads = data.downloads || [];
      renderDownloads();
    }
  } catch (error) {
    console.error('Error fetching downloads:', error);
  }
}

async function addDownload(){
  const title=document.getElementById('dlTitle').value;
  if (!title) return showToast('Please enter a title');
  
  const editId = document.getElementById('dlEditId').value;
  const formData = new FormData();
  formData.append('action', editId ? 'update_download' : 'add_download');
  if (editId) formData.append('id', editId);
  
  formData.append('title', title);
  formData.append('label', document.getElementById('dlLabel').value);
  formData.append('category', document.getElementById('dlCat').value);
  formData.append('icon', document.getElementById('dlIcon').value);
  
  const fileInput = document.getElementById('dlFile');
  if (fileInput.files[0]) {
    formData.append('pdf_file', fileInput.files[0]);
  } else {
    formData.append('url', document.getElementById('dlUrl').value);
  }

  try {
    showToast(editId ? 'Updating download...' : 'Adding download...');
    const response = await fetch('backend.php', { method: 'POST', body: formData });
    const data = await response.json();
    if (data.success) {
      showToast(data.message);
      closeModal('addPDF');
      fetchDownloads();
      // Clear fields
      resetDlModal();
    }
  } catch (e) {
    showToast('Failed to save download');
  }
}

function openEditDownload(idx) {
  const d = downloads[idx];
  document.getElementById('dlModalTitle').textContent = 'Edit Download';
  document.getElementById('dlSubmitBtnText').textContent = 'Update Download';
  document.getElementById('dlEditId').value = d.id;
  document.getElementById('dlTitle').value = d.title;
  document.getElementById('dlLabel').value = d.label;
  document.getElementById('dlCat').value = d.category;
  document.getElementById('dlIcon').value = d.icon;
  
  if (d.url && d.url.startsWith('downloads/')) {
    document.getElementById('dlUrl').value = '';
    document.getElementById('dlCurrentFile').style.display = 'block';
    document.getElementById('dlCurrentFileLink').href = d.url;
    document.getElementById('dlCurrentFileLink').textContent = d.url.split('/').pop();
  } else {
    document.getElementById('dlUrl').value = d.url || '';
    document.getElementById('dlCurrentFile').style.display = 'none';
  }
  openModal('addPDF');
}

function resetDlModal() {
  document.getElementById('dlModalTitle').textContent = 'Add Download / PDF';
  document.getElementById('dlSubmitBtnText').textContent = 'Save Download';
  document.getElementById('dlEditId').value = '';
  ['dlTitle','dlLabel','dlUrl','dlIcon'].forEach(id => {
    const el = document.getElementById(id);
    if(el) el.value = '';
  });
  document.getElementById('dlIcon').value = '📄';
  document.getElementById('dlFile').value = '';
  document.getElementById('dlCurrentFile').style.display = 'none';
}

async function deleteDownload(idx) {
  if (!confirm('Are you sure you want to delete this download?')) return;
  const d = downloads[idx];
  try {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('type', 'downloads');
    formData.append('id', d.id);
    const response = await fetch('backend.php', { method: 'POST', body: formData });
    const data = await response.json();
    if (data.success) {
      showToast('Download deleted');
      fetchDownloads();
    }
  } catch (e) {
    showToast('Delete failed');
  }
}
function handleHeroUpload(input){
  const file=input.files[0]; if(!file) return;
  const url=URL.createObjectURL(file);
  const prev=document.getElementById('heroPreview');
  if(file.type.startsWith('video')){
    prev.innerHTML=`<video src="${url}" controls style="width:100%;border-radius:var(--radius-sm);max-height:200px;background:#000"></video>`;
  } else {
    prev.innerHTML=`<img src="${url}" style="width:100%;border-radius:var(--radius-sm);max-height:200px;object-fit:cover">`;
  }
  showToast('Media uploaded — save to apply');
}

// ═══════════════════════════════════════════════════════
// UTILS
// ════════════════════════════════════════────────────────
function openModal(id, preserveQueue = false){
  document.getElementById('modal-'+id).classList.add('open');
  if(id==='uploadImg' && !preserveQueue){ uploadQueue=[]; renderUploadPreview(); }
  if(id==='addPDF' && !document.getElementById('dlEditId').value) { resetDlModal(); }
}
function closeModal(id){ document.getElementById('modal-'+id).classList.remove('open'); }
function showToast(msg){
  const t=document.getElementById('toast');
  document.getElementById('toastMsg').textContent=msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer=setTimeout(()=>t.classList.remove('show'),3000);
}
function filterTable(input,tableId){
  const q=input.value.toLowerCase();
  document.querySelectorAll('#'+tableId+' tbody tr').forEach(tr=>{
    tr.style.display=tr.textContent.toLowerCase().includes(q)?'':'none';
  });
}
function filterByProgram(val){
  document.querySelectorAll('#appTable tbody tr').forEach(tr=>{
    tr.style.display=(!val||tr.textContent.includes(val))?'':'none';
  });
}
document.querySelectorAll('.modal-bg').forEach(bg=>{
  bg.addEventListener('click',e=>{ if(e.target===bg) bg.classList.remove('open'); });
});
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeLightboxGallery(); });

function renderRecentApps(){
  const tb=document.getElementById('recentApps'); 
  if(!tb) return;
  tb.innerHTML='';
  applications.slice(0,5).forEach((a)=>{
    const s=a.status==='Approved'?'active':a.status==='Pending'?'pending':'inactive';
    const tr=document.createElement('tr');
    tr.innerHTML=`<td style="color:var(--muted)">#${a.id}</td><td><strong style="color:var(--text)">${a.name}</strong></td><td><span class="tag new">${a.program}</span></td><td style="color:var(--muted)">${a.date}</td><td><span class="tag ${s}">${a.status}</span></td><td><button class="btn btn-outline btn-sm" onclick="viewApplication(${a.idx})">View</button></td>`;
    tb.appendChild(tr);
  });
}

function renderChart(){
  const bc=document.getElementById('barChart'); 
  if(!bc) return;
  bc.innerHTML='';
  const months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  
  // Analyze real data
  const currentYear = new Date().getFullYear();
  const monthlyCounts = new Array(12).fill(0);
  
  applications.forEach(app => {
    const d = app.rawDate;
    if (d && d.getFullYear() === currentYear) {
      monthlyCounts[d.getMonth()]++;
    }
  });

  const max = Math.max(...monthlyCounts, 10); // Minimum 10 for scale
  months.forEach((m,i)=>{
    const val = monthlyCounts[i];
    const h = Math.round((val/max)*100);
    bc.innerHTML += `<div class="bar" style="height:${h}%"><span class="bar-val">${val}</span><span class="bar-label">${m}</span></div>`;
  });
}

async function saveHeroSettings() {
  const data = {
    hero_badge: document.getElementById('heroBadge').value,
    hero_h1: document.getElementById('heroH1').value,
    hero_sub: document.getElementById('heroSub').value,
    hero_desc: document.getElementById('heroDesc').value
  };
  
  const formData = new FormData();
  formData.append('action', 'save_settings');
  for (let key in data) formData.append(key, data[key]);
  
  const fileInput = document.getElementById('heroFileInput');
  if (fileInput.files[0]) {
    formData.append('hero_media', fileInput.files[0]);
  }
  
  try {
    showToast('Saving hero content...');
    const response = await fetch('backend.php', { method: 'POST', body: formData });
    const res = await response.json();
    if (res.success) {
      showToast('Hero content saved successfully');
    }
  } catch (error) {
    showToast('Failed to save settings');
  }
}

async function saveSettings(settingsObj) {
  const formData = new FormData();
  formData.append('action', 'save_settings');
  for (let key in settingsObj) formData.append(key, settingsObj[key]);
  
  try {
    const response = await fetch('backend.php', { method: 'POST', body: formData });
    const res = await response.json();
    if (res.success) showToast('Settings updated');
  } catch (error) {
    showToast('Save failed');
  }
}

async function updateAdminProfile() {
  const user = document.getElementById('set-admin-user').value;
  const name = document.getElementById('set-admin-name').value;
  const curr = document.getElementById('set-curr-pass').value;
  const newP = document.getElementById('set-new-pass').value;
  const conf = document.getElementById('set-conf-pass').value;
  
  if (!curr) return showToast('Please enter your current password to authorize changes');
  if (newP && newP !== conf) return showToast('New passwords do not match');
  
  const formData = new FormData();
  formData.append('action', 'update_admin_profile');
  formData.append('current', curr);
  if (user) formData.append('username', user);
  if (name) formData.append('full_name', name);
  if (newP) formData.append('new_password', newP);
  
  try {
    const response = await fetch('backend.php', { method: 'POST', body: formData });
    const res = await response.json();
    showToast(res.message);
    if (res.success) {
      document.getElementById('set-curr-pass').value = '';
      document.getElementById('set-new-pass').value = '';
      document.getElementById('set-conf-pass').value = '';
      // Refresh admin info in UI
      fetchAdminInfo();
    }
  } catch (error) {
    showToast('Profile update failed');
  }
}

async function fetchAdminInfo() {
  try {
    const response = await fetch('backend.php?type=admin_info');
    const data = await response.json();
    if (data.success && data.admin) {
      const a = data.admin;
      document.getElementById('set-admin-user').value = a.username || '';
      document.getElementById('set-admin-name').value = a.full_name || '';
      // Update sidebar
      const nameEls = document.querySelectorAll('.sidebar-user-name');
      nameEls.forEach(el => el.textContent = a.full_name || a.username);
      const initialEls = document.querySelectorAll('.sidebar-user-initial');
      initialEls.forEach(el => el.textContent = (a.full_name || a.username).charAt(0).toUpperCase());
    }
  } catch (error) {
    console.error('Error fetching admin info:', error);
  }
}

async function fetchSettings() {
  fetchAdminInfo(); // Also fetch admin info
  try {
    const response = await fetch('backend.php?type=settings');
    const data = await response.json();
    if (data.success && data.settings) {
      const s = data.settings;
      if (s.hero_badge) document.getElementById('heroBadge').value = s.hero_badge;
      if (s.hero_h1) document.getElementById('heroH1').value = s.hero_h1;
      if (s.hero_sub) document.getElementById('heroSub').value = s.hero_sub;
      if (s.hero_desc) document.getElementById('heroDesc').value = s.hero_desc;
      if (s.notice_bar) document.getElementById('noticeTxt').value = s.notice_bar;
      
      // Site Info
      if (s.site_name) document.getElementById('set-site-name').value = s.site_name;
      if (s.tagline) document.getElementById('set-tagline').value = s.tagline;
      if (s.est_year) document.getElementById('set-est-year').value = s.est_year;
      if (s.meta_desc) document.getElementById('set-meta-desc').value = s.meta_desc;
      
      // Contact
      if (s.toll_free) document.getElementById('set-toll-free').value = s.toll_free;
      if (s.phone_1) document.getElementById('set-phone-1').value = s.phone_1;
      if (s.phone_2) document.getElementById('set-phone-2').value = s.phone_2;
      if (s.email) document.getElementById('set-email').value = s.email;
      if (s.address) document.getElementById('set-address').value = s.address;
      
      // Social
      if (s.social_fb) document.getElementById('set-fb').value = s.social_fb;
      if (s.social_ig) document.getElementById('set-ig').value = s.social_ig;
      if (s.social_yt) document.getElementById('set-yt').value = s.social_yt;
      if (s.social_li) document.getElementById('set-li').value = s.social_li;
      
      if (s.hero_media) {
        const prev = document.getElementById('heroPreview');
        if (s.hero_media.endsWith('.mp4')) {
          prev.innerHTML = `<video src="${s.hero_media}" controls style="width:100%;border-radius:var(--radius-sm);max-height:200px;background:#000"></video>`;
        } else {
          prev.innerHTML = `<img src="${s.hero_media}" style="width:100%;border-radius:var(--radius-sm);max-height:200px;object-fit:cover">`;
        }
      }
    }
  } catch (error) {
    console.error('Error fetching settings:', error);
  }
}

function toggleNotifs(e) {
  e.stopPropagation();
  const d = document.getElementById('notif-dropdown');
  d.classList.toggle('open');
}

function renderNotifications() {
  const list = document.getElementById('notif-list');
  if (!list) return;
  list.innerHTML = '';
  
  const pendingApps = applications.filter(a => a.status === 'Pending');
  const newMsgs = contacts.filter(c => c.status === 'New');
  
  const total = pendingApps.length + newMsgs.length;
  const dot = document.getElementById('topbar-notif-dot');
  const label = document.getElementById('notif-count-label');
  
  if (dot) dot.style.display = total > 0 ? 'block' : 'none';
  if (label) label.textContent = total;

  if (total === 0) {
    list.innerHTML = '<div class="notif-empty"><i class="fa fa-check-circle" style="font-size:24px;display:block;margin-bottom:8px;opacity:.3"></i>All caught up! No new notifications.</div>';
    return;
  }

  // Add Messages
  newMsgs.forEach(m => {
    const item = document.createElement('div');
    item.className = 'notif-item';
    item.onclick = () => { navigate('contacts'); };
    item.innerHTML = `
      <div class="notif-item-title">New Message from ${m.name}</div>
      <div class="notif-item-desc">${m.interest} inquiry received</div>
      <span class="notif-item-time">${m.date}</span>
    `;
    list.appendChild(item);
  });

  // Add Applications
  pendingApps.forEach(a => {
    const item = document.createElement('div');
    item.className = 'notif-item';
    item.onclick = () => { navigate('applications'); };
    item.innerHTML = `
      <div class="notif-item-title">New Admission Request</div>
      <div class="notif-item-desc">${a.name} applied for ${a.program}</div>
      <span class="notif-item-time">${a.date}</span>
    `;
    list.appendChild(item);
  });
}

document.addEventListener('click', () => {
  const d = document.getElementById('notif-dropdown');
  if (d) d.classList.remove('open');
});

function openGlobalSearch(e){ if(e) e.stopPropagation(); 
  document.getElementById('globalSearch').classList.add('open'); 
  document.getElementById('globalSearchInput').focus();
}
function closeGlobalSearch(){ document.getElementById('globalSearch').classList.remove('open'); }

function performGlobalSearch(q){
  q = q.toLowerCase().trim();
  const resWrap = document.getElementById('searchResults');
  if(!q) { resWrap.innerHTML = ''; return; }
  
  let html = '';
  
  // Search Institutions
  const insts = institutions.filter(i => i.name.toLowerCase().includes(q) || i.type.toLowerCase().includes(q));
  if(insts.length) {
    html += `<div><span class="search-cat-title">Institutions</span>`;
    insts.forEach(i => html += `<div class="search-item" onclick="closeGlobalSearch();navigate('institutions')"><div class="search-item-title">${i.name}</div><div class="search-item-desc">${i.type} • ${i.affil}</div></div>`);
    html += `</div>`;
  }
  
  // Search Applications
  const apps = applications.filter(a => a.name.toLowerCase().includes(q) || (a.program && a.program.toLowerCase().includes(q)) || (a.phone && a.phone.toLowerCase().includes(q)));
  if(apps.length) {
    html += `<div><span class="search-cat-title">Applications</span>`;
    apps.forEach(a => html += `<div class="search-item" onclick="closeGlobalSearch();navigate('applications')"><div class="search-item-title">${a.name}</div><div class="search-item-desc">${a.program} • ${a.phone}</div></div>`);
    html += `</div>`;
  }
  
  // Search Messages
  const msgs = contacts.filter(m => m.name.toLowerCase().includes(q) || (m.email && m.email.toLowerCase().includes(q)) || (m.interest && m.interest.toLowerCase().includes(q)));
  if(msgs.length) {
    html += `<div><span class="search-cat-title">Messages</span>`;
    msgs.forEach(m => html += `<div class="search-item" onclick="closeGlobalSearch();navigate('contacts')"><div class="search-item-title">${m.name}</div><div class="search-item-desc">${m.interest} inquiry</div></div>`);
    html += `</div>`;
  }


  resWrap.innerHTML = html || `<div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--muted)">No results found for "${q}"</div>`;
}

// ─── INIT ─────────────────────────────────────────────
function renderAll(){
  renderContacts(); renderDownloads(); renderRecentApps(); renderChart();
  fetchGalleryImages(); // Fetch images from database
  fetchApplications();  // Fetch applications from database
  fetchMessages();      // Fetch messages from database
  fetchDownloads();     // Fetch downloads from database
  fetchSettings();      // Fetch site settings (Hero, etc)
  renderNotifications();
}
async function logout() {
  if(!confirm('Are you sure you want to logout?')) return;
  const formData = new FormData();
  formData.append('action', 'logout');
  try {
    const res = await fetch('backend.php', { method: 'POST', body: formData });
    const data = await res.json();
    if(data.success) window.location.href = 'login.php';
  } catch(e) { console.error(e); }
}

renderAll();
</script>
  <!-- View Message Modal -->
  <div class="modal-bg" id="modal-viewMsg">
    <div class="modal" style="max-width:500px">
      <div class="modal-header">
        <div class="modal-title">Message Details</div>
        <div class="modal-close" onclick="closeModal('viewMsg')"><i class="fa fa-times"></i></div>
      </div>
      <div class="modal-body" id="viewMsgContent">
        <!-- Content injected via JS -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('viewMsg')">Close</button>
        <button class="btn btn-primary" onclick="closeModal('viewMsg'); markReplied(currentMsgIdx)">Mark as Replied</button>
      </div>
    </div>
  </div>

  <!-- View Application Modal -->
  <div class="modal-bg" id="modal-viewApp">
    <div class="modal" style="max-width:600px">
      <div class="modal-header">
        <div class="modal-title">Application Details</div>
        <div class="modal-close" onclick="closeModal('viewApp')"><i class="fa fa-times"></i></div>
      </div>
      <div class="modal-body" id="viewAppContent">
        <!-- Content injected via JS -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('viewApp')">Close</button>
        <button class="btn btn-primary" onclick="closeModal('viewApp'); updateAppStatus(currentAppIdx, 'Approved')">Approve Application</button>
      </div>
    </div>
  </div>


  <!-- Global Search Overlay -->
  <div class="search-overlay" id="globalSearch">
    <div class="search-close" onclick="closeGlobalSearch()"><i class="fa fa-times"></i></div>
    <div class="search-container">
      <div class="search-input-wrap">
        <i class="fa fa-search"></i>
        <input type="text" id="globalSearchInput" placeholder="Search anything... (e.g. B.Tech, student name, news)" oninput="performGlobalSearch(this.value)">
      </div>
      <div class="search-results-grid" id="searchResults">
        <!-- Results injected via JS -->
      </div>
    </div>
  </div>

</body>
</html>