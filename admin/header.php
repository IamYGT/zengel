<?php
ob_start();
session_start();
include("config.php");
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
// Check if the user is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
$q = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=?");
$q->execute([1]);
$res = $q->fetchAll();
foreach ($res as $row) {
	$active_editor = $row['active_editor'];
	$website_name = $row['website_name'];
}
// Current Page Access Level check for all pages
$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SEYHANWEB- Admin Panel</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css">
	<?php if($active_editor == 'Summernote'): ?>
	<link rel="stylesheet" href="css/summernote.css">
	<?php endif; ?>
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition fixed skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="index.php" class="logo">
				<span class="logo-lg">SEYHANWEB</span>
			</a>
			<nav class="navbar navbar-static-top">
				
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo 'Admin'; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Profili Düzenle</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Çıkış Yap</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
  		<aside class="main-sidebar">
    		<section class="sidebar">
      			<ul class="sidebar-menu">
			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
			            <i class="fa fa-home"></i> <span>Dashboard</span>
			          </a>
			        </li>
					<li class="treeview <?php if( ($cur_page == 'page-add.php')||($cur_page == 'page.php')||($cur_page == 'page-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-columns"></i>
							<span>Sayfa Yönetimi</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="page-add.php"><i class="fa fa-circle-o"></i> Yeni Sayfa Ekle</a></li>
							<li><a href="page.php"><i class="fa fa-circle-o"></i> Sayfaları Listele</a></li>
						</ul>
					</li>
					<li class="treeview <?php if( ($cur_page == 'category-add.php')||($cur_page == 'category.php')||($cur_page == 'category-edit.php') || ($cur_page == 'news-add.php')||($cur_page == 'news.php')||($cur_page == 'news-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-newspaper-o"></i>
							<span>Blog Yönetimi</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
						    <li><a href="news-add.php"><i class="fa fa-circle-o"></i> Yeni Blog Ekle</a></li>
						    <li><a href="news.php"><i class="fa fa-circle-o"></i> Blog Listele</a></li>
							<li><a href="category-add.php"><i class="fa fa-circle-o"></i> Yeni Kategori Ekle</a></li>
							<li><a href="category.php"><i class="fa fa-circle-o"></i> Kategori Listele</a></li>
						</ul>
					</li>
					<li class="treeview <?php if( ($cur_page == 'service-add.php')||($cur_page == 'service.php')||($cur_page == 'service-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-car"></i>
							<span>Hizmet Yönetimi</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="service-add.php"><i class="fa fa-circle-o"></i> Yeni Hizmet Ekle</a></li>
							<li><a href="service.php"><i class="fa fa-circle-o"></i> Hizmetleri Listele</a></li>
						</ul>
					</li>
					<li class="treeview <?php if( ($cur_page == 'designation-add.php')||($cur_page == 'designation.php')||($cur_page == 'designation-edit.php') || ($cur_page == 'team-member-add.php')||($cur_page == 'team-member.php')||($cur_page == 'team-member-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-group"></i>
							<span>Personel Yönetimi</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
						    <li><a href="team-member.php"><i class="fa fa-circle-o"></i> Personel Listele</a></li>
							<li><a href="designation.php"><i class="fa fa-circle-o"></i> Branş Listele</a></li>
						</ul>
					</li>							
					<li class="treeview <?php if( ($cur_page == 'slider-add.php')||($cur_page == 'slider.php')||($cur_page == 'slider-edit.php') ) {echo 'active';} ?>">
			          <a href="slider.php">
			            <i class="fa  fa-sliders"></i> <span>Slider Yönetimi</span>
			          </a>
			        </li>
			        <li class="treeview <?php if( ($cur_page == 'partner-add.php')||($cur_page == 'partner.php')||($cur_page == 'partner-edit.php') ) {echo 'active';} ?>">
			          <a href="partner.php">
			            <i class="fa fa-bookmark-o"></i> <span>Marka Yönetimi</span>
			          </a>
			        </li>								
			        <li class="treeview <?php if( ($cur_page == 'testimonial-add.php')||($cur_page == 'testimonial.php')||($cur_page == 'testimonial-edit.php') ) {echo 'active';} ?>">
			          <a href="testimonial.php">
			            <i class="fa fa-comments-o"></i> <span>M. Yorum Yönetimi</span>
			          </a>
			        </li>
			        <li class="treeview <?php if( ($cur_page == 'photo-category-add.php')||($cur_page == 'photo-category.php')||($cur_page == 'photo-category-edit.php') || ($cur_page == 'photo-add.php')||($cur_page == 'photo.php')||($cur_page == 'photo-edit.php') || ($cur_page == 'video-category-add.php')||($cur_page == 'video-category.php')||($cur_page == 'video-category-edit.php') || ($cur_page == 'video-add.php')||($cur_page == 'video.php')||($cur_page == 'video-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-camera"></i>
							<span>Foto & Video Galeri</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="photo-category.php"><i class="fa fa-circle-o"></i> Foto Kategori</a></li>
							<li><a href="photo.php"><i class="fa fa-circle-o"></i> Foto Galeri</a></li>
							<li><a href="video-category.php"><i class="fa fa-circle-o"></i> Video Kategori</a></li>
							<li><a href="video.php"><i class="fa fa-circle-o"></i> Video Galeri</a></li>
						</ul>
					</li>
			        <li class="treeview <?php if( ($cur_page == 'subscriber.php')||($cur_page == 'subscriber-email.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-paper-plane"></i>
							<span>E-Bülten</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="subscriber.php"><i class="fa fa-circle-o"></i> Aboneler</a></li>
							<li><a href="subscriber-email.php"><i class="fa fa-circle-o"></i> Abonelere Toplu Mail</a></li>
						</ul>
					</li>				
			        <li class="treeview <?php if( ($cur_page == 'menu-add.php')||($cur_page == 'menu.php')||($cur_page == 'menu-edit.php') ) {echo 'active';} ?>">
			          <a href="menu.php">
			            <i class="fa fa-hand-o-right"></i> <span>Menü Yönetimi</span>
			          </a>
			        </li>
					<li class="treeview <?php if( ($cur_page == 'file-add.php')||($cur_page == 'file.php')||($cur_page == 'file-edit.php') ) {echo 'active';} ?>">
			          <a href="file.php">
			            <i class="fa fa-file-archive-o"></i> <span>Dosya Yükle (Medya)</span>
			          </a>
			        </li>			        					
			        <li class="treeview <?php if( ($cur_page == 'social-media.php') ) {echo 'active';} ?>">
			          <a href="social-media.php">
			            <i class="fa fa-link"></i> <span>Sosyal Medya</span>
			          </a>
			        </li>					
			        <li class="treeview <?php if( ($cur_page == 'settings.php') ) {echo 'active';} ?>">
			          <a href="settings.php">
			            <i class="fa fa-gears"></i> <span>Genel Ayaralar</span>
			          </a>
			        </li>
      			</ul>
    		</section>
  		</aside>
  		<div class="content-wrapper">