	<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$footer_about                = $row['footer_about'];
		$footer_copyright            = $row['footer_copyright'];
		$contact_address             = $row['contact_address'];
		$contact_email               = $row['contact_email'];
		$contact_phone               = $row['contact_phone'];
		$contact_fax                 = $row['contact_fax'];		
		$logo                        = $row['logo'];
		$total_recent_news_footer    = $row['total_recent_news_footer'];
		$total_popular_news_footer   = $row['total_popular_news_footer'];
		$total_recent_news_sidebar   = $row['total_recent_news_sidebar'];
		$total_popular_news_sidebar  = $row['total_popular_news_sidebar'];
		$total_recent_news_home_page = $row['total_recent_news_home_page'];
	}
	?>
		<!-- Start Top Footer Area -->
		<footer class="top-footer-area footer-bg pt-100">
			<div class="container">
				<div class="row align-items-center border-bottom pb-70">
					<div class="col-lg-3 col-sm-6">
						<div class="footer-adders">
							<a href="<?php echo BASE_URL; ?>">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt="Logo">
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="footer-adders">
							<div class="call-wrap">
								<i class='bx bxs-phone-call'></i>
								<span>İletişim numaramız</span>
								<a href="tel:<?php echo $contact_phone; ?>">	<?php echo $contact_phone; ?></a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="footer-adders">
							<div class="time-wrap">
								<i class='bx bxs-location-plus'></i>
								<span>Servis lokasyonu</span>
								<p>	<?php echo $contact_address; ?>	</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="footer-adders">
							<a href="https://wa.me/<?php echo $contact_fax; ?>" class="default-btn" data-toggle="modal" data-target="#exampleModal">
								Whatsapp Randevu
								<i class='bx bxl-whatsapp'></i>
							</a>
						</div>
					</div>
				</div>
				<div class="row footer-link-wrap pt-70 pb-70">
					<div class="col-lg-6 col-md-6">
						<div class="single-widget">
							<h3>ZENGEL OTOMOTİV</h3>
							<span color="white"><?php echo nl2br($footer_about); ?></span>	
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="single-widget">
							<h3>Son Gönderiler</h3>
							<ul>
							<?php
							    $i=0;
							    $statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
							    $statement->execute();
							    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
							    foreach ($result as $row) {
								    $i++;
								    if($i>$total_recent_news_footer) {break;}
							    ?>							
								<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
						    <?php
						    }
						    ?>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="single-widget">
							<h3>Popüler Gönderiler</h3>
							<ul>
						    <?php
						    $i=0;
						    $statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY total_view DESC");
						    $statement->execute();
						    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
						    foreach ($result as $row) {
							    $i++;
							    if($i>$total_popular_news_footer) {break;}
							    ?>						
								<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
						    <?php
						    }
						    ?>
							</ul>
						</div>
					</div>					
				</div>
			</div>
		</footer>
		<!-- End Top Footer Area -->
		<!-- Start Bottom Footer Area -->
		<footer class="bottom-footer-area footer-bg">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="copy-right">
							<p>
								<?php echo $footer_copyright; ?>
							</p>
						</div>
					</div>
					<div class="col-lg-6">
					
						<div class="designed">
							<p>Designed By <i class='bx bx-heart'></i> SEYHANWEB</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- End Bottom Footer Area -->


		<!-- Start Go Top Area -->
		<div class="go-top">
			<i class='bx bx-chevrons-up bx-fade-up'></i>
			<i class='bx bx-chevrons-up bx-fade-up'></i>
		</div>
		<!-- End Go Top Area --> 

        
        <!-- Jquery MIn JS -->
        <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script>
        <!-- Bootstrap Bundle Min JS -->
        <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
        <!-- Meanmenu Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/meanmenu.min.js"></script>
        <!-- Wow Min JS -->
        <script src="<?php echo BASE_URL; ?>assets/js/wow.min.js"></script>
        <!-- Owl Carousel Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/owl.carousel.min.js"></script>
        <!-- Owl Magnific Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/magnific-popup.min.js"></script>
        <!-- Mixitup Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/mixitup.min.js"></script>
        <!-- Nice Select Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/nice-select.min.js"></script>
		<!-- Appear Min JS --> 
        <script src="<?php echo BASE_URL; ?>assets/js/appear.min.js"></script>
		<!-- Odometer JS --> 
		<script src="<?php echo BASE_URL; ?>assets/js/odometer.min.js"></script>
		<!-- Bootstrap Datepicker Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/bootstrap-datepicker.min.js"></script>
		<!-- Jarallax Min JS --> 
        <script src="<?php echo BASE_URL; ?>assets/js/jarallax.min.js"></script>
		<!-- Slick Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/slick.min.js"></script>
		<!-- Form Ajaxchimp Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/ajaxchimp.min.js"></script>
		<!-- Form Validator Min JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/form-validator.min.js"></script>
		<!-- Contact JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/contact-form-script.js"></script>
        <!-- Custom JS -->
		<script src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>

		<!-- Revolution JS -->
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/jquery.themepunch.tools.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/jquery.themepunch.revolution.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.actions.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.migration.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/extensions/revolution.extension.video.min.js"></script>
		<script src="<?php echo BASE_URL; ?>assets/revolution/js/rev-slider-custom.js"></script>
    </body>
</html>