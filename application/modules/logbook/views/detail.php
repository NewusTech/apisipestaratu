<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo humanize($this->router->fetch_module()); ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('/') ?>">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('/logbook') ?>"><?php echo humanize($this->router->fetch_module()); ?></a>
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
                    <h4>Detail Laporan</h4>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Identitas Laporan</h4>
                            <ul class="todo-list m-t ui-sortable">
                                <li>
                                    <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" value="" name="" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    <span class="m-l-xs">Judul : <?=@$parent->judul?></span>
                                </li>
                                <li>
                                    <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" value="" name="" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    <span class="m-l-xs">Pelapor : <?=@$parent->user?>.</span>
                                </li>
                                <li>
                                    <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" value="" name="" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    <span class="m-l-xs">Tanggal Laporan : <?=@humanizeDate($parent->tanggal)?>.</span>
                                </li>
                                <li>
                                    <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" value="" name="" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    <span class="m-l-xs">Kabupaten : <?=@$parent->kabupaten_kota?>.</span>
                                </li>
                                <li>
                                    <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" value="" name="" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    <span class="m-l-xs">Kecamatan : <?=@$parent->kecamatan?>.</span>
                                </li>
                                <li>
                                    <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" value="" name="" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    <span class="m-l-xs">Kelurahan : <?=@$parent->kelurahan?>.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <h4>Item Laporan</h4>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Group</th>
                                        <th>Sampah</th>
                                        <th>Jenis Sampah</th>
                                        <th>Jumlah</th>
                                    </tr>
                                    <?php foreach($item as $key => $it) { ?>
                                        <tr>
                                            <td><?=$key=+1?></td>
                                            <td><?=$it->logbook_group?></td>
                                            <td><?=$it->nama_sampah?></td>
                                            <td><?=$it->nama_jenis?></td>
                                            <td><?=$it->jumlah." ".$it->satuan_berat?></td>
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


<script>
window.onbeforeunload = function (e) {
                var message = "Are you sure ?";
                var firefox = /Firefox[\/\s](\d+)/.test(navigator.userAgent);
                if (firefox) {
                    //Add custom dialog
                    //Firefox does not accept window.showModalDialog(), window.alert(), window.confirm(), and window.prompt() furthermore
                    var dialog = document.createElement("div");
                    document.body.appendChild(dialog);
                    dialog.id = "dialog";
                    dialog.style.visibility = "hidden";
                    dialog.innerHTML = message;
                    var left = document.body.clientWidth / 2 - dialog.clientWidth / 2;
                    dialog.style.left = left + "px";
                    dialog.style.visibility = "visible";
                    var shadow = document.createElement("div");
                    document.body.appendChild(shadow);
                    shadow.id = "shadow";
                    //tip with setTimeout
                    setTimeout(function () {
                        document.body.removeChild(document.getElementById("dialog"));
                        document.body.removeChild(document.getElementById("shadow"));
                    }, 0);
                }
                return message;
            };
</script>