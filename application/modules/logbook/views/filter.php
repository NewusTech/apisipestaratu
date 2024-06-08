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
        <div class="col-lg-6">
            <div class="ibox success">
                <div class="ibox-title">
                    <h4>Filter Data</h4>
                </div>
                <div class="ibox-content">
                    <form action="<?=base_url()?>logbook/filter" method="get">
                    <div class="form-group">
                        <label for="">Kabupaten</label>
                        <input type="text" class="form-control" readonly value="<?php 

                            echo (!empty(getPengaturanIdentitas())) ? getPengaturanIdentitas()->kabupaten_kota :"Pengaturan Identitas Belum diisi";
                        
                        ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Kecamatan</label>
                        <select id="lokasi_kec" name="kecamatan" required class="form-control select2Kabupaten"></select>
                    </div>
                    <div class="form-group">
                        <label for="">Subjek</label>
                        <select id="" name="subjek" required class="form-control select2">
                            <option value="">Pilih Subjek</option>
                            <option value="all">Semua Subjek</option>
                            <?php foreach($subjek as $s) { ?>
                            <option value="<?=$s->id?>"><?=$s->nama?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-filter"></i> Filter</button>
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
                    <h4>Filter Data Laporan</h4>
                </div>
                <div class="ibox-content">
                <?=getStatusFlash()?>

                    <div class="alert alert-info">
                        <h5>Hasil Pencarian dari</h5>
                        <ul>
                                <?php if($namakabupaten!='') { ?>
                                <li><?=$namakabupaten?></li>
                                <?php }?>
                                <?php if($namakecamatan!='') { ?>
                                <li><?=$namakecamatan?></li>
                                <?php }?>
                                <?php if($namasubjek!='') { ?>
                                <li><?=$namasubjek?></li>
                                <?php }?>
                        </ul>
                    </div>                
                
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="datatable2">
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
                                <?php foreach($filter as $key => $fil) { ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$fil->judul?></td>
                                    <td><?=$fil->user?></td>
                                    <td><?=$fil->nama?></td>
                                    <td><?=$fil->tanggal?></td>
                                    <td>
                                    <?php 
                                     $button = "<div class='btn-group'>";
                                     $button .= "<a class='btn btn-info btn-sm' href='".base_url()."logbook/detail/".$fil->id."'>Detail</a>";
                                     $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."logbook/delete/".$fil->id."'>Delete</a>";
                                     $button .= "</div>";
                                     echo $button;
                                    ?>
                                    </td>
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
