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
                <div class="ibox-title">
                    Edit Data Lokasi
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <div id="infoMessage"><?php echo $message;?></div>
                        <form action="<?=base_url()?>lokasi/update_lokasi" method="post">

                        <p>
                            <?php echo lang('create_lokasi_kecamatan_label', 'lokasi_kec');?> <br />
                            <input type="text" readonly value="<?=$item->kecamatan?>" class="form-control">
                            <?php echo form_dropdown('lokasi_kec', array(),'', array('class' => 'form-control select2Kec','style'=>"width:100%",'id'=>'lokasi_kec')); ?>
                        </p>
                        <p>
                            <?php echo lang('create_lokasi_kelurahan_label', 'lokasi_kel_des');?> <br />
                            <input type="text" readonly value="<?=$item->kelurahan?>" class="form-control">
                            <?php echo form_dropdown('lokasi_kel_des', array(),'', array('class' => 'form-control select2Kel','style'=>"width:100%",'id'=>'lokasi_kel')); ?>
                        </p>
                        <p>
                            <?php echo lang('create_lokasi_alamat_label', 'lokasi_alamat');?> <br />
                            <?php echo form_input($lokasi_alamat);?>
                        </p>
                        <p>
                            <?php echo lang('create_lokasi_lat_label', 'lokasi_lat');?> <br />
                            <?php echo form_input($lokasi_lat);?>
                        </p>
                        <p>
                            <?php echo lang('create_lokasi_long_label', 'lokasi_long');?> <br />
                            <?php echo form_input($lokasi_long);?>
                        </p>

                        <?php echo form_hidden('id', $item->id);?>

                        <p><?php echo form_submit('submit', "Simpan" ,array('class' => 'btn btn-primary'));?>
                        </p>

                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>