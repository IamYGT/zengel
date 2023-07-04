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
	// Check the category slug is valid or not.
	$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=?");
	$statement->execute(array($_REQUEST['slug']));
	$total = $statement->rowCount();
	if( $total == 0 )
	{
		header('location: '.BASE_URL);
		exit;
	}
}

// Getting the category name from the category slug
$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	$category_name = $row['category_name'];
	$category_slug = $row['category_slug'];
	$category_id = $row['category_id'];
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
    $banner_category = $row['banner_category'];
}
?>	
		<!-- Start Page Title Area -->
		<div class="page-title-area item-bg-1" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $banner_category; ?>)">
			<div class="container">
				<div class="page-title-content">
					<h2><?php echo $category_name; ?></h2>
					<ul>
						<li>
							<a href="<?php echo BASE_URL; ?>">
								Ana Sayfa 
							</a>
						</li>
						<li><?php echo $category_name; ?></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Page Title Area -->
		<!-- Start  Blog Right Area -->
        <section class="blog-details-area ptb-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-12">
						<div class="blog-details-desc">
							<div class="row">
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE category_id=?");
							$statement->execute(array($category_id));
							$total = $statement->rowCount();
							?>
							<?php if(!$total): ?>
							<p style="color:red;">Henüz içerik girilmemiş.</p>
							<?php else: ?>
							<?php
							/* ===================== Pagination Code Starts ================== */
									$adjacents = 10;	
		
									$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE category_id=? ORDER BY news_id DESC");
									$statement->execute(array($category_id));
									$total_pages = $statement->rowCount();
		
									$targetpage = $_SERVER['PHP_SELF'];
									$limit = 6;                                 
									$page = @$_GET['page'];
									if($page) 
										$start = ($page - 1) * $limit;          
									else
										$start = 0;	
		

									$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE category_id=? LIMIT $start, $limit");
									$statement->execute(array($category_id));
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
												<a href="<?php echo BASE_URL.URL_CATEGORY.$category_slug; ?>"><?php echo $category_name; ?></a>
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
<?php require_once('footer.php'); ?>