<?php require_once('header.php'); ?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Branş Listele</h1>
	</div>
	<div class="content-header-right">
		<a href="designation-add.php" class="btn btn-primary btn-sm">Yeni Ekle</a>
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
			        <th>Branş</th>
			        <th>İşlem</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_designation ORDER BY designation_name ASC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['designation_name']; ?></td>
	                    <td>
	                        <a href="designation-edit.php?id=<?php echo $row['designation_id']; ?>" class="btn btn-primary btn-xs">Düzenle</a>
	                        <a href="#" class="btn btn-danger btn-xs" data-href="designation-delete.php?id=<?php echo $row['designation_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Sil</a>
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