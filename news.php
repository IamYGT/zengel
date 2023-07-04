<?php require_once('header.php'); ?>
		
<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
	header('location: '.BASE_URL);
	exit;
}

// Getting the news detailed data from the news id
$statement = $pdo->prepare("SELECT
							t1.news_title,
							t1.news_slug,
							t1.news_content,
							t1.news_date,
							t1.publisher,
							t1.photo,
							t1.category_id,
							
							t2.category_id,
							t2.category_name,
							t2.category_slug

                           	FROM tbl_news t1
                           	JOIN tbl_category t2
                           	ON t1.category_id = t2.category_id
                           	WHERE t1.news_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$news_title    = $row['news_title'];
	$news_content  = $row['news_content'];
	$news_date     = $row['news_date'];
	$publisher     = $row['publisher'];
	$photo         = $row['photo'];
	$category_id   = $row['category_id'];
	$category_slug = $row['category_slug'];
	$category_name = $row['category_name'];
}

// Update data for view count for this news page
// Getting current view count
$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	$current_total_view = $row['total_view'];
}
$updated_total_view = $current_total_view+1;

// Updating database for view count
$statement = $pdo->prepare("UPDATE tbl_news SET total_view=? WHERE news_slug=?");
$statement->execute(array($updated_total_view,$_REQUEST['slug']));
?>
		<!-- Start Page Title Area -->
		<div class="page-title-area item-bg-1" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $banner; ?>)">
			<div class="container">
				<div class="page-title-content">
					<h2><?php echo $news_title; ?></h2>
					<ul>
						<li>
							<a href="<?php echo BASE_URL; ?>">
								Ana Sayfa 
							</a>
						</li>
						<li><?php echo $news_title; ?></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Page Title Area -->
		<!-- Start Inner Blog Details Area -->
        <section class="blog-details-area ptb-100">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-12">
						<div class="blog-details-desc">
							<div class="article-image">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo ?>" alt="<?php echo $news_title; ?>">
							</div>
							<div class="article-content">
								<div class="entry-meta">
									<ul>
										<li><span>Kategori:</span> <a href="<?php echo BASE_URL.URL_CATEGORY.$category_slug; ?>"><?php echo $category_name; ?></a></li>
										<li><span>Tarih:</span> <a href="#"><?php echo $news_date; ?></a></li>
										<li><span>Yazar:</span> <a href="#"><?php echo $publisher; ?></a></li>
									</ul>
								</div>
								<h3><?php echo $news_title; ?></h3>
								<p><?php echo $news_content; ?></p>
							</div>
						</div>
					</div>
                    <?php require_once('sidebar.php'); ?>
				</div>
			</div>
		</section>
		<!-- End Inner Blog Details Area -->
<?php require_once('footer.php'); ?>