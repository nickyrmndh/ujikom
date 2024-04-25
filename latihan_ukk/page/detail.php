<?php
$details=mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.UserID=user.UserID WHERE foto.FotoID='$_GET[id]'");
$data=mysqli_fetch_array($details);
$likes=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID='$_GET[id]'"));
$cek=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID='$_GET[id]' AND UserID='$_SESSION[user_id]'"));
?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <img src="uploads/<?= $data['NamaFile'] ?> " alt="<?= $data['JudulFoto']?>" class="object-fit-cover">
                <div class="card-body">
                    <h3 class="card-title mb-0"><?=$data['JudulFoto']?><a href="<?php if(isset($_SESSION['user_id'])){echo '?url=like&&id='.$data['FotoID'].'';}else{echo 'login.php';}?>" class="btn-dark btn btn-sm"><?php if($cek==0){echo 'Like'; }else {echo 'Dislike';}?><?= $likes ?></a></h3>
                    <small class="text-muted mb-3">by:<?=$data['Username']?>, <?=$data['TanggalUnggah']?></small>
                    <p><?= $data['DeskripsiFoto']?></p>
                    <?php
                        $submit = @$_POST['submit'];
                        if ($submit == 'Kirim') {
                            $komentar = @$_POST['komentar'];
                            $foto_id = @$_POST['foto_id'];
                            // Pastikan $user_id telah diisi dengan nilai yang benar dari $_SESSION['user_id']
                            $user_id = $_SESSION['user_id'];
                            $tanggal = date('Y-m-d');
                            
                            // Gunakan parameterized query untuk keamanan
                            $komen = mysqli_prepare($conn, "INSERT INTO komentar (FotoID, UserID, IsiKomentar, TanggalKomentar) VALUES (?, ?, ?, ?)");
                            mysqli_stmt_bind_param($komen, "iiss", $foto_id, $user_id, $komentar, $tanggal);
                            mysqli_stmt_execute($komen);

                            // Periksa apakah penambahan komentar berhasil
                            if (mysqli_stmt_affected_rows($komen) > 0) {
                                header("Location: ?url=detail&&id=$foto_id");
                            } else {
                                echo "Gagal menambahkan komentar.";
                            }

                            mysqli_stmt_close($komen);
                        }
                    ?>

                    <form action="?url=detail" method="post">
                        <div class="form-grup d-flex flex-row">
                            <input type="hidden" name="foto_id" value="<?= $data['FotoID']?>">
                            <a href="?=home" class="btn btn-secondary">Kembali</a>
                            <?php if (isset($_SESSION['user_id'])):?>
                            <input type="text" name="komentar" class="form-control" placeholder="Masukkan Komentar...">
                            <input type="submit" value="Kirim" name="submit" class="btn btn-secondary">
                            <?php endif; ?> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <?php
                $komen=mysqli_query($conn, "SELECT * FROM komentar INNER JOIN user ON komentar.UserID=user.UserID INNER JOIN foto ON komentar.FotoID=foto.FotoID WHERE komentar.FotoID='$_GET[id]'");
                foreach($komen as $komens):
            ?>
            <p class="mb-0 fw-bold"><?= $komens['Username']?></p>
            <p class="mb-1"><?= $komens['IsiKomentar']?></p>
            <p class="text-mute small mb-0"><?= $komens['TanggalKomentar'] ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</div>