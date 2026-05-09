<?php
$file = 'admin.php';
$content = file_get_contents($file);

// Fix Search Function
$content = str_replace('function openGlobalSearch(){', 'function openGlobalSearch(e){ if(e) e.stopPropagation();', $content);

// Fix renderAll to include missing fetches
$oldRender = 'function renderAll(){
  renderContacts(); renderDownloads(); renderRecentApps(); renderChart();
  fetchGalleryImages(); // Fetch images from database
  fetchApplications();  // Fetch applications from database
  fetchMessages();      // Fetch messages from database
  fetchSettings();      // Fetch site settings (Hero, etc)
  renderNotifications();
}';

$newRender = 'function renderAll(){
  renderContacts(); renderDownloads(); renderRecentApps(); renderChart();
  fetchGalleryImages(); 
  fetchApplications();  
  fetchMessages();      
  fetchInstitutions();  
  fetchNews();          
  fetchSettings();      
  renderNotifications();
}';

$content = str_replace($oldRender, $newRender, $content);

file_put_contents($file, $content);
echo "Search system and renderAll synchronized.";
?>
