<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;
    if(empty($_POST['photo_caption'])) {
        $valid = 0;
        $error_message .= "Fotoğraf Alt Etiketi boş olamaz<br>";
    }
    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];
    if($path == '') {
    	$valid = 0;
        $error_message .= "Bir fotoğraf seçmelisiniz<br>";
    } else {
    	$ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'jpg, jpeg, gif veya png dosyası yüklemeniz gerekir<br>';
        }
    }
    if(empty($_POST['p_category_id'])) {
        $valid = 0;
        $error_message .= "Bir fotoğraf kategorisi seçmelisiniz<br>";
    }
    
    if($valid == 1) {
    	// getting auto increment id for photo renaming
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_photo'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}
		// uploading the photo into the main location and giving it a final name
		$final_name = 'photo-'.$ai_id.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
		// saving into the database
		$statement = $pdo->prepare("INSERT INTO tbl_photo (photo_caption,photo_name,p_category_id) VALUES (?,?,?)");
		$statement->execute(array($_POST['photo_caption'],$final_name,$_POST['p_category_id']));
    	$success_message = 'Fotoğraf başarıyla eklendi.';
    }
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Foto Ekle</h1>
	</div>
	<div class="content-header-right">
		<a href="photo.php" class="btn btn-primary btn-sm">Foto Galeri Listele</a>
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
							<label for="" class="col-sm-2 control-label">Foto Alt Etiketi <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="photo_caption">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Resim <span>*</span></label>
							<div class="col-sm-4" style="padding-top:6px;">
								<input type="file" name="photo">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Kategori <span>*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="p_category_id">
									<option value="">Bir fotoğraf kategorisi seçin</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_category_photo ORDER BY p_category_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
									foreach ($result as $row) {
										echo '<option value="'.$row['p_category_id'].'">'.$row['p_category_name'].'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
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