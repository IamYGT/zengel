<?php require_once('header.php'); ?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Menüleri Listele</h1>
	</div>
	<div class="content-header-right">
		<a href="menu-add.php" class="btn btn-primary btn-sm">Yeni Ekle</a>
	</div>
</section>
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
			<div class="box box-info">        
				<div class="box-body table-responsive">
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
					
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Menü Tipi</th>
								<th>Menü Adı</th>
								<th>Menü URL</th>
								<th>Menü Sıra</th>
								<th>Menü Ebeveyni</th>
								<th style="width:60px;">İşlem</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$q = $pdo->prepare("SELECT * 
                                                FROM tbl_menu 
                                                ORDER BY menu_parent,menu_order ASC");
                            $q->execute();
                            $res = $q->fetchAll();
							foreach ($res as $row) {
								$i++;
								if($row['menu_type']=='Sayfa'):
                                    $r = $pdo->prepare("SELECT * 
                                                FROM tbl_page 
                                                WHERE page_id=?");
                                    $r->execute([$row['page_id']]);
                                    $res1 = $r->fetchAll();                           
                                    foreach ($res1 as $row1) {
                                        $menu_name = $row1['page_name'];
                                    }
                                    $menu_url = '---';
                                else:
                                    $menu_name = $row['menu_name'];
                                    $menu_url = $row['menu_url'];
                                endif;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['menu_type']; ?></td>
									<td><?php echo $menu_name; ?></td>
									<td style="width:250px;word-break: break-word;"><?php echo $menu_url; ?></td>
									<td><?php echo $row['menu_order']; ?></td>
									<td>
										<?php
                                        if($row['menu_parent'] == 0):
                                            echo '---';
                                        else:
                                            $r = $pdo->prepare("SELECT * 
                                                                FROM tbl_menu 
                                                                WHERE menu_id=?");
                                            $r->execute([$row['menu_parent']]);
                                            $res1 = $r->fetchAll();                           
                                            foreach ($res1 as $row1) {
                                                if($row1['page_id'] == 0):
                                                    echo $row1['menu_name'];
                                                else:
                                                    $s = $pdo->prepare("SELECT * 
                                                                        FROM tbl_page 
                                                                        WHERE page_id=?");
                                                    $s->execute([$row1['page_id']]);
                                                    $res2 = $s->fetchAll();                           
                                                    foreach ($res2 as $row2) {
                                                        echo $row2['page_name'];
                                                    }
                                                endif;
                                            }
                                        endif;
                                        ?>
									</td>
									<td>
										<a href="menu-edit.php?id=<?php echo $row['menu_id']; ?>" class="btn btn-primary btn-xs" style="width: 100%;margin-bottom:5px;">Düzenle</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="menu-delete.php?id=<?php echo $row['menu_id']; ?>" data-toggle="modal" data-target="#confirm-delete" style="width: 100%;">Sil</a>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Silme Onayla!</h4>
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