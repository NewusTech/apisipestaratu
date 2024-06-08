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
        <div class="col-lg-8">
            <div class="ibox ">
                <div class="ibox-title">
                    <?php echo "Tambah Profil Item";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>

                    <?php echo form_open("user_profil/create_profil_item");?>
                    <input  type="hidden" name="idP" value="<?=$this->uri->segment(3)?>">
                    <p>
                        <?php echo lang('create_profil_group_item_profil_item_label', 'profil_item_id');?> <br />
                        <?php echo form_dropdown('profile_item_id', $data_profil_item,'', array('class' => 'form-control', 'required'=>'required')); ?>
                    </p>
                    <p>
                        <?php echo "Label";?> <br />
                        <input type="text" name="label" required="required" class="form-control">
                    </p>
                    <p>
                        <?php echo lang('create_profile_item_value_label', 'profile_item_value');?> <br />
                        <?php echo form_input($profile_item_value,'', array('required' => 'required'));?>
                    </p>
                    <p>
                        <?php echo form_input($user_profile_id,'', array('required' => 'required'));?>
                    </p>

                    <p><?php echo form_submit('submit', lang('create_user_profile_item_submit_btn'), ['class' => 'btn btn-primary']);?></p>

                    <?php echo form_close();?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <?php echo "Detail User Profil";?>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <u>Lokasi</u><br>
                            <label for="">Provinsi : <?=$detail_user->provinsi?></label><br>
                            <label for="">Kabupaten : <?=$detail_user->kabupaten_kota?></label><br>
                            <label for="">Kecamatan : <?=$detail_user->kecamatan?></label><br>
                            <label for="">Kelurahan : <?=$detail_user->kelurahan?></label>
                            <br>
                            <u>Identitas User</u><br>
                            <label for="">Nama : <?=$detail_user->first_name.' '.$detail_user->last_name?></label><br>
                            <u>Subjek</u><br>
                            <label for=""><?=$detail_user->nama?></label>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-lg-12">
        <div class="row">
            
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <?php echo "Data Saat Ini";?>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Urutan</th>
                                    <th>Item</th>
                                    <th>Label</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($data_item as $di) { ?>
                                <tr>
                                    <td><?=$di->profile_item_order?></td>
                                    <td><?=$di->label?></td>
                                    <td><?=$di->profile_item?></td>
                                    <td>
                                    
                                    <form action="<?=base_url()?>user_profil/update_profil_item" method="post">
                                    <input type="hidden" name="idP" value="<?=$this->uri->segment(3)?>">
                                    <input type="hidden" name="id_item" value="<?=$di->id?>">
                                    <div class="input-group mb-3">
                                    <input class="form-control" name="value_item" required type="text" value="<?=$di->profile_item_value?>">
                                            <div class="input-group-append">
                                                <button type="submit" class="input-group-text btn-primary">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </div>
                                            </div>


                                    </form>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Hapus data ini?')" href="<?=base_url()?>user_profil/delete_item/<?=$di->id?>/<?=$di->user_profile_id?>" class="btn btn-danger btn-xs">Delete</a>
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
    </div>
</div>