<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;
	if(empty($_POST['news_title'])) {
		$valid = 0;
		$error_message .= 'Blog başlığı boş bırakılamaz<br>';
	} else {
		// Duplicate Checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_title=?");
    	$statement->execute(array($_POST['news_title']));
    	$total = $statement->rowCount();
    	if($total) {
    		$valid = 0;
        	$error_message .= "Blog başlığı zaten var<br>";
    	}
	}
	if(empty($_POST['news_content'])) {
		$valid = 0;
		$error_message .= 'Blog içeriği boş bırakılamaz<br>';
	}
	if(empty($_POST['news_content_short'])) {
		$valid = 0;
		$error_message .= 'Blog içeriği (kısa) boş bırakılamaz<br>';
	}
	if(empty($_POST['news_date'])) {
		$valid = 0;
		$error_message .= 'Blog yayınlanma tarihi boş bırakılamaz<br>';
	}
	if(empty($_POST['category_id'])) {
		$valid = 0;
		$error_message .= 'Bir kategori seçmelisiniz<br>';
	}
	if($_POST['publisher'] == '') {
		$publisher = $_SESSION['user']['full_name'];
	} else {
		$publisher = $_POST['publisher'];	
	}
	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'jpg, jpeg, gif veya png dosyası yüklemeniz gerekir<br>';
        }
    }
	
	if($valid == 1) {
		// getting auto increment id for photo renaming
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_news'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}
		if($_POST['news_slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['news_title']);
    		$news_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	} else {
    		$temp_string = strtolower($_POST['news_slug']);
    		$news_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	}
    	// if slug already exists, then rename it
		$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
		$statement->execute(array($news_slug));
		$total = $statement->rowCount();
		if($total) {
			$news_slug = $news_slug.'-1';
		}
		if($path=='') {
			// When no photo will be selected
			$statement = $pdo->prepare("INSERT INTO tbl_news (news_title,news_slug,news_content,news_content_short,news_date,photo,category_id,publisher,total_view,meta_title,meta_description) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
			$statement->execute(array($_POST['news_title'],$news_slug,$_POST['news_content'],$_POST['news_content_short'],$_POST['news_date'],'',$_POST['category_id'],$publisher,0,$_POST['meta_title'],$_POST['meta_description']));
		} else {
    		// uploading the photo into the main location and giving it a final name
    		$final_name = 'news-'.$ai_id.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
            $statement = $pdo->prepare("INSERT INTO tbl_news (news_title,news_slug,news_content,news_content_short,news_date,photo,category_id,publisher,total_view,meta_title,meta_description) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
			$statement->execute(array($_POST['news_title'],$news_slug,$_POST['news_content'],$_POST['news_content_short'],$_POST['news_date'],$final_name,$_POST['category_id'],$publisher,0,$_POST['meta_title'],$_POST['meta_description']));
		}
	
		$success_message = 'Blog başarıyla eklendi!';
	}
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Blog Ekle</h1>
	</div>
	<div class="content-header-right">
		<a href="news.php" class="btn btn-primary btn-sm">Blog Listele</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if($error_message): ?>
			<div class="callout callout-danger">
				<p>
				<?php echo $error_message; ?>
				</p>
			</div>
			<?php endif; ?>
			<?php if($success_message): ?>
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Blog Başlığı <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="news_title" placeholder="Örnek: Şanzıman Tamiri">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Blog İçeriği <span>*</span></label>
							<div class="col-sm-8">
								<textarea class="form-control editor" name="news_content"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Blog İçeriği (kısa) <span>*</span></label>
							<div class="col-sm-8">
								<textarea class="form-control" name="news_content_short" style="height:100px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Blog Yayın Tarihi<span>*</span></label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="news_date" id="datepicker" value="<?php echo date('d-m-Y'); ?>">(Format: gün-ay-yıl)
							</div>
						</div>
						<div class="form-group">
				            <label for="" class="col-sm-3 control-label">Resim</label>
				            <div class="col-sm-6" style="padding-top:6px;">
				                <input type="file" name="photo">
				            </div>
				        </div>
						<div class="form-group">
				            <label for="" class="col-sm-3 control-label">Kategori Seçin <span>*</span></label>
				            <div class="col-sm-3">
				            	<select class="form-control select2" name="category_id">
				            		<option value="">Bir kategori seç</option>
				            		<?php
						            	$i=0;
						            	$statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
						            	$statement->execute();
						            	$result = $statement->fetchAll();
						            	foreach ($result as $row) {
						            		?>
											<option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
						            		<?php
						            	}
					            	?>
				            	</select>
				            </div>
				        </div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Yayımcı </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="publisher"> (Bu alanı boş bırakırsanız, oturum açmış kullanıcı yayıncı olarak kabul edilecektir)
							</div>
						</div>
						<h3 class="seo-info">SEO Ayarları</h3>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">SEO Title </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="meta_title">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">SEO Url </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="news_slug" placeholder="Örnek: blog-basligi">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">SEO Description </label>
							<div class="col-sm-8">
								<textarea class="form-control" name="meta_description" style="height:200px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Ekle</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php require_once('footer.php'); ?>