<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;
    if(empty($_POST['page_name'])) {
        $valid = 0;
        $error_message .= "Sayfa Başlığı boş olamaz<br>";
    } else {
		// Duplicate Page checking
    	// current page name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_page_name = $row['page_name'];
		}
		$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_name=? and page_name!=?");
    	$statement->execute(array($_POST['page_name'],$current_page_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Sayfa başlığı zaten var<br>';
    	}
    }
    $path = $_FILES['banner']['name'];
    $path_tmp = $_FILES['banner']['tmp_name'];
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'jpg, jpeg, gif veya png dosyası yüklemeniz gerekir<br>';
        }
    }
    if($valid == 1) {
    	if($_POST['page_slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['page_name']);
    		$page_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);;
    	} else {
    		$temp_string = strtolower($_POST['page_slug']);
    		$page_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	}
    	// if slug already exists, then rename it
		$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=? AND page_name!=?");
		$statement->execute(array($page_slug,$current_page_name));
		$total = $statement->rowCount();
		if($total) {
			$page_slug = $page_slug.'-1';
		}
   
   		if($path == '') {
			// updating into the database
			$statement = $pdo->prepare("UPDATE tbl_page SET page_name=?, page_slug=?, page_content=?,page_layout=?, status=?, meta_title=?, meta_description=? WHERE page_id=?");
			$statement->execute(array($_POST['page_name'],$page_slug,$_POST['page_content'],$_POST['page_layout'],$_POST['status'],$_POST['meta_title'],$_POST['meta_description'],$_REQUEST['id']));
   		} else {
   			unlink('../assets/uploads/'.$_POST['current_banner']);
			$final_name = 'page-banner-'.$_REQUEST['id'].'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
   			// updating into the database
			$statement = $pdo->prepare("UPDATE tbl_page SET page_name=?, page_slug=?, page_content=?,page_layout=?, banner=?, status=?, meta_title=?, meta_description=? WHERE page_id=?");
			$statement->execute(array($_POST['page_name'],$page_slug,$_POST['page_content'],$_POST['page_layout'],$final_name,$_POST['status'],$_POST['meta_title'],$_POST['meta_description'],$_REQUEST['id']));
   		}
    	$success_message = 'Sayfa başarıyla güncellendi.';
    }
}
?>
<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_id=?");
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
		<h1>Sayfayı Düzenle</h1>
	</div>
	<div class="content-header-right">
		<a href="page.php" class="btn btn-primary btn-sm">Sayfaları Listele</a>
	</div>
</section>
<?php							
foreach ($result as $row) {
	$page_name        = $row['page_name'];
	$page_slug        = $row['page_slug'];
	$page_content     = $row['page_content'];
	$page_layout      = $row['page_layout'];
	$banner           = $row['banner'];
	$status           = $row['status'];
	$meta_title       = $row['meta_title'];
	$meta_description = $row['meta_description'];
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
		<input type="hidden" name="current_banner" value="<?php echo $banner; ?>">
        <div class="box box-info">
            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Sayfa Başlığı <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="page_name" value="<?php echo $page_name; ?>">
                    </div>
                </div>
                <div class="form-group">
					<label for="" class="col-sm-2 control-label">Sayfa Düzeni </label>
					<div class="col-sm-2">
						<select class="form-control select2" name="page_layout" style="width:300px;" onchange="showContentInputArea(this)">
							<option value="Tam Genişlik Sayfa Düzeni" <?php if($page_layout=='Tam Genişlik Sayfa Düzeni') {echo 'selected';} ?>>Tam Genişlik Sayfa Düzeni</option>
							<option value="Personel Sayfa Düzeni" <?php if($page_layout=='Personel Sayfa Düzeni') {echo 'selected';} ?>>Personel Sayfa Düzeni</option>
							<option value="Foto Galeri Sayfa Düzeni" <?php if($page_layout=='Foto Galeri Sayfa Düzeni') {echo 'selected';} ?>>Foto Galeri Sayfa Düzeni</option>
							<option value="Video Galeri Sayfa Düzeni" <?php if($page_layout=='Video Galeri Sayfa Düzeni') {echo 'selected';} ?>>Video Galeri Sayfa Düzeni</option>
							<option value="Blog Sayfa Düzeni" <?php if($page_layout=='Blog Sayfa Düzeni') {echo 'selected';} ?>>Blog Sayfa Düzeni</option>
							<option value="İletişim Sayfa Düzeni" <?php if($page_layout=='İletişim Sayfa Düzeni') {echo 'selected';} ?>>İletişim Sayfa Düzeni</option>
						</select>
					</div>
				</div>
                <div class="form-group" id="showPageContent" style="<?php if($page_layout=='Tam Genişlik Sayfa Düzeni') {echo 'display:block';}else{echo 'display:none;';} ?>">
					<label for="" class="col-sm-2 control-label">Sayfa içeriği </label>
					<div class="col-sm-9">
						<textarea class="form-control editor" name="page_content"><?php echo $page_content; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Mevcut Banner</label>
					<div class="col-sm-9" style="padding-top:5px">
						<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $banner; ?>" alt="Page Banner" style="width:200px;">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Banner <span>*</span></label>
					<div class="col-sm-9" style="padding-top:5px">
						<input type="file" name="banner">(Yalnızca jpg, jpeg, gif ve png'ye izin verilir)
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
                <h3 class="seo-info">SEO Ayarları</h3>
                <div class="form-group">
					<label for="" class="col-sm-2 control-label">SEO Title </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="meta_title" value="<?php echo $meta_title; ?>">
					</div>
				</div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">SEO URL</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="page_slug" value="<?php echo $page_slug; ?>">
                    </div>
                </div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">SEO Description </label>
					<div class="col-sm-9">
						<textarea class="form-control" name="meta_description" style="height:100px;"><?php echo $meta_description; ?></textarea>
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
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Silmeyi Onayla!</h4>
            </div>
            <div class="modal-body">
               Bu öğeyi silmek istediğinizden emin misiniz?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                <a class="btn btn-danger btn-ok">Sil</a>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>