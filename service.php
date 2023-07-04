<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
	header('location: '.BASE_URL);
	exit;
}
else
{
	// Check the page slug is valid or not.
	$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=?");
	$statement->execute(array($_REQUEST['slug']));
	$total = $statement->rowCount();
	if( $total == 0 )
	{
		header('location: '.BASE_URL);
		exit;
	}
}

// Getting the detailed data of a service from slug
$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);				
foreach ($result as $row)
{
	$name              = $row['name'];
	$slug              = $row['slug'];
	$short_description = $row['short_description'];
	$description       = $row['description'];
	$photo             = $row['photo'];
	$banner            = $row['banner'];
}
?>
<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$contact_address             = $row['contact_address'];
		$contact_email               = $row['contact_email'];
		$contact_phone               = $row['contact_phone'];
	}
?>
		<!-- Start Page Title Area -->
		<div class="page-title-area item-bg-1" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $banner; ?>)">
			<div class="container">
				<div class="page-title-content">
					<h2><?php echo $name; ?></h2>
					<ul>
						<li>
							<a href="<?php echo BASE_URL; ?>">
								Ana Sayfa 
							</a>
						</li>
						<li><?php echo $name; ?></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Page Title Area -->		
		<!-- End Service Details Area -->
		<section class="service-details-area ptb-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<div class="service-sidebar-area">
							<div class="service-list service-card">
								<h3 class="service-details-title">Hizmetler</h3>
								<ul>
							    <?php
							        $statement = $pdo->prepare("SELECT * FROM tbl_service ORDER BY name ASC");
							        $statement->execute();
							        $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
							        foreach ($result as $row) {
								    ?>								
									<li>
										<a href="<?php echo BASE_URL.URL_SERVICE.$row['slug']; ?>"><?php echo $row['name']; ?> 
										<i class='bx bx-check'></i></a>
									</li>
								<?php
							    }
							    ?>
								</ul>
							</div>
							<div class="service-list service-card">
								<h3 class="service-details-title">İletişim Bilgileri</h3>
								<ul>
									<li>
										<a href="tel:<?php echo $contact_phone; ?>">
											<?php echo $contact_phone; ?>
											<i class='bx bx-phone-call bx-rotate-270'></i>
										</a>
									</li>
									<li>
										<a href="mailto:<?php echo $contact_email; ?>">
											<?php echo $contact_email; ?>
											<i class='bx bx-envelope'></i>
										</a>
									</li>
									<li>
										<?php echo $contact_address; ?>
										<i class='bx bx-location-plus'></i>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="service-details-wrap">
							<div class="service-img">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
							</div>
							<h3><?php echo $name; ?></h3>
							<p><?php echo $description; ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Service Details Area -->
<?php require_once('footer.php'); ?>