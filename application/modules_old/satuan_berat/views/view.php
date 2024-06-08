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
                    <a href="<?php echo site_url('satuan_berat/create_satuan_berat') ?>" class="btn btn-primary" type="button"><?php echo lang('button_label_add_satuan_berat');?></a>
                </div>
                <div class="ibox-content">
                    <?=getStatusFlash()?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo lang('view_satuan_berat_th');?></th>
                                    <th><?php echo lang('view_action_th');?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>