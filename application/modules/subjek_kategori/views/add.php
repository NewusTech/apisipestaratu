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
                    <?php echo "Tambah Subjek Kategori";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>

                    <?php echo form_open("subjek_kategori/create_subjek_kategori");?>

                    <p>
                        <?php echo lang('create_subjek_kategori_label', 'subjek_kategori');?> <br />
                        <?php echo form_input($subjek_kategori);?>
                    </p>

                    <p>
                        <?php echo lang('create_subjek_tipe_id_label', 'subjek_tipe_id');?> <br />
                        <?php echo form_dropdown('subjek_tipe_id', $data_tipe,'', array('class' => 'form-control')); ?>
                    </p>

                    <p><?php echo form_submit('submit', lang('create_subjek_kategori_submit_btn'), ['class' => 'btn btn-primary']);?></p>

                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>