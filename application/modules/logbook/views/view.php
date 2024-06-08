<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo humanize($this->router->fetch_module()); ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('/') ?>">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a><?php echo humanize($this->router->fetch_module()); ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $this->router->fetch_method(); ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInLeft">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox success">
                <div class="ibox-title">
                    <h4>Filter Data</h4>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" action="<?=base_url()?>logbook/filter" method="get">
                        <div class="form-group row">
                            <div class="col-3">
                                <input type="text" class="form-control" readonly value="<?php 

                            echo (!empty(getPengaturanIdentitas())) ? getPengaturanIdentitas()->kabupaten_kota :"Pengaturan Identitas Belum diisi";
                        
                        ?>">
                            </div>
                            <label for="text" class="col-1 col-form-label">Kecamatan</label>
                            <div class="col-3">
                                <select id="lokasi_kec" name="kecamatan" required
                                    class="form-control select2Kabupaten"></select>
                            </div>
                            <label for="text" class="col-1 col-form-label">Subjek</label>
                            <div class="col-3">
                                <select id="" name="subjek" required class="form-control select2">
                                    <option value="all">Semua Subjek</option>
                                    <?php foreach($subjek as $s) { ?>
                                    <option value="<?=$s->id?>"><?=$s->nama?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-1">
                                <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i>
                                    Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4>Data Laporan</h4>
                    <div class="pull-right">
                        <button class="btn btn-primary" data-target="#modalPrintDetail" data-toggle="modal"><i class="fa fa-print"></i> Export Data Detail</button>
                        <button class="btn btn-primary" data-target="#modalPrint" data-toggle="modal"><i class="fa fa-print"></i> Export Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <?=getStatusFlash()?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Judul Laporan</th>
                                    <th>Pengguna</th>
                                    <th>Subjek</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalPrint" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="<?=base_url()?>logbook/report" method="post">
            <div class="form-group">
                <label for="text" class="form-label">Kecamatan</label>
                <select name="kecamatan" required class="form-control">
                    <option value="all">Semua Kecamatan</option>
                    <?php foreach($kecamatan as $k) { ?>
                        <option value="<?=$k->id?>"><?=$k->kecamatan?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="text" class="col-1 col-form-label">Subjek</label>
                <select id="" name="subjek" required class="form-control select2">
                    <option value="all">Semua Subjek</option>
                    <?php foreach($subjek as $s) { ?>
                    <option value="<?=$s->id?>"><?=$s->nama?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="text" class="form-label">Dari Tanggal</label>
                <input type="text" autocomplete="off" name="dari" required class="form-control datepicker">
            </div>
            <div class="form-group">
                <label for="text" class="form-label">Sampai Tanggal</label>
                <input type="text" autocomplete="off" name="sampai" required class="form-control datepicker">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Cetak</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="modalPrintDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="<?=base_url()?>logbook/report_detail" method="post">
            <div class="form-group">
                <label for="text" class="form-label">Kecamatan</label>
                <select name="kecamatan" required class="form-control">
                    <option value="all">Semua Kecamatan</option>
                    <?php foreach($kecamatan as $k) { ?>
                        <option value="<?=$k->id?>"><?=$k->kecamatan?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="text" class="col-1 col-form-label">Subjek</label>
                <select id="" name="subjek" required class="form-control select2">
                    <option value="all">Semua Subjek</option>
                    <?php foreach($subjek as $s) { ?>
                    <option value="<?=$s->id?>"><?=$s->nama?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="text" class="form-label">Dari Tanggal</label>
                <input type="text" autocomplete="off" name="dari" required class="form-control datepicker">
            </div>
            <div class="form-group">
                <label for="text" class="form-label">Sampai Tanggal</label>
                <input type="text" autocomplete="off" name="sampai" required class="form-control datepicker">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Cetak</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>