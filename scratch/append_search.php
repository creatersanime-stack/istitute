<?php
$file = 'admin.php';
$content = file_get_contents($file);
$overlay = '
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
';

if (strpos($content, 'id="globalSearch"') === false) {
    $newContent = str_replace('</body>', $overlay . "\n</body>", $content);
    file_put_contents($file, $newContent);
    echo "Global Search Overlay successfully appended.";
} else {
    echo "Global Search Overlay already exists.";
}
?>
