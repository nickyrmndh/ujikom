<div class="container my-4 p-5 bg-hero rounded">
    <div class="py-5 text-white">
        <p class="display-5 fw-bold">Selamat Datang Di Gallery Foto</p>
        <p class="fs-5 col-md-8">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut saepe laborum neque facere repudiandae eveniet vitae quaerat culpa similique amet.</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php 
        $tampil=mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.UserID=user.UserID");
        foreach($tampil as $tampils):
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card">
                <img src="uploads/<?= $tampils['NamaFile'] ?>" class="object-fit-cover" style="aspect_rasio: 16/9" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $tampils['JudulFoto'] ?></h5>
                    <p class="card-text text-muted">by:<?= $tampils['Username'] ?></p>
                    <a href="?url=detail&&id=<?= $tampils['FotoID'] ?>" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>