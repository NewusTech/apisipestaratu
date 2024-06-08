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
                        <?php echo form_open(base_url().'sampah/update');?>

                        <p>
                            <?php echo lang('create_nama_sampah_label', 'nama_sampah');?> <br />
                            <?php echo form_input($nama_sampah);?>
                        </p>
                        <p>
                            <?php echo lang('create_nama_jenis_label', 'jenis_sampah_id');?> <br />
                            <select name="jenis_sampah_id" class="form-control" required>
                                <option value="">Pilih Data</option>
                                <?php foreach($jenis_sampah as $it) { ?>
                                <option value="<?=$it->id?>" <?=($item->jenis_sampah_id==$it->id)?'selected':''?>><?=$it->nama_jenis?></option>
                                <?php }?>
                            </select>
                        </p>
                        <p>
                            <?php echo lang('create_nama_jenis_label', 'parent_id');?> <br />
                            <select name="parent_id" id="parent_id" class="form-control" required>
                                <option value=""></option>
                                <option value="0" <?=($item->parent_id=="0")?'selected':''?>>Sebagai Parent</option>
                                <?php foreach($sampah as $it) { ?>
                                <option value="<?=$it->id?>" <?=($it->id==$item->parent_id)?'selected':''?>><?=$it->nama_sampah?></option>
                                <?php }?>
                            </select>
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