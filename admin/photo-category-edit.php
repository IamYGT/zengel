<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;
    if(empty($_POST['p_category_name'])) {
        $valid = 0;
        $error_message .= "Fotoğraf Kategori Adı boş bırakılamaz<br>";
    } else {
		// Duplicate Category checking
    	// current category name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_category_photo WHERE p_category_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_category_name = $row['p_category_name'];
		}
		$statement = $pdo->prepare("SELECT * FROM tbl_category_photo WHERE p_category_name=? and p_category_name!=?");
    	$statement->execute(array($_POST['p_category_name'],$current_category_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Fotoğraf Kategorisi adı zaten var<br>';
    	}
    }
    if($valid == 1) {
    	// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_category_photo SET p_category_name=?, status=? WHERE p_category_id=?");
		$statement->execute(array($_POST['p_category_name'],$_POST['status'],$_REQUEST['id']));
    	$success_message = 'Fotoğraf Kategorisi başarıyla güncellendi.';
    }
}
?>
<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_category_photo WHERE p_category_id=?");
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
		<h1>Fotoğraf Kategorisini Düzenle</h1>
	</div>
	<div class="content-header-right">
		<a href="photo-category.php" class="btn btn-primary btn-sm">Listele</a>
	</div>
</section>
<?php							
foreach ($result as $row) {
	$p_category_name = $row['p_category_name'];
	$status = $row['status'];
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
			<form class="form-horizontal" action="" method="post">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Kategori Adı <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="p_category_name" value="<?php echo $p_category_name; ?>">
							</div>
						</div>
						<div class="form-group">
				            <label for="" class="col-sm-2 control-label">Durum: </label>
				            <div class="col-sm-6">
				                <label class="radio-inline">
				                    <input type="radio" name="status" value="Aktif" <?php if($status == 'Aktif') { echo 'checked'; } ?>>Aktif
				                </label>
				                <label class="radio-inline">
				                    <input type="radio" name="status" value="Pasif" <?php if($status == 'Pasif') { echo 'checked'; } ?>>Pasif
				                </label>
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