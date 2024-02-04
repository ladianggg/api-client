<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost:8000/api/posts',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$response_data = json_decode($response);
$posts = $response_data->data->data;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Toko Online</title>

    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>
<br><br><br>
<div class="container-fluid">
    <button class="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus fa-sm"></i> Tambah Data</button>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TITLE</th>
                            <th>IMAGE</th>
                            <th>CONTENT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($posts as $post) :
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $post->title; ?></td>
                                <td align="center"><img src="<?php echo "http://localhost:8000".$post->image; ?>" alt="Post Image" style="max-width: 100px; max-height: 100px;"></td>
                                <td><?php echo $post->content; ?></td>
                                <td align="center">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $post->id; ?>"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusModal<?php echo $post->id; ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Modal Tambah-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" action="proses_tambah.php">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <label>Image</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="inputGroupFile01">
                                            <label class="custom-file-label" id="name" for="inputGroupFile01">Tidak ada file yang dipilih</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <input type="text" class="form-control" name="content" required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- Modal Edit-->
                <?php foreach ($posts as $post) : ?>
                    <div class="modal fade" id="editModal<?php echo $post->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data" action="proses_edit.php">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="hidden" class="form-control" name="id" value="<?php echo $post->id; ?>">
                                            <input type="text" class="form-control" name="title" value="<?php echo $post->title; ?>" required>
                                        </div>
                                        <label>Image</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="inputFileEdit<?php echo $post->id; ?>">
                                                <label class="custom-file-label" id="nameGambarEdit<?php echo $post->id; ?>" for="inputFileEdit<?php echo $post->id; ?>"><?php echo str_replace('http://localhost:8000/storage/posts/', '', $post->image); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Content</label>
                                            <input type="text" class="form-control" name="content" value="<?php echo $post->content; ?>" required>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeBtn" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Hapus Modal -->
                    <div class="modal fade" id="hapusModal<?php echo $post->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>                                </div>
                                <div class="modal-body">
                                    <p>Anda yakin ingin menghapus <?php echo $post->title ?>?</p>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="proses_hapus.php?id=<?php echo $post->id; ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/demo/datatables-demo.js"></script>
</body>

</html>
<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function() {
        $j('#dataTable').DataTable({
            "lengthMenu": [5, 10, 25, 50],
        });

        var initialInputFileValueTambah = $j('#inputFileTambah').val();
        var initialLabelValueTambah = $j('#nameTambah').html();

        <?php foreach ($posts as $post) : ?>
            var initialInputFileValueEdit<?php echo $post->id; ?> = $j('#inputFileEdit<?php echo $post->id; ?>').val();
            var initialLabelValueEdit<?php echo $post->id; ?> = $j('#nameGambarEdit<?php echo $post->id; ?>').html();
        <?php endforeach; ?>

        // For "Tambah" Modal
        $j('#inputFileTambah').change(function(e) {
            var fileName = e.target.files[0].name;
            $j('#nameTambah').html(fileName);
        });

        // For "Edit" Modals
        <?php foreach ($posts as $post) : ?>
            $j('#inputFileEdit<?php echo $post->id; ?>').change(function(e) {
                var fileName = e.target.files[0].name;
                $j('#nameGambarEdit<?php echo $post->id; ?>').html(fileName);
            });
        <?php endforeach; ?>

        // Reset file input and labels on modal close
        $j('#exampleModal, [id^=editModal]').on('hidden.bs.modal', function() {
            $j('#inputFileTambah').val(initialInputFileValueTambah);
            $j('#nameTambah').html(initialLabelValueTambah);

            <?php foreach ($posts as $post) : ?>
                $j('#inputFileEdit<?php echo $post->id; ?>').val(initialInputFileValueEdit<?php echo $post->id; ?>);
                $j('#nameGambarEdit<?php echo $post->id; ?>').html(initialLabelValueEdit<?php echo $post->id; ?>);
            <?php endforeach; ?>
        });
    });
</script>