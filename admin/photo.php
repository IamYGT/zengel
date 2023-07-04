<?php require_once('header.php'); ?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Foto Galeri Listele</h1>
	</div>
	<div class="content-header-right">
		<a href="photo-add.php" class="btn btn-primary btn-sm">Yeni Ekle</a>
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
			        <th>Resim Etiketi</th>
			        <th>Resim</th>
			        <th>Kategori</th>
			        <th>İşlem</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT 
            	                           
											t1.photo_id,
											t1.photo_caption,
											t1.photo_name,
											t1.p_category_id,
											t2.p_category_id,
											t2.p_category_name
            	                           	FROM tbl_photo t1
            	                           	JOIN tbl_category_photo t2
            	                           	ON t1.p_category_id = t2.p_category_id");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
	            	?>
	                <tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['photo_caption']; ?></td>
	                    <td>
	                    	<img src="../assets/uploads/<?php echo $row['photo_name']; ?>" width="140">
	                    </td>
	                    <td><?php echo $row['p_category_name']; ?></td>
	                    <td>
	                        <a href="photo-edit.php?id=<?php echo $row['photo_id']; ?>" class="btn btn-primary btn-xs">Düzenle</a>
	                        <a href="#" class="btn btn-danger btn-xs" data-href="photo-delete.php?id=<?php echo $row['photo_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Sil</a>
	                    </td>
	                </tr>
	                <?php
            	}
            	?>
            </tbody>
          </table>
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