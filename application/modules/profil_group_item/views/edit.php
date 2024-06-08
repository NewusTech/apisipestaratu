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
                        <?php echo form_open(base_url().'profil_group_item/update');?>

                        <p>
                            <?php echo "Profil Group";?> <br />
                            <select name="profile_group_id" required="required" id="" class="form-control">
                                <option value="">Pilih Data</option>
                                <?php foreach($profile_group as $st) { ?>
                                <option <?=($st->id==$item->profile_group_id)?'selected':''?> value="<?=$st->id?>"><?=$st->profile_group_nama?></option>
                                <?php }?>
                            </select>
                        </p>

                        <p>
                            <?php echo "Profil Group Item";?> <br />
                            <select name="profile_item_id" required="required" id="" class="form-control">
                                <option value="">Pilih Data</option>
                                <?php foreach($profile_item as $st) { ?>
                                <option <?=($st->id==$item->profile_item_id)?'selected':''?> value="<?=$st->id?>"><?=$st->profile_item?></option>
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