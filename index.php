<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$total_recent_news_home_page = $row['total_recent_news_home_page'];
	$home_title_service          = $row['home_title_service'];
	$home_subtitle_service       = $row['home_subtitle_service'];
	$home_status_service         = $row['home_status_service'];
	$home_title_team_member      = $row['home_title_team_member'];
	$home_subtitle_team_member   = $row['home_subtitle_team_member'];
	$home_status_team_member     = $row['home_status_team_member'];
	$home_title_testimonial      = $row['home_title_testimonial'];
	$home_subtitle_testimonial   = $row['home_subtitle_testimonial'];
	$home_photo_testimonial      = $row['home_photo_testimonial'];
	$home_status_testimonial     = $row['home_status_testimonial'];	
	$heading_home                = $row['heading_home'];
	$text_home                   = $row['text_home'];
	$about_photo                 = $row['about_photo'];
	$video_home                  = $row['video_home'];
	$url_home                    = $row['url_home'];
	$home_title_news             = $row['home_title_news'];
	$home_subtitle_news          = $row['home_subtitle_news'];
	$home_status_news            = $row['home_status_news'];
	$home_title_partner          = $row['home_title_partner'];
	$home_subtitle_partner       = $row['home_subtitle_partner'];
	$home_status_partner         = $row['home_status_partner'];
	$counter_1_title             = $row['counter_1_title'];
    $counter_1_value             = $row['counter_1_value'];
    $counter_2_title             = $row['counter_2_title'];
    $counter_2_value             = $row['counter_2_value'];
    $counter_3_title             = $row['counter_3_title'];
    $counter_3_value             = $row['counter_3_value'];
    $counter_4_title             = $row['counter_4_title'];
    $counter_4_value             = $row['counter_4_value'];
    $counter_photo               = $row['counter_photo'];
    $counter_status              = $row['counter_status'];
	$newsletter_title            = $row['newsletter_title'];
	$newsletter_text             = $row['newsletter_text'];
	$newsletter_photo            = $row['newsletter_photo'];
	$newsletter_status           = $row['newsletter_status'];	
}
?>
		<!-- Start Ridgi Slider Area -->
		<section class="ridgi-slider-area">
			<div class="ridgi-slider owl-carousel owl-theme">
			<?php
			$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE status=? ORDER BY id DESC");
			$statement->execute(array('Aktif'));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) 
			{
				if($row['position']=='Left') {$align='left';}
				if($row['position']=='Center') {$align='center';}
				if($row['position']=='Right') {$align='right';}
				?>			
				<div class="ridgi-slider-item jarallax" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>);" data-jarallax='{"speed": 0.3}'>
					<div class="d-table">
						<div class="d-table-cell">
							<div class="container">
								<div class="ridgi-slider-text slider-text-<?php echo $align; ?>">
								    <?php if($row['heading']!=''): ?>
									<span class="center-span"><?php echo $row['heading']; ?></span>
									<?php endif; ?>
									<?php if($row['content']!=''): ?>
									<h1 class="center-h1"><?php echo nl2br($row['content']); ?></h1>
									<?php endif; ?>									
									<div class="slider-btn center-btn">
									    <?php if($row['button_text']!=''): ?>
										<a class="default-btn btn-two" href="<?php echo $row['button_url']; ?>">
											<?php echo $row['button_text']; ?>
											<i class='bx bx-plus'></i>
										</a>
									    <?php endif; ?>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>					
			</div>
		</section>
		<!-- End Ridig Slider Area -->
		<!-- Start Why Choose Us Area -->
		<section class="why-choose-us-area ptb-50">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-5">
						<div class="choose-img">
							<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $about_photo; ?>" alt="<?php echo $heading_home; ?>">
							<div class="video-wrap">
								<div class="video-btn-wrap">
									<a href="<?php echo $video_home; ?>" class="video-btn popup-youtube">
										<i class='bx bx-play bx-burst'></i>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="why-choose-wrap">
							<div class="why-choose-title">
								<h2><?php echo $heading_home; ?></h2>
								<p><?php echo nl2br($text_home); ?></p>
							</div>
							<div class="row">
								<div class="col-12">
									<a class="read-more" href="<?php echo $url_home; ?>">
										Daha Fazlası
										<i class='bx bx-right-arrow-alt bx-fade-right'></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Why Choose Us Area -->
        <?php if($home_status_service == 'Show'): ?>
		<!-- Start Our Vehicles Area -->
		<section class="our-vehicles-area ptb-50">
			<div class="container-fluid p-0">
				<div class="section-title">
					<h2><?php echo $home_title_service; ?></h2>
					<p><?php echo $home_subtitle_service; ?></p>
				</div>
				<div class="vehicles-wrap owl-carousel owl-theme">
			    <?php
			        $statement = $pdo->prepare("SELECT * FROM tbl_service ORDER BY id ASC");
			        $statement->execute();
			        $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			        foreach ($result as $row) {
				    ?>						
					<div class="single-vehicles">
						<div class="vehicles-img">
							<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
							<div class="vehicles-content">
								<h3><?php echo $row['name']; ?></h3>
								<a class="read-more" href="<?php echo BASE_URL.URL_SERVICE.$row['slug']; ?>">
									Hizmet Detayları
									<i class='bx bx-right-arrow-alt bx-fade-right'></i>
								</a>
							</div>
						</div>
					</div>
				    <?php
			        }
			    ?>
				</div>
			</div>
		</section>
		<!-- End Our Vehicles Area -->
        <?php endif; ?>
        <?php if($home_status_team_member == 'Show'): ?>
		<!-- Start Team Area -->
		<section class="team-area pt-100 pb-70 jarallax"  data-jarallax='{"speed": 0.3}'>
			<div class="container">
				<div class="section-title">
					<h2><?php echo $home_title_team_member; ?></h2>
					<p><?php echo $home_subtitle_team_member; ?></p>
				</div>
				<div class="row">
				<?php
					$statement = $pdo->prepare("SELECT 
												
												t1.id,
												t1.name,
												t1.slug,
												t1.designation_id,
												t1.photo,
												t1.facebook,
												t1.twitter,
												t1.linkedin,
												t1.youtube,
												t1.instagram,
												t1.flickr,

												t2.designation_id,
												t2.designation_name

					                           FROM tbl_team_member t1
					                           JOIN tbl_designation t2
					                           ON t1.designation_id = t2.designation_id
					                           WHERE t1.status = ?
											   LIMIT 3
					                           ");
					$statement->execute(array('Aktif'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
					?>								
					<div class="col-lg-4 col-md-6">
						<div class="single-team">
							<div class="team-img">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="Image">
							</div>
							<div class="team-content">
								<a href="<?php echo BASE_URL.URL_TEAM.$row['slug']; ?>"><span><?php echo $row['name']; ?></span></a>
								<h3><?php echo $row['designation_name']; ?></h3>
								<ul>
								    <?php if($row['facebook']!=''): ?>
									<li>
										<a href="<?php echo $row['facebook']; ?>"><i class='bx bxl-facebook'></i></a>
									</li>
									<?php endif; ?>
									<?php if($row['twitter']!=''): ?>
									<li>
										<a href="<?php echo $row['twitter']; ?>"><i class='bx bxl-twitter'></i></a>
									</li>
									<?php endif; ?>
									<?php if($row['linkedin']!=''): ?>
									<li>
										<a href="<?php echo $row['linkedin']; ?>"><i class='bx bxl-linkedin'></i></a>
									</li>
									<?php endif; ?>
									<?php if($row['instagram']!=''): ?>
									<li>
										<a href="<?php echo $row['instagram']; ?>"><i class='bx bxl-instagram'></i></a>
									</li>
									<?php endif; ?>
									<?php if($row['youtube']!=''): ?>
									<li>
										<a href="<?php echo $row['youtube']; ?>"><i class='bx bxl-youtube'></i></a>
									</li>
									<?php endif; ?>									
									<?php if($row['flickr']!=''): ?>
									<li>
										<a href="<?php echo $row['flickr']; ?>"><i class='bx bxl-flickr'></i></a>
									</li>
									<?php endif; ?>																		
								</ul>
							</div>
						</div>
					</div>
					<?php
					}
				?>	
				</div>
			</div>
		</section>
		<!-- End Team  Area -->		
        <?php endif; ?>
        <?php if($home_status_testimonial == 'Show'): ?>
		<!-- Start Customer Area -->
		<section class="customer-area-two ptb-50">
			<div class="container-fluid p-0">
				<div class="section-title">
					<h2><?php echo $home_title_testimonial; ?></h2>
					<p><?php echo $home_subtitle_testimonial; ?></p>
				</div>
				<div class="customer-wrap owl-carousel owl-theme">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_testimonial ORDER BY id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
					?>								
					<div class="single-customer">
						<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
						<h3><?php echo $row['name']; ?></h3>
						<p><?php echo nl2br($row['comment']); ?></p>
						<span><?php echo $row['name']; ?></span>
						<span class="colors"><?php echo $row['designation']; ?></span>
					</div>
					<?php
					}
				    ?>						
				</div>
			</div>
		</section>
		<!-- End Customer Area -->
        <?php endif; ?>
        <?php if($counter_status == 'Show'): ?>
		<!-- Start Counter Area -->
		<section class="counter-area mtb ptb-100 jarallax" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $counter_photo; ?>);" data-jarallax='{"speed": 0.3}'>
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-counter">
							<i class='bx bx-wallet-alt'></i>
							<h2>
								<span class="odometer" data-count="<?php echo $counter_1_value; ?>">00</span> <sup>+</sup>
							</h2>
							<p><?php echo $counter_1_title; ?></p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-counter">
							<i class='bx bx-group'></i>
							<h2>
								<span class="odometer" data-count="<?php echo $counter_2_value; ?>">00</span> <sup>+</sup>
							</h2>
							<p><?php echo $counter_2_title; ?></p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-counter">
							<i class='bx bx-shield-alt-2'></i>
							<h2>
								<span class="odometer" data-count="<?php echo $counter_3_value; ?>">00</span> <sup>+</sup>
							</h2>
							<p><?php echo $counter_3_title; ?></p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="single-counter">
							<i class='bx bx-support'></i>
							<h2>
								<span class="odometer" data-count="<?php echo $counter_4_value; ?>">00</span> <sup>+</sup>
							</h2>
							<p><?php echo $counter_4_title; ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Counter Area -->
        <?php endif; ?>
		<?php if($home_status_news == 'Show'): ?>
		<!-- Start Our Blog Area -->
		<section class="our-blog-area ptb pb-70 pt-70">
			<div class="container">
				<div class="section-title mtb">
					<h2><?php echo $home_title_news; ?></h2>
					<p><?php echo $home_subtitle_news; ?></p>
				</div>
				<div class="row">
					<?php
					$i=0;
					$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC LIMIT 3");
					$statement->execute();
					$result = $statement->fetchAll();							
					foreach ($result as $row) {
						$i++;
						if($i>$total_recent_news_home_page) {break;}
						?>							
					<div class="col-lg-4 col-md-6">
						<div class="single-blog">
							<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['news_title']; ?>">
							</a>
							<div class="blog-content">
								<h3>
									<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a>
								</h3>
								<ul>
									<li>
										<?php echo $row['news_date']; ?>
										<i class='bx bx-calendar'></i>
									</li>
									<li class="date">
										<a class="read-more" href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>">
											Bloğu Oku
											<i class="bx bx-right-arrow-alt bx-fade-right"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
					}
				?>					
				</div>
			</div>
		</section>
		<!-- End Our Blog Area -->
        <?php endif; ?>
		<?php if($newsletter_status=='Show'): ?>
		<!-- Start Find A Car Area -->
		<section class="find-car-area find-car-area-two find-car-area-three jarallax" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $newsletter_photo; ?>);" data-jarallax='{"speed": 0.3}'>
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="car-book-from">
							<h3>
								<?php echo $newsletter_title; ?>
							</h3>
						<?php
			if(isset($_POST['form_subscribe']))
			{

				$statement = $pdo->prepare("SELECT * FROM tbl_setting_email WHERE id=1");
				$statement->execute();
				$result = $statement->fetchAll();                           
				foreach ($result as $row) {
				    $send_email_from  = $row['send_email_from'];
				    $receive_email_to = $row['receive_email_to'];
				    $smtp_active      = $row['smtp_active'];
				    $smtp_ssl         = $row['smtp_ssl'];
				    $smtp_host        = $row['smtp_host'];
				    $smtp_port        = $row['smtp_port'];
				    $smtp_username    = $row['smtp_username'];
				    $smtp_password    = $row['smtp_password'];
				}

				if(empty($_POST['email_subscribe'])) 
			    {
			        $valid = 0;
			        $error_message1 .= EMAIL_EMPTY_CHECK;
			    }
			    else
			    {
			    	if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
				    {
				        $valid = 0;
				        $error_message1 .= EMAIL_VALID_CHECK;
				    }
				    else
				    {
				    	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
				    	$statement->execute(array($_POST['email_subscribe']));
				    	$total = $statement->rowCount();							
				    	if($total)
				    	{
				    		$valid = 0;
				        	$error_message1 .= EMAIL_EXIST_CHECK;
				    	}
				    	else
				    	{
				    		// Sending email to the requested subscriber for email confirmation
				    		// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
				    		$key = md5(uniqid(rand(), true));

				    		// Getting current date
				    		$current_date = date('Y-m-d');

				    		// Getting current date and time
				    		$current_date_time = date('Y-m-d H:i:s');

				    		// Inserting data into the database
				    		$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
				    		$statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

				    		// Sending Confirmation Email
							$subject = '';
							
							// Getting the url of the verification link
							$verification_url = BASE_URL.'verify.php?email='.$_POST['email_subscribe'].'&key='.$key;

							$message = '
                            Bültenimize abone olmak için gösterdiğiniz ilgi için teşekkür ederiz!<br><br>
                            Aboneliğinizi onaylamak için lütfen bu bağlantıyı tıklayın:
				         	<a href="'.$verification_url.'">'.$verification_url.'</a><br><br>
                            Bu bağlantı sadece 24 saat aktif olacaktır.
					        ';

							require_once('assets/mail/class.phpmailer.php');
					        $mail = new PHPMailer();
					        $mail->CharSet = 'UTF-8';

					        // sending email
							if($smtp_active == 'Yes')
					        {
					            if($smtp_ssl == 'Yes')
					            {
					                $mail->SMTPSecure = "ssl";
					            }
					            else
					            {
					                $mail->SMTPSecure = "tls";
					            }
					            $mail->IsSMTP();
					            $mail->SMTPAuth   = true;
					            $mail->Host       = $smtp_host;
					            $mail->Port       = $smtp_port;
					            $mail->Username   = $smtp_username;
					            $mail->Password   = $smtp_password;
					        }

					        $mail->addReplyTo($receive_email_to);
					        $mail->setFrom($send_email_from);
					        $mail->addAddress($_POST['email_subscribe']);

					        $mail->isHTML(true);
					        $mail->Subject = SUBSCRIPTION_SUBJECT;

							$mail->Body = $message;
					        $mail->send();

					        $success_message1 = SUBSCRIPTION_SUCCESS_MESSAGE;					
				    	}
				    }
			    }
			}
			if($error_message1 != '') {
				echo "<script>alert('".$error_message1."')</script>";
			}
			if($success_message1 != '') {
				echo "<script>alert('".$success_message1."')</script>";
			}
			?>				<form action="" method="post" class="book-wrap">			
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<input type="text" name="email_subscribe" class="form-control" required placeholder="E-Posta Adresiniz...">
										</div>
									</div>
								</div>
								<button type="submit" value="<?php echo SUBMIT; ?>" name="form_subscribe" class="default-btn btn-two">
									ABONE OL!
								</button>								
							</form>							
						</div>
					</div>
					<div class="col-lg-6">
						<div class="find-car-title">
							<h2><?php echo $newsletter_title; ?></h2>
							<?php if($newsletter_text!=''): ?>
							<p><?php echo nl2br($newsletter_text); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Find A Car Area -->		
		<?php endif; ?>		
        <?php if($home_status_partner == 'Show'): ?>
		<!-- Start Brand Area -->
		<section class="brand-area brand-area-two ptb-100">
			<div class="container">
					<div class="section-title mtb">
						<h2><?php echo $home_title_partner; ?></h2>
						<p><?php echo $home_subtitle_partner; ?></p>
					</div>
				<div class="row">
					<div class="brand-wrap owl-carousel owl-theme">
					<?php
					    $statement = $pdo->prepare("SELECT * FROM tbl_partner ORDER BY id ASC");
					    $statement->execute();
					    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					    foreach ($result as $row) {
						?>					
						<div class="brand-item">
						    <?php if($row['url']==''): ?>
							<a href="<?php echo $row['url']; ?>" target="_blank">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
							</a>
							<?php endif; ?>
						</div>
						<?php
					}
					?>						
					</div>
				</div>
			</div>
		</section>
		<!-- End Brand Area -->		
        <?php endif; ?>
<?php require_once('footer.php'); ?>