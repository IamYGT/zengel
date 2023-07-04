<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
		$valid = 1;
	    if(empty($_POST['email'])) {
	        $valid = 0;
	        $error_message .= 'E-posta adresi boş bırakılamaz<br>';
	    } else {
	    	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
		        $valid = 0;
		        $error_message .= 'E-posta adresi geçerli olmalıdır<br>';
		    }
	    }
	    if($valid == 1) {
			
	    	$_SESSION['user']['email'] = $_POST['email'];
			// updating the database
			$statement = $pdo->prepare("UPDATE tbl_user SET email=? WHERE id=?");
			$statement->execute(array($_POST['email'],$_SESSION['user']['id']));
	    	$success_message = 'E-posta başarıyla güncellendi.';
	    }
}
if(isset($_POST['form2'])) {
	$valid = 1;
	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'jpg, jpeg, gif veya png dosyası yüklemeniz gerekir<br>';
        }
    } else {
    	$valid = 0;
        $error_message .= 'Bir fotoğraf seçmelisiniz<br>';
    }
    if($valid == 1) {
    	// removing the existing photo
    	unlink('../assets/uploads/'.$_SESSION['user']['photo']);
    	// updating the data
    	$final_name = 'user-'.$_SESSION['user']['id'].'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
        $_SESSION['user']['photo'] = $final_name;
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET photo=? WHERE id=?");
		$statement->execute(array($final_name,$_SESSION['user']['id']));
        $success_message = 'Kullanıcı Fotoğrafı başarıyla güncellendi.';
    	
    }
}
if(isset($_POST['form3'])) {
	$valid = 1;
	if( empty($_POST['password']) || empty($_POST['re_password']) ) {
        $valid = 0;
        $error_message .= "Şifre boş olamaz<br>";
    }
    if( !empty($_POST['password']) && !empty($_POST['re_password']) ) {
    	if($_POST['password'] != $_POST['re_password']) {
	    	$valid = 0;
	        $error_message .= "Şifre uyuşmuyor<br>";	
    	}        
    }
    if($valid == 1) {
    	$_SESSION['user']['password'] = md5($_POST['password']);
    	// updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE id=?");
		$statement->execute(array(md5($_POST['password']),$_SESSION['user']['id']));
    	$success_message = 'Kullanıcı Şifresi başarıyla güncellendi.';
    }
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Profili Düzenle</h1>
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
				
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab">E-Posta Güncelle</a></li>
						<li><a href="#tab_2" data-toggle="tab">Resim Güncelle</a></li>
						<li><a href="#tab_3" data-toggle="tab">Şifre Güncelle</a></li>
					</ul>
					<div class="tab-content">
          				<div class="tab-pane active" id="tab_1">
							
							<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">E-Posta Adresi <span>*</span></label>
										<div class="col-sm-4">
											<input type="email" class="form-control" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
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
          				<div class="tab-pane" id="tab_2">
							<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Mevcut Resim</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="existing-photo" width="140">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Yeni Resim</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form2">Güncelle</button>
										</div>
									</div>
								</div>
							</div>
							</form>
          				</div>
          				<div class="tab-pane" id="tab_3">
							<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Şifre </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Şifre Doğrula </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="re_password">
										</div>
									</div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form3">Güncelle</button>
										</div>
									</div>
								</div>
							</div>
							</form>
          				</div>
          			</div>
				</div>			
		</div>
	</div>
</section>
<?php require_once('footer.php'); ?>