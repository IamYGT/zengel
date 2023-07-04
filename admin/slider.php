<?php require_once('header.php'); ?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Slider Listele</h1>
	</div>
	<div class="content-header-right">
		<a href="slider-add.php" class="btn btn-primary btn-sm">Yeni Ekle</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Resim</th>
								<th>Başlık</th>
								<th>Kısa İçeerik</th>
								<th>Buton Text</th>
								<th>Buton URL</th>
								<th>Konum</th>
								<th>Durum</th>
								<th width="140">İşlem</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT
														
														id,
														photo,
														heading,
														content,
														button_text,
														button_url,
														position,
														status
							                           	FROM tbl_slider
							                           	
							                           	");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td style="width:150px;"><img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['heading']; ?>" style="width:140px;"></td>
									<td><?php echo $row['heading']; ?></td>
									<td><?php echo $row['content']; ?></td>
									<td><?php echo $row['button_text']; ?></td>
									<td><?php echo $row['button_url']; ?></td>
									<td><?php echo $row['position']; ?></td>
									<td><?php echo $row['status']; ?></td>
									<td>										
										<a href="slider-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Düzenle</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="slider-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Sil</a>  
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