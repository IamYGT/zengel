<?php
ob_start();
session_start();
include("admin/config.php");
include("admin/functions.php");
include("admin/inc/language_data.php");
							
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=?");
$statement->execute(array(1));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$mod_rewrite = $row['mod_rewrite'];
	$preloader = $row['preloader'];
	$color = $row['color'];
}
if($mod_rewrite == 'Off') {
	define("URL_CATEGORY", "category.php?slug=");
	define("URL_PAGE", "page.php?slug=");
	define("URL_NEWS", "news.php?slug=");
	define("URL_SERVICE", "service.php?slug=");
	define("URL_TEAM", "team-member.php?slug=");
	define("URL_SEARCH", "search.php");
} else {
	define("URL_CATEGORY", "kategori/");
	define("URL_PAGE", "sayfa/");
	define("URL_NEWS", "blog/");
	define("URL_SERVICE", "hizmet/");
	define("URL_TEAM", "personel/");
	define("URL_SEARCH", "ara");
}
?>
<?php
// Getting the basic data for the website from database
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$contact_address= $row['contact_address'];
}
?>
<!doctype html>
<html lang="tr">
<head>  
        <!-- Hakan Çelik Tarafından Kodlanmıştır Çoğaltılıp Satılamaz. Yazılım İçerisinde Lisans Takibi Yapılmaktadır. -->
        <!-- Required meta tags -->
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php
		// Getting the current page URL
		$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

		if($cur_page == 'news.php')
		{
			$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
			$statement->execute(array($_REQUEST['slug']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) 
			{
			    $og_photo = $row['photo'];
		 	   $og_title = $row['news_title'];
			    $og_slug = $row['news_slug'];
				$og_description = substr(strip_tags($row['news_content']),0,200).'...';
				echo '<meta name="description" content="'.$row['meta_description'].'">';
				echo '<title>'.$row['meta_title'].'</title>';
			}
		}

		if($cur_page == 'page.php')
		{
			$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=?");
			$statement->execute(array($_REQUEST['slug']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) 
			{
				echo '<meta name="description" content="'.$row['meta_description'].'">';
				echo '<title>'.$row['meta_title'].'</title>';
			}
		}

		if($cur_page == 'category.php')
		{
			$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=?");
			$statement->execute(array($_REQUEST['slug']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row)
			{
				echo '<meta name="description" content="'.$row['meta_description'].'">';
				echo '<title>'.$row['meta_title'].'</title>';
			}
		}

		if($cur_page == 'index.php')
		{
			$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) 
			{
				echo '<meta name="description" content="'.$row['meta_description_home'].'">';
				echo '<title>'.$row['meta_title_home'].'</title>';
			}
		}
	
		if($cur_page == 'team-member.php')
		{
			$statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
			$statement->execute(array($_REQUEST['slug']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) 
			{
				echo '<meta name="description" content="'.$row['meta_description'].'">';
				echo '<title>'.$row['meta_title'].'</title>';
			}
		}
	
		if($cur_page == 'service.php')
		{
			$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=?");
			$statement->execute(array($_REQUEST['slug']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) 
			{
				echo '<meta name="description" content="'.$row['meta_description'].'">';
				echo '<title>'.$row['meta_title'].'</title>';
			}
		}
		?>
	    <?php if($cur_page == 'news.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.URL_NEWS.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="<?php echo BASE_URL; ?>assets/uploads/<?php echo $og_photo; ?>">
	    <?php endif; ?>
		<!-- Revolution CSS -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/revolution/css/settings.css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/revolution/css/layers.css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/revolution/css/navigation.css">
		
        <!-- Bootstrap Min CSS --> 
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
        <!-- Owl Theme Default Min CSS --> 
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/owl.theme.default.min.css">
        <!-- Owl Carousel Min CSS --> 
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/owl.carousel.min.css">
        <!-- Owl Magnific Min CSS --> 
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/magnific-popup.min.css">
        <!-- Animate Min CSS --> 
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/animate.min.css">
        <!-- Boxicons Min CSS --> 
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/boxicons.min.css">
        <!-- Meanmenu Min CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/meanmenu.min.css">
        <!-- Nice Select Min CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/nice-select.min.css">
		<!-- Odometer Min CSS-->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/odometer.min.css">
		<!-- Date Picker Min CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/date-picker.min.css">
		<!-- Slick Min CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/slick.min.css">
        <!-- Style CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
        <!-- Responsive CSS -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/responsive.css">		
		<!-- Favicon -->
		
        <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $favicon; ?>">
        <!-- Title -->
    </head>
    <body>
	    <?php if($preloader == 'On'): ?>
		<!-- Start Preloader Area -->
		<div class="preloader">
			<div class="lds-ripple">
				<div></div>
				<div></div>
			</div>
		</div>
		<!-- End Preloader Area -->
		<?php endif; ?>
		<!-- Start Header Area -->
		<header class="header-area fixed-top">
			<!-- Start Top Header Area -->
			<div class="top-header">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-3">
							<div class="header-left-content">
								<a href="<?php echo BASE_URL; ?>">
									<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt="Logo">
								</a>
							</div>
						</div>
						<div class="col-lg-9">
							<div class="header-right-content">
								<ul>
									<li>
										<a href="tel:<?php echo $contact_phone; ?>">
											<i class='bx bxs-phone-call'></i>
											<span>İletişim numaramız</span>
											<?php echo $contact_phone; ?>
										</a>
									</li>
									<li>
										<i class='bx bx-mail-send'></i>
										<span>E-posta adresimiz</span>
										<?php echo $contact_email; ?>
									</li>
									<li>
										<i class='bx bxs-location-plus'></i>
										<span>Servis lokasyonumuz</span>
										<?php echo $contact_address; ?>
									</li>									
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Top Header Area -->

			<!-- Start Ridgi Navbar Area -->
			<div class="ridgi-nav-style">
				<div class="navbar-area">
					<!-- Menu For Mobile Device -->
					<div class="mobile-nav">
						<a href="<?php echo BASE_URL; ?>" class="logo">
							<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt="Logo">
						</a>
					</div>
					<!-- Menu For Desktop Device -->
					<div class="main-nav">
						<nav class="navbar navbar-expand-md navbar-light">
							<div class="container">
								<a class="navbar-brand" href="<?php echo BASE_URL; ?>">
									<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt="Logo">
								</a>
								<div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
									<ul class="navbar-nav">
								<?php
                                $q = $pdo->prepare("SELECT * FROM tbl_menu WHERE menu_parent=? ORDER BY menu_order ASC");
                                $q->execute(array(0));
                                $res = $q->fetchAll();
                                foreach ($res as $row) {
                                    
                                    $r = $pdo->prepare("SELECT * FROM tbl_menu WHERE menu_parent=?");
                                    $r->execute(array($row['menu_id']));
                                    $total = $r->rowCount();

                                    echo '<li class="nav-item">';
                                    
                                    if($row['page_id'] == 0) {
                                        
                                        if($row['menu_url'] == '') {
                                            $final_url = 'javascript:void(0);';
                                        } else {
                                            $final_url = $row['menu_url'];
                                        }                                       
                                        ?>
										<a href="<?php echo $final_url; ?>" class="nav-link dropdown-toggle"><?php echo $row['menu_name']; ?><?php if($total) {echo '<em></em>';}; ?>
										
										</a>
                                        <?php
                                    } else {
                                        $r = $pdo->prepare("SELECT * FROM tbl_page WHERE page_id=? ");
                                        $r->execute(array($row['page_id']));
                                        $res1 = $r->fetchAll();
                                        foreach ($res1 as $row1) {
                                            ?>											
										    <a href="<?php echo BASE_URL.URL_PAGE.$row1['page_slug']; ?>" class="nav-link dropdown-toggle"><?php echo $row1['page_name']; ?><?php if($total) {echo '<em></em>';}; ?>
										    </a>											
                                            <?php
                                        }
                                    }

                                    // Checking for sub-menu
                                    $r = $pdo->prepare("SELECT * FROM tbl_menu WHERE menu_parent=?");
                                    $r->execute(array($row['menu_id']));
                                    $total = $r->rowCount();
                                    if($total) {
                                        echo '<ul class="dropdown-menu dropdown-style">';

                                        $res1 = $r->fetchAll();
                                        foreach ($res1 as $row1) {
                                            //
                                            echo '<li class="nav-item">';
                                            if($row1['page_id'] == 0) {
                                                if($row1['menu_url'] == '') {
                                                    $final_url1 = 'javascript:void(0);';
                                                } else {
                                                    $final_url1 = $row1['menu_url'];
                                                }
                                                ?>
                                                <a href="<?php echo $final_url1; ?>" class="nav-link"><?php echo $row1['menu_name']; ?></a>
                                                <?php
                                            } else {
                                                $s = $pdo->prepare("SELECT * FROM tbl_page WHERE page_id=?");
                                                $s->execute(array($row1['page_id']));
                                                $res2 = $s->fetchAll();
                                                foreach ($res2 as $row2) {
                                                    ?>
                                                    <a href="<?php echo BASE_URL.URL_PAGE.$row2['page_slug']; ?>" class="nav-link"><?php echo $row2['page_name']; ?></a>
                                                    <?php
                                                }
                                            }
                                            echo '</li>';
                                            //
                                        }

                                        echo '</ul>';
                                    }


                                    echo '</li>';

                                }
                                ?>									
									</ul>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
			<!-- End Ridgi Navbar Area -->
		</header>
		<!-- End Header Area -->