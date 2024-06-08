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
                    <?php echo form_open("user_profil/create_user_profil");?>
                    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <?php echo "Pemilihan Lokasi";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>

                    <p>
                        <?php echo lang('create_lokasi_provinsi_label', 'lokasi_provinsi');?> <br />
                        <?php echo form_dropdown('lokasi_provinsi', array(),'', array('class' => 'form-control select2Provinsi','style'=>"width:100%")); ?>
                    </p>
                    <p>
                        <?php echo lang('create_lokasi_kab_kota_label', 'lokasi_kab_kota');?> <br />
                        <?php echo form_dropdown('lokasi_kab_kota', array(),'', array('class' => 'form-control select2Kab','style'=>"width:100%",'id'=>'lokasi_kab_kota')); ?>
                    </p>
                    <p>
                        <?php echo lang('create_lokasi_kecamatan_label', 'lokasi_kec');?> <br />
                        <?php echo form_dropdown('lokasi_kec', array(),'', array('class' => 'form-control select2Kec','style'=>"width:100%",'id'=>'lokasi_kec')); ?>
                    </p>
                    <p>
                        <?php echo lang('create_lokasi_kelurahan_label', 'lokasi_kel_des');?> <br />
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

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <?php echo "Identitas Login";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>


                    <p>
                        <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                        <?php echo form_input($first_name);?>
                    </p>

                    <p>
                        <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                        <?php echo form_input($last_name);?>
                    </p>

                    <?php
                        if($identity_column!=='email') {
                            echo '<p>';
                            echo lang('create_user_identity_label', 'identity');
                            echo '<br />';
                            echo form_error('identity');
                            echo form_input($identity);
                            echo '</p>';
                        }
                        ?>

                    <p>
                        <?php echo lang('create_user_email_label', 'email');?> <br />
                        <?php echo form_input($email);?>
                    </p>

                    <button onclick="setPasswordDefault()" type="button" class='btn btn-primary pull-right'>Gunakan Password Default (12345678)</button>
                    <p>
                        <?php echo lang('create_user_password_label', 'password');?> <br />
                        <?php echo form_input($password);?>
                    </p>

                    <p>
                        <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                        <?php echo form_input($password_confirm);?>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <?php echo "Pemilihan Subjek";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>
                   
                    <p>
                        <?php echo lang('create_subjek_id_label', 'subjek_id');?> <br />
                        <?php echo form_dropdown('subjek_id', $data_subjek,'', array('class' => 'form-control select2','required'=>'required','style'=>"width:100%")); ?>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <?php echo "Pemilihan Group";?>
                </div>
                <div class="ibox-content">
                    <p><?php echo "Silahkan isi data dibawah ini.";?></p>

                    <div id="infoMessage"><?php echo $message;?></div>
                   
                    <p>
                        <?php echo "Pilih Profil Group";?> <br />
                        <?php echo form_dropdown('group_id', $data_group,'', array('class' => 'form-control select2','required'=>'required','style'=>"width:100%")); ?>
                    </p>

                    <p><?php echo form_submit('submit', lang('create_profil_user_submit_btn'), ['class' => 'btn btn-primary']);?></p>

                </div>
            </div>
        </div>
    </div>
                    <?php echo form_close();?>
</div>