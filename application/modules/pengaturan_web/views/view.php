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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <form action="<?=base_url()?>pengaturan_web/simpan" method="POST">
                <div class="ibox-content">
                    <div class="form-group">
                        <label for="">Nama Dinas</label>
                        <input name="nama_dinas" required type="text" value="<?=@$identitas->nama_dinas?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea name="alamat" type="text" value="" class="form-control">
                        <?=@$identitas->alamat?>
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="">No Telepon</label>
                        <input type="text" name="telpon" required value="<?=@$identitas->telpon?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Provinsi</label>
                        <input readonly type="text" value="<?=loadProvinsi(@$identitas->provinsi)?>" class="form-control">
                        <select name="provinsi" id="" required class="form-control select2Provinsi">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kabupaten</label>
                        <input readonly type="text" value="<?=loadKabupaten(@$identitas->kabupaten)?>" class="form-control">
                        <select name="kabupaten" required id="lokasi_kab_kota" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>