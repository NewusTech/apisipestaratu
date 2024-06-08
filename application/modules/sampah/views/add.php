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
                <strong><?php echo humanize($this->router->fetch_method()); ?></strong>
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
                    <?php echo "Tambah Sampah";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>

                    <?php echo form_open("sampah/create_sampah");?>

                    <p>
                        <?php echo lang('create_nama_sampah_label', 'nama_sampah');?> <br />
                        <?php echo form_input($nama_sampah);?>
                    </p>
                    <p>
                        <?php echo lang('create_nama_jenis_label', 'jenis_sampah_id');?> <br />
                        <?php echo form_dropdown('jenis_sampah_id', $data_jenis_sampah,'', array('class' => 'form-control')); ?>
                    </p>
                    <p>
                        <?php echo lang('create_nama_jenis_label', 'parent_id');?> <br />
                        <?php echo form_dropdown('parent_id', $data_sampah,'', array('class' => 'form-control')); ?>
                    </p>

                    <p><?php echo form_submit('submit', lang('create_sampah_submit_btn'), ['class' => 'btn btn-primary']);?></p>

                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>