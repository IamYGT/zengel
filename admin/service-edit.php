<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['name'])) {
		$valid = 0;
		$error_message .= 'Başlık boş olamaz<br>';
	}

	if(empty($_POST['description'])) {
		$valid = 0;
		$error_message .= 'İçerik boş olamaz<br>';
	}

	if(empty($_POST['short_description'])) {
		$valid = 0;
		$error_message .= 'Kısa İçerik boş bırakılamaz<br>';
	}
	
    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'Öne Çıkan Fotoğraf için jpg, jpeg, gif veya png dosyası yüklemelisiniz<br>';
        }
    }

    $path1 = $_FILES['banner']['name'];
    $path_tmp1 = $_FILES['banner']['tmp_name'];

    if($path1!='') {
        $ext1 = pathinfo( $path1, PATHINFO_EXTENSION );
        $file_name1 = basename( $path1, '.' . $ext1 );
        if( $ext1!='jpg' && $ext1!='png' && $ext1!='jpeg' && $ext1!='gif' ) {
            $valid = 0;
            $error_message .= 'Banner için jpg, jpeg, gif veya png dosyası yüklemelisiniz<br>';
        }
    }

	if($valid == 1) {

		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_name = $row['name'];
		}


		if($_POST['slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['name']);
    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);;
    	} else {
    		$temp_string = strtolower($_POST['slug']);
    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	}

    	// if slug already exists, then rename it
		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=? AND name!=?");
		$statement->execute(array($slug,$current_name));
		$total = $statement->rowCount();
		if($total) {
			$slug = $slug.'-1';
		}

		if($path == '' && $path1 == '') {
			$statement = $pdo->prepare("UPDATE tbl_service SET name=?, slug=?, description=?, short_description=?, meta_title=?, meta_description=? WHERE id=?");
    		$statement->execute(array($_POST['name'],$slug,$_POST['description'],$_POST['short_description'],$_POST['meta_title'],$_POST['meta_description'],$_REQUEST['id']));
		}
		if($path != '' && $path1 == '') {
			unlink('../assets/uploads/'.$_POST['current_photo']);

			$final_name = 'service-'.$_REQUEST['id'].'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        	$statement = $pdo->prepare("UPDATE tbl_service SET name=?, slug=?, description=?, short_description=?, photo=?, meta_title=?, meta_description=? WHERE id=?");
    		$statement->execute(array($_POST['name'],$slug,$_POST['description'],$_POST['short_description'],$final_name,$_POST['meta_title'],$_POST['meta_description'],$_REQUEST['id']));
		}
		if($path == '' && $path1 != '') {
			unlink('../assets/uploads/'.$_POST['current_banner']);

			$final_name1 = 'service-banner-'.$_REQUEST['id'].'.'.$ext1;
        	move_uploaded_file( $path_tmp1, '../assets/uploads/'.$final_name1 );

        	$statement = $pdo->prepare("UPDATE tbl_service SET name=?, slug=?, description=?, short_description=?, banner=?, meta_title=?, meta_description=? WHERE id=?");
    		$statement->execute(array($_POST['name'],$slug,$_POST['description'],$_POST['short_description'],$final_name1,$_POST['meta_title'],$_POST['meta_description'],$_REQUEST['id']));
		}
		if($path != '' && $path1 != '') {

			unlink('../assets/uploads/'.$_POST['current_photo']);
			unlink('../assets/uploads/'.$_POST['current_banner']);

			$final_name = 'service-'.$_REQUEST['id'].'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

			$final_name1 = 'service-banner-'.$_REQUEST['id'].'.'.$ext1;
        	move_uploaded_file( $path_tmp1, '../assets/uploads/'.$final_name1 );

        	$statement = $pdo->prepare("UPDATE tbl_service SET name=?, slug=?, description=?, short_description=?, photo=?, banner=?, meta_title=?, meta_description=? WHERE id=?");
    		$statement->execute(array($_POST['name'],$slug,$_POST['description'],$_POST['short_description'],$final_name,$final_name1,$_POST['meta_title'],$_POST['meta_description'],$_REQUEST['id']));
		}

		$success_message = 'Hizmet başarıyla güncellendi!';
	}
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Hizmeti Düzenle</h1>
	</div>
	<div class="content-header-right">
		<a href="service.php" class="btn btn-primary btn-sm">Hizmetleri Listele</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$name              = $row['name'];
	$slug              = $row['slug'];
	$description       = $row['description'];
	$short_description = $row['short_description'];
	$photo             = $row['photo'];
	$banner            = $row['banner'];
	$meta_title        = $row['meta_title'];
	$meta_description  = $row['meta_description'];
}
?>

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
				<input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
				<input type="hidden" name="current_banner" value="<?php echo $banner; ?>">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Başlık <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="name" value="<?php echo $name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">İçerik <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control editor" name="description"><?php echo $description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Kısa İçerik <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="short_description" style="height:140px;"><?php echo $short_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Mevcut Resim</label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo; ?>" alt="Service Photo" style="width:400px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Resim </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="photo">(Yalnızca jpg, jpeg, gif ve png'ye izin verilir)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Mevcut Banner</label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $banner; ?>" alt="Service Banner Photo" style="width:400px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Banner </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="banner">(Yalnızca jpg, jpeg, gif ve png'ye izin verilir)
							</div>
						</div>
						<h3 class="seo-info">SEO Ayarları</h3>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">SEO Title </label>
							<div class="col-sm-9">
								<input type="text" autocomplete="off" class="form-control" name="meta_title" value="<?php echo $meta_title; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">SEO Url </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="slug" value="<?php echo $slug; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">SEO Description </label>
							<div class="col-sm-9">
								<textarea class="form-control" name="meta_description" style="height:140px;"><?php echo $meta_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Güncelle</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>