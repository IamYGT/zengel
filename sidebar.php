					<div class="col-lg-4 col-md-12">
						<aside class="widget-area" id="secondary">
							<div class="widget widget_search">
								<h3 class="widget-title">Blog Ara</h3>
								<div class="post-wrap">
								    <form class="search-form" action="<?php echo BASE_URL.URL_SEARCH; ?>" method="post">
										<label>
											<span class="screen-reader-text">Ara:</span>
											<input type="text" name="search_string" class="search-field" placeholder="Ara...">
										</label>
										<button type="submit"><i class='bx bx-search'></i></button>
									</form>
								</div>
							</div>
		                    <?php
		                    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
		                    $statement->execute();
		                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		                    foreach ($result as $row) {
		                    	$total_recent_news_sidebar = $row['total_recent_news_sidebar'];
		                    	$total_popular_news_sidebar = $row['total_popular_news_sidebar'];
		                    }
		                    ?> 
							<section class="widget widget_categories">
								<h3 class="widget-title">Kategoriler</h3>
								<div class="post-wrap">
									<ul>
			                        <?php
			                        $statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
			                        $statement->execute();
			                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			                        foreach ($result as $row) {
			                        ?>									
										<li>
											<a href="<?php echo BASE_URL.URL_CATEGORY.$row['category_slug']; ?>"><?php echo $row['category_name']; ?></a>
										</li>
				                        <?php
			                            }
			                        ?>
									</ul>
								</div>
							</section>

							<section class="widget widget-peru-posts-thumb">
								<h3 class="widget-title">En Son Bloglar</h3>
								<div class="post-wrap">
			                    <?php
			                    $i=0;
			                    $statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
			                    $statement->execute();
			                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			                    foreach ($result as $row) {
				                    $i++;
				                    if($i>$total_recent_news_sidebar) {break;}
				                    ?>								
									<article class="item">
										<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>" class="thumb">
											<span class="fullimage cover" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>);" role="img"></span>
										</a>
										<div class="info">
											<time datetime="<?php echo $row['news_date']; ?>"><?php echo $row['news_date']; ?></time>
											<h4 class="title usmall">
												<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a>
											</h4>
										</div>
	
										<div class="clear"></div>
									</article>
				                    <?php
			                        }
			                    ?>	
								</div>
							</section>
							
							<section class="widget widget-peru-posts-thumb">
								<h3 class="widget-title">Popüler Bloglar</h3>
								<div class="post-wrap">
			                    <?php
			                    $i=0;
			                    $statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY total_view DESC");
			                    $statement->execute();
			                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			                    foreach ($result as $row) {
				                    $i++;
				                    if($i>$total_popular_news_sidebar) {break;}
				                    ?>							
									<article class="item">
										<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>" class="thumb">
											<span class="fullimage cover" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>);" role="img"></span>
										</a>
										<div class="info">
											<time datetime="<?php echo $row['news_date']; ?>"><?php echo $row['news_date']; ?></time>
											<h4 class="title usmall">
												<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a>
											</h4>
										</div>
	
										<div class="clear"></div>
									</article>
				                    <?php
			                        }
			                    ?>	
								</div>
							</section>							
						</aside>
					</div>