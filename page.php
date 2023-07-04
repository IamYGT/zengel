<?php
require_once('header.php');

// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
	header('location: index.php');
	exit;
}
else
{
	// Check the page slug is valid or not.
	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=? AND status=?");
	$statement->execute(array($_REQUEST['slug'],'Aktif'));
	$total = $statement->rowCount();
	if( $total == 0 )
	{
		header('location: index.php');
		exit;
	}
}

// Getting the detailed data of a page from page slug
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	$page_name    = $row['page_name'];
	$page_slug    = $row['page_slug'];
	$page_content = $row['page_content'];
	$page_layout  = $row['page_layout'];
	$banner       = $row['banner'];
	$status       = $row['status'];
}

// If a page is not active, redirect the user while direct URL press
if($status == 'Pasif')
{
	header('location: index.php');
	exit;
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
					<h2><?php echo $page_name; ?></h2>
					<ul>
						<li>
							<a href="<?php echo BASE_URL; ?>">
								Ana Sayfa 
							</a>
						</li>
						<li><?php echo $page_name; ?></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Page Title Area -->
        <?php if($page_layout == 'Tam Genişlik Sayfa Düzeni'): ?>		
		<!-- Start Why Choose Us Area -->
		<section class="why-choose-us-area why-choose-us-area-two why-choose-us-area-three ptb-100">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-12">
						<div class="why-choose-wrap">
							<div class="why-choose-title">
								<h2><?php echo $page_name; ?></h2>
								<p><?php echo $page_content; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Why Choose Us Area -->
        <?php endif; ?>
        <?php if($page_layout == 'İletişim Sayfa Düzeni'): ?>
        <?php
        	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        	$statement->execute();
        	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
        	foreach ($result as $row) 
        	{
        		$contact_map_iframe = $row['contact_map_iframe'];
        	}
        ?>
		<!-- Start Address Area -->
		<section class="address-area pt-100 pb-70">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="single-address">
							<i class='bx bx-phone-call'></i>
							<h3>Telefon</h3>
							<a href="tel:<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="single-address">
							<i class='bx bx-location-plus'></i>
							<h3>Adres</h3>
							<p><?php echo $contact_address; ?></p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
						<div class="single-address">
							<i class='bx bx-mail-send'></i>
							<h3>E-Posta</h3>
							<p><?php echo $contact_email; ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Address Area -->		
		<!-- Start Contact Area -->
		<section class="contact-area pb-100">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="contact-wrap contact-pages mb-0">
							<div class="contact-form">
								<div class="section-title">
									<span class="pumpkin-color">Bizimle İletişime Geçin!</span>
									<h2>İletişim Formu</h2>
								</div>
<?php
// After form submit checking everything for email sending
if(isset($_POST['form_contact']))
{
	$error_message = '';
	$success_message = '';

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

    $valid = 1;

    if(empty($_POST['visitor_name']))
    {
        $valid = 0;
        $error_message .= FULL_NAME_EMPTY_CHECK.'\n';
    }

    if(empty($_POST['visitor_phone']))
    {
        $valid = 0;
        $error_message .= PHONE_EMPTY_CHECK.'\n';
    }


    if(empty($_POST['visitor_email']))
    {
        $valid = 0;
        $error_message .= EMAIL_EMPTY_CHECK.'\n';
    }
    else
    {
    	// Email validation check
        if(!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL))
        {
            $valid = 0;
            $error_message .= EMAIL_VALID_CHECK.'\n';
        }
    }

    if(empty($_POST['visitor_comment']))
    {
        $valid = 0;
        $error_message .= COMMENT_EMPTY_CHECK.'\n';
    }

    if($valid == 1)
    {
		$visitor_name = strip_tags($_POST['visitor_name']);
		$visitor_email = strip_tags($_POST['visitor_email']);
		$visitor_phone = strip_tags($_POST['visitor_phone']);
		$visitor_comment = strip_tags($_POST['visitor_comment']);

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

        $mail->addReplyTo($visitor_email);
        $mail->setFrom($send_email_from);
        $mail->addAddress($receive_email_to);

        $mail->isHTML(true);
        $mail->Subject = CONTACT_FORM_MESSAGE;

        $message = '
<html><body>
<p>Ad Soyad<br>'.$visitor_name.'</p>
<p>Email<br>'.$visitor_email.'</p>
<p>Telefon<br>'.$visitor_phone.'</p>
<p>Mesaj<br>'.nl2br($visitor_comment).'</p>
</body></html>
';
		$mail->Body = $message;
        $mail->send();

        $success_message = CONTACT_FORM_SUCCESS_MESSAGE;

    }
}
?>
				
				<?php
				if($error_message != '') {
					echo "<script>alert('".$error_message."')</script>";
				}
				if($success_message != '') {
					echo "<script>alert('".$success_message."')</script>";
				}
				?>
								<form action="<?php echo BASE_URL.URL_PAGE.$_REQUEST['slug']; ?>" method="post">
									<div class="row">
										<div class="col-lg-4 col-sm-4">
											<div class="form-group">
												<input type="text" name="visitor_name" class="form-control" required placeholder="Ad Soyad">
												<div class="help-block with-errors"></div>
											</div>
										</div>			
										<div class="col-lg-4 col-sm-4">
											<div class="form-group">
												<input type="email" name="visitor_email" class="form-control" required placeholder="E-Posta">
												<div class="help-block with-errors"></div>
											</div>
										</div>			
										<div class="col-lg-4 col-sm-4">
											<div class="form-group">
												<input type="text" name="visitor_phone" required class="form-control" placeholder="Telefon Numarası">
												<div class="help-block with-errors"></div>
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<textarea name="visitor_comment" class="form-control" cols="30" rows="5" required placeholder="Mesaj"></textarea>
												<div class="help-block with-errors"></div>
											</div>
										</div>			
										<div class="col-lg-12 col-md-12">
											<button type="submit" name="form_contact" class="default-btn btn-two">
												<span class="label">Gönder</span>
												<i class='bx bx-plus'></i>
											</button>
											<div id="msgSubmit" class="h3 text-center hidden"></div>
											<div class="clearfix"></div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Contact Area -->

		<!-- Start Map Area -->
		<div class="map-area">
			<?php echo $contact_map_iframe; ?>
		</div>
		<!-- End Map Area -->		
        <?php endif; ?>
        <?php if($page_layout == 'Blog Sayfa Düzeni'): ?>
		<!-- Start  Blog Right Area -->
        <section class="blog-details-area ptb-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-12">
						<div class="blog-details-desc">
							<div class="row">
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
							$statement->execute();
							$total = $statement->rowCount();
							?>
							<?php if(!$total): ?>
							<p style="color:red;">Gönderi Bulunamadı</p>
							<?php else: ?>
                            <?php
                            /* ===================== Pagination Code Starts ================== */
                            		$adjacents = 10;	
		
                            		$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
                            		$statement->execute();
                            		$total_pages = $statement->rowCount();
		
                            		$targetpage = $_SERVER['PHP_SELF'];
                            		$limit = 6;                                 
                            		$page = @$_GET['page'];
                            		if($page) 
                            			$start = ($page - 1) * $limit;          
                            		else
                            			$start = 0;	
                            		$statement = $pdo->prepare("SELECT
								    t1.news_title,
		                            t1.news_slug,
		                            t1.news_content,
		                            t1.news_content_short,
		                            t1.news_date,
		                            t1.photo,
		                            t1.category_id,

		                            t2.category_id,
		                            t2.category_name,
		                            t2.category_slug
		                            FROM tbl_news t1
		                            JOIN tbl_category t2
		                            ON t1.category_id = t2.category_id 		                           
		                            ORDER BY t1.news_id 
		                            LIMIT $start, $limit");
		                            $statement->execute();
		                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		
		                            $s1 = $_REQUEST['slug'];
				
		                            if ($page == 0) $page = 1;                  
		                            $prev = $page - 1;                          
		                            $next = $page + 1;                          
		                            $lastpage = ceil($total_pages/$limit);      
		                            $lpm1 = $lastpage - 1;   
		                            $pagination = "";
		                            if($lastpage > 1)
		                            {   
			                        $pagination .= "<li class=\"page-item\">";
			                        if ($page > 1) 
				                        $pagination.= "<a class=\"page-link page-links\" href=\"$targetpage?slug=$s1&page=$prev\"><i class='bx bx-chevrons-left'></i></a>";
			                        else
				                        $pagination.= "<span class=\"page-link page-links\" class=\"disabled\"><i class='bx bx-chevrons-left'></i></span>";    
			                        if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
			                        {   
				                        for ($counter = 1; $counter <= $lastpage; $counter++)
				                        {
					                        if ($counter == $page)
						                        $pagination.= "<li class=\"page-item\"><span class=\"page-link\" class=\"active\">$counter</span></li>";
					                        else
						                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$counter\">$counter</a></li>";                 
				                        }
			                        }
			                        elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
			                        {
				                        if($page < 1 + ($adjacents * 2))        
				                        {
					                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					                        {
						                        if ($counter == $page)
							                        $pagination.= "<li class=\"page-item\"><span class=\"page-link\" class=\"active\">$counter</span></li>";
						                        else
							                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$counter\">$counter</a></li>";                 
					                        }
					                        $pagination.= "...";
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$lpm1\">$lpm1</a></li>";
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$lastpage\">$lastpage</a></li>";       
				                        }
				                        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				                        {
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=1\">1</a></li>";
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=2\">2</a></li>";
					                        $pagination.= "...";
					                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					                        {
						                        if ($counter == $page)
							                        $pagination.= "<li class=\"page-item\"><span class=\"page-link\" class=\"active\">$counter</span></li>";
						                        else
							                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$counter\">$counter</a></li>";                 
					                        }
					                        $pagination.= "...";
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$lpm1\">$lpm1</a></li>";
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$lastpage\">$lastpage</a></li>";       
				                        }
				                        else
				                        {
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=1\">1</a></li>";
					                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=2\">2</a></li>";
					                        $pagination.= "...";
					                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					                        {
						                        if ($counter == $page)
							                        $pagination.= "<li class=\"page-item\"><span class=\"page-link\">$counter</span></li>";
						                        else
							                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$counter\">$counter</a></li>";                 
					                        }
				                        }
			                        }
			                        if ($page < $counter - 1) 
				                        $pagination.= "<a class=\"page-link\" href=\"$targetpage?slug=$s1&page=$next\"><i class='bx bx-chevrons-right'></i></a></li>";
			                        else
				                        $pagination.= "<span class=\"page-link\" class=\"disabled\"><i class='bx bx-chevrons-right'></i></span>";
			                        $pagination.= "</li>\n";       
		                        }
		                        /* ===================== Pagination Code Ends ================== */
		                    ?>
							<?php
							foreach ($result as $row) {
							?>							
								<div class="col-lg-6 col-md-6">
									<div class="single-blog">
										<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>">
											<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['news_title']; ?>">
										</a>
										<div class="blog-content">
											<a class="user" href="#">
												<a href="<?php echo BASE_URL.URL_CATEGORY.$row['category_slug']; ?>"><?php echo $row['category_name']; ?></a>
											</a>
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
							    <?php endif; ?>															
								<div class="col-lg-12">
									<div class="page-navigation-area">
										<nav aria-label="Page navigation example text-center">
											<ul class="pagination">
											<?php if($total): ?>
							                <?php echo $pagination; ?>
							                <?php endif; ?>											
											</ul>
										</nav>
									</div>
								</div>
							</div>				
						</div>
					</div>
                    <?php require_once('sidebar.php'); ?>
				</div>
			</div>
		</section>
		<!-- End Blog Right Area -->
        <?php endif; ?>
        <?php if($page_layout == 'Personel Sayfa Düzeni'): ?>
		<!-- Start Team Area -->
		<section class="team-area ptb-100 jarallax"  data-jarallax='{"speed": 0.3}'>
			<div class="container">
				<div class="row">
				<?php
					$statement = $pdo->prepare("SELECT
												
												t1.id,
												t1.name,
												t1.slug,
												t1.designation_id,
												t1.photo,
												t1.degree,
												t1.detail,
												t1.facebook,
												t1.twitter,
												t1.linkedin,
												t1.youtube,
												t1.google_plus,
												t1.instagram,
												t1.flickr,
												t1.address,
												t1.practice_location,
												t1.phone, 
												t1.email,
												t1.website,
												t1.status,

												t2.designation_id,
												t2.designation_name
						
					                            FROM tbl_team_member t1
					                            JOIN tbl_designation t2
					                            ON t1.designation_id = t2.designation_id
					                            WHERE t1.status=?
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
<?php require_once('footer.php'); ?>