<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;
	if(empty($_POST['name'])) {
		$valid = 0;
		$error_message .= 'Ad Soyad boş olamaz<br>';
	}
	if(empty($_POST['designation'])) {
		$valid = 0;
		$error_message .= 'Branş boş olamaz<br>';
	}
	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'jpg, jpeg, gif veya png dosyası yüklemeniz gerekir<br>';
        }
    } else {
    	$valid = 0;
        $error_message .= 'Bir fotoğraf seçmelisiniz<br>';
    }
    if(empty($_POST['comment'])) {
		$valid = 0;
		$error_message .= 'Yorum boş olamaz<br>';
	}
	if($valid == 1) {
		// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_testimonial'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}
		$final_name = 'testimonial-'.$ai_id.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
	
		$statement = $pdo->prepare("INSERT INTO tbl_testimonial (name,designation,photo,comment) VALUES (?,?,?,?)");
		$statement->execute(array($_POST['name'],$_POST['designation'],$final_name,$_POST['comment']));
			
		$success_message = 'Müşteri yorumu başarıyla eklendi!';
		unset($_POST['name']);
		unset($_POST['designation']);
		unset($_POST['comment']);
	}
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>M. Yorum Ekle</h1>
	</div>
	<div class="content-header-right">
		<a href="testimonial.php" class="btn btn-primary btn-sm">M. Yorum Listele</a>
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
							<label for="" class="col-sm-2 control-label">Ad Soyad <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Branş <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="designation" value="<?php if(isset($_POST['designation'])){echo $_POST['designation'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Resim <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="photo">(Yalnızca jpg, jpeg, gif ve png'ye izin verilir)
							</div>
						</div>						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Yorum <span>*</span></label>
							<div class="col-sm-6">
								<textarea class="form-control" name="comment" style="height:200px;"><?php if(isset($_POST['comment'])){echo $_POST['comment'];} ?></textarea>
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