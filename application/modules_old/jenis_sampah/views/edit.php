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
            <div class="ibox ">`
                <div class="ibox-title">
                    Edit Data
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <div id="infoMessage"><?php echo $message;?></div>
                        <?php echo form_open(base_url().'jenis_sampah/update');?>

                        <p>
                            <?php echo "Nama Jenis";?> <br />
                            <?php echo form_input($nama_jenis);?>
                        </p>

                        <?php echo form_hidden('id', $item->id);?>

                        <p><?php echo form_submit('submit', "Ubah Data" ,array('class' => 'btn btn-primary'));?>
                        </p>

                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>