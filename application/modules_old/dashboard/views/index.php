<div class="row  border-bottom white-bg dashboard-header">

    <div class="col-md-12">
        <h2>Selamat Datang</h2>
        <small>SIPESTA RATU Dinas Lingkungan Hidup Tanggamus</small>
    </div>

</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox ">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <span class="label label-primary float-right">Bulan ini</span>
                    </div>
                    <h5>Timbulan Sampah</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$timbulan?></h1>
                    <small>Total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox ">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <span class="label label-success float-right">Bulan ini</span>
                    </div>
                    <h5>Pemanfaatan Sampah</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$manfaat?></h1>
                    <small>Total pemanfaatan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox ">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <span class="label label-info float-right">Bulan ini</span>
                    </div>
                    <h5>Tidak termanfaatkan</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$mubadzir?></h1>
                    <small>Total tidak termanfaatan</small>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Pengelolaan berdasarkan lokasi (Timbulan)</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content table-responsive">
                            <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>Lokasi</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datalokasitimbulan as $dl) { ?>
                                    <tr>
                                        <th><?=$dl->kecamatan?></th>
                                        <th><?=$dl->jumlah?></th>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Pengelolaan berdasarkan lokasi (Termanfaatkan)</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content table-responsive">
                            <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>Lokasi</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datalokasimanfaat as $dl) { ?>
                                    <tr>
                                        <th><?=$dl->kecamatan?></th>
                                        <th><?=$dl->jumlah?></th>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Pengelolaan berdasarkan lokasi (Tidak Termanfaatkan)</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content table-responsive">
                            <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>Lokasi</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datalokasimubadzir as $dl) { ?>
                                    <tr>
                                        <th><?=$dl->kecamatan?></th>
                                        <th><?=$dl->jumlah?></th>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>