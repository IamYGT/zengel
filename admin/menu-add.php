<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form_page'])) {
    $valid = 1;
    if(empty($_POST['page_id'])) {
        $valid = 0;
        $error_message .= "Bir sayfa seçmelisiniz<br>";
    }
    if(empty($_POST['menu_order'])) {
        $valid = 0;
        $error_message .= "Menü Sırası boş olamaz<br>";
    } else {
        if(!is_numeric($_POST['menu_order'])) {
            $valid = 0;
            $error_message .= "Menü Sırası sayısal bir değer olmalıdır<br>";
        }
    }
    if( $_POST['menu_parent'] == '') {
        $valid = 0;
        $error_message .= "Bu menü için bir ebeveyn seçmelisiniz<br>";
    }
    if($valid == 1) {
        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_menu (menu_type,page_id,menu_name,menu_url,menu_order,menu_parent) VALUES (?,?,?,?,?,?)");
        $statement->execute(array('Sayfa',$_POST['page_id'],'','',$_POST['menu_order'],$_POST['menu_parent']));
        $success_message = 'Menü başarıyla eklendi.';
    }
}
?>
<?php
if(isset($_POST['form_other'])) {
    $valid = 1;
    if(empty($_POST['menu_name'])) {
        $valid = 0;
        $error_message .= "Menü Adı boş olamaz<br>";
    }
    if(empty($_POST['menu_url'])) {
        $valid = 0;
        $error_message .= "Menü URL'si boş olamaz<br>";
    }
    if(empty($_POST['menu_order'])) {
        $valid = 0;
        $error_message .= "Menü Sırası boş olamaz<br>";
    } else {
        if(!is_numeric($_POST['menu_order'])) {
            $valid = 0;
            $error_message .= "Menü Sırası sayısal bir değer olmalıdır<br>";
        }
    }
    if( $_POST['menu_parent'] == '') {
        $valid = 0;
        $error_message .= "Bu menü için bir ebeveyn seçmelisiniz<br>";
    }
    if($valid == 1) {
        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_menu (menu_type,page_id,menu_name,menu_url,menu_order,menu_parent) VALUES (?,?,?,?,?,?)");
        $statement->execute(array('Diğer',0,$_POST['menu_name'],$_POST['menu_url'],$_POST['menu_order'],$_POST['menu_parent']));
        $success_message = 'Menü başarıyla eklendi.';
    }
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Menü Ekle</h1>
	</div>
	<div class="content-header-right">
		<a href="menu.php" class="btn btn-primary btn-sm">Listele</a>
	</div>
</section>
<section class="content" style="min-height:auto;margin-bottom: -30px;">
	<div class="row">
		<div class="col-md-12">
			<?php if($error_message): ?>
			<div class="callout callout-danger">
			<h4>Lütfen aşağıdaki hataları düzeltin:</h4>
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>
			<?php if($success_message): ?>
			<div class="callout callout-success">
			<h4>Başarılı:</h4>
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab">Sayfa & Menü</a></li>
					<li><a href="#tab_2" data-toggle="tab">Diğer Menü</a></li>
				</ul>
				<div class="tab-content">
      				<div class="tab-pane active" id="tab_1">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Sayfa Seçin <span>*</span></label>
										<div class="col-sm-4">
											<select class="form-control select2" name="page_id">
												<option value="">Bir sayfa seçin</option>
												<?php
												$statement = $pdo->prepare("SELECT * FROM tbl_page ORDER BY page_name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);       
                                                foreach ($result as $row) {
                                                    echo '<option value="'.$row['page_id'].'">'.$row['page_name'].'</option>';
                                                }
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Ebeveyn Seç <span>*</span></label>
										<div class="col-sm-4">
											<select class="form-control select2" name="menu_parent">
												<option value="">Bu menü için bir ebeveyn seçin</option>
                                                <option value="0">Ebeveyn Yok</option>
												<?php
                                                $q = $pdo->prepare("SELECT * 
                                                                    FROM tbl_menu 
                                                                    ORDER BY menu_order ASC");
                                                $q->execute();
                                                $res = $q->fetchAll();
                                                foreach ($res as $row) {
                                                    if($row['page_id']==0) {
                                                        echo '<option value="'.$row['menu_id'].'">'.$row['menu_name'].'</option>';
                                                    } else {
                                                        $r = $pdo->prepare("SELECT * 
                                                                            FROM tbl_page 
                                                                            WHERE page_id=?");
                                                        $r->execute([$row['page_id']]);
                                                        $res1 = $r->fetchAll();
                                                        foreach ($res1 as $row1) {
                                                            echo '<option value="'.$row['menu_id'].'">'.$row1['page_name'].'</option>';
                                                        }
                                                    }
                                                }
                                                ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Sıra <span>*</span></label>
										<div class="col-sm-1">
											<input type="text" class="form-control" name="menu_order">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form_page">Ekle</button>
										</div>
									</div>
								</div>
							</div>
						</form>
      				</div>
      				<div class="tab-pane" id="tab_2">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Menü Adı <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="menu_name">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Menü URL <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="menu_url">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Ebeveyn <span>*</span></label>
										<div class="col-sm-4">
											<select class="form-control select2" name="menu_parent" style="width:100%;">
												<option value="">Bu menü için bir ebeveyn seçin</option>
												<option value="0">Ebeveyn Yok</option>
												<?php
                                                $q = $pdo->prepare("SELECT * 
                                                                    FROM tbl_menu 
                                                                    ORDER BY menu_order ASC");
                                                $q->execute();
                                                $res = $q->fetchAll();
                                                foreach ($res as $row) {
                                                    if($row['page_id']==0) {
                                                        echo '<option value="'.$row['menu_id'].'">'.$row['menu_name'].'</option>';
                                                    } else {
                                                        $r = $pdo->prepare("SELECT * 
                                                                            FROM tbl_page 
                                                                            WHERE page_id=?");
                                                        $r->execute([$row['page_id']]);
                                                        $res1 = $r->fetchAll();
                                                        foreach ($res1 as $row1) {
                                                            echo '<option value="'.$row['menu_id'].'">'.$row1['page_name'].'</option>';
                                                        }
                                                    }
                                                }
                                                ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Sıra <span>*</span></label>
										<div class="col-sm-1">
											<input type="text" class="form-control" name="menu_order">
										</div>
									</div>
									
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form_other">Ekle</button>
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