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
                    Profil Group Item
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <div id="infoMessage"><?php echo $message;?></div>
                        <?php echo form_open(base_url().'profil_group/simpan_item');?>

                        <p>
                            <?php echo lang('create_profil_group_item_profil_group_label', 'profil_group_id');?> <br />
                            <input name="profil_group" id="" value="<?=$item->profile_group_nama?>" class="form-control" readonly>
                        </p>

                        <p>
                            <?php echo lang('create_profil_group_item_profil_item_label', 'profil_item_id');?> <br />
                            <?php echo form_dropdown('profile_item_id', $data_profil_item,'', array('class' => 'form-control', 'required'=>'required')); ?>
                        </p>

                        <?php echo form_hidden('id', $item->id);?>

                        <p><?php echo form_submit('submit', "Tambah Data" ,array('class' => 'btn btn-primary'));?>
                        </p>

                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    Data Profil Group Item
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th><?php echo lang('view_profil_group_item_profil_item_th');?></th>
                                <th><?php echo lang('view_action_th');?></th>
                            </tr>
                            <?php foreach($item_data as $key => $id) { ?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td><?=$id->profile_item?></td>
                                <td>
                                    <a onclick="return confirm('Hapus data ini?')" href="<?=base_url()?>profil_group/hapus_item/<?=$id->id?>/<?=$item->id?>" class="btn btn-danger btn-sm">delete</a>
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>