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
	$statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
	$statement->execute(array($_REQUEST['slug']));
	$total = $statement->rowCount();
	if( $total == 0 )
	{
		header('location: '.BASE_URL);
		exit;
	}
}

// Getting the detailed data of a service from slug
$statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);				
foreach ($result as $row)
{
	$name              = $row['name'];
	$slug              = $row['slug'];
	$designation_id    = $row['designation_id'];
	$photo             = $row['photo'];
	$banner            = $row['banner'];
	$degree            = $row['degree'];
	$detail            = $row['detail'];
	$facebook          = $row['facebook'];
	$twitter           = $row['twitter'];
	$linkedin          = $row['linkedin'];
	$youtube           = $row['youtube'];
	$google_plus       = $row['google_plus'];
	$instagram         = $row['instagram'];
	$flickr            = $row['flickr'];
	$address           = $row['address'];
	$practice_location = $row['practice_location'];
	$phone             = $row['phone'];
	$email             = $row['email'];
	$website           = $row['website'];
	$status            = $row['status'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_designation WHERE designation_id=?");
$statement->execute(array($designation_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);				
foreach ($result as $row)
{
	$designation_name = $row['designation_name'];
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
		<!-- Start Product Details Area -->
        <section class="product-details-area ptb-100">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-4 col-md-12">
						<div class="product-details-image">
							<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
						</div>
					</div>

					<div class="col-lg-8 col-md-12">
						<div class="product-details-desc">
						    <h2><?php echo $name; ?></h2>
						    <h3><?php echo $designation_name; ?></h3>
						    <p>
							<?php echo $degree; ?>
						    </p>
							
							<div class="product-add-to-cart">
							
							<div class="who-we-are-content">
								<ul class="mb-0">
									<li>
										<i class='bx bx-phone-call bx-rotate-270'></i>
										<?php if($phone!=''): ?>
										<?php echo $phone; ?>
										<?php else: ?>
										N/A
										<?php endif; ?>
									</li>
									<li>
										<i class='bx bx-envelope'></i>
										<?php if($email!=''): ?>
										<?php echo $email; ?>
										<?php else: ?>
										N/A
										<?php endif; ?>
									</li>
									<li>
										<i class='bx bx-share-alt'></i>
										<?php if($website!=''): ?>
										<?php echo $website; ?>
										<?php else: ?>
										N/A
										<?php endif; ?>
									</li>
								</ul>								
							</div>							
							</div>

							<div class="custom-payment-options">
								<span>Beni Takip Et!:</span>
								<div class="payment-methods">
								    <?php if($facebook!=''): ?>
									- <a href="<?php echo $facebook; ?>" target="_blank">
										FACEBOOK
									</a> - 
									<?php endif; ?>
								    <?php if($twitter!=''): ?>
									<a href="<?php echo $twitter; ?>" target="_blank">
										TWITTER
									</a> - 
									<?php endif; ?> 
								    <?php if($linkedin!=''): ?>
									<a href="<?php echo $linkedin; ?>" target="_blank">
										LINKEDIN
									</a> - 
									<?php endif; ?> 
								    <?php if($instagram!=''): ?>
									<a href="<?php echo $instagram; ?>" target="_blank">
										INSTAGRAM
									</a> - 
									<?php endif; ?>
								    <?php if($youtube!=''): ?>
									<a href="<?php echo $youtube; ?>" target="_blank">
										YOUTUBE
									</a> - 
									<?php endif; ?>
								    <?php if($flickr!=''): ?>
									<a href="<?php echo $flickr; ?>" target="_blank">
										FLICKR
									</a> - 
									<?php endif; ?>									
								</div>
							</div>							
						</div>						
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="tab products-details-tab">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<ul class="tabs">
										<li>
											<a href="#">
											<div class="dot"></div> Hakkında
										</a>
									</li>
									</ul>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="tab_content">
										<div class="tabs_item">
											<div class="products-details-tab-content">
												<p><?php echo $detail; ?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Product Details Area -->
<?php require_once('footer.php'); ?>