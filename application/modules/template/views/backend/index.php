<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <?php if(!empty($this->ion_auth->user()->row()->avatar)): ?>
                                <img alt="image" class="rounded-circle" style="width:48px"src="<?php echo base_url('upload/user-photo/'.$this->ion_auth->user()->row()->avatar) ?>" />
                            <?php endif?>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold"><?php echo $this->ion_auth->user()->row()->first_name ?> <?php echo $this->ion_auth->user()->row()->last_name ?></span>
                                <span class="text-muted text-xs block"><?php echo  $this->ion_auth->get_users_groups($this->ion_auth->get_user_id())->row()->name ?> <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="<?php echo site_url('users/profile') ?>">Profile</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo site_url('auth/logout') ?>">Logout</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            SR
                        </div>
                    </li>
                    <li <?php echo (@$root_menu=='dashboard')?"class='active'":"" ?>>
                        <a href="<?php echo site_url('dashboard') ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li <?php echo (@$root_menu=='logbook')?"class='active'":"" ?>>
                        <a href="<?php echo site_url('logbook') ?>"><i class="fa fa-database"></i> <span class="nav-label"> Logbook</span></a>
                    </li>
                    <li <?php echo (@$root_menu=='lokasi')?"class='active'":"" ?>>
                        <a href="<?php echo site_url('lokasi') ?>"><i class="fa fa-map-marker"></i> <span class="nav-label"> Data Lokasi</span></a>
                    </li>
                    <li <?php echo (@$root_menu=='kelola_sampah')?"class='active'":"" ?>>
                        <a href="#"><i class="fa fa-folder"></i> <span class="nav-label"> Kelola Data Sampah</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse <?php (@$root_menu=='kelola_sampah')?"in":"" ?>" >
                            <li <?php echo (@$child_menu=='satuan_berat')?"class='active'":"" ?>><a href="<?php echo site_url('satuan_berat') ?>"> Satuan Berat Sampah</a></li>
                            <li <?php echo (@$child_menu=='jenis_sampah')?"class='active'":"" ?>><a href="<?php echo site_url('jenis_sampah') ?>"> Jenis Sampah</a></li>
                            <li <?php echo (@$child_menu=='sampah')?"class='active'":"" ?>><a href="<?php echo site_url('sampah') ?>"> Sampah</a></li>
                        </ul>
                    </li>
                    <li <?php echo (@$root_menu=='kelola_subjek')?"class='active'":"" ?>>
                        <a href="#"><i class="fa fa-building"></i> <span class="nav-label"> Kelola Data Subjek</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse <?php (@$root_menu=='kelola_subjek')?"in":"" ?>" >
                            <li <?php echo (@$child_menu=='subjek_tipe')?"class='active'":"" ?>><a href="<?php echo site_url('subjek_tipe') ?>"> Tipe Subjek</a></li>
                            <li <?php echo (@$child_menu=='subjek_kategori')?"class='active'":"" ?>><a href="<?php echo site_url('subjek_kategori') ?>"> Kategori Subjek</a></li>
                            <li <?php echo (@$child_menu=='subjek')?"class='active'":"" ?>><a href="<?php echo site_url('subjek') ?>"> Subjek</a></li>
                        </ul>
                    </li>
                    <li <?php echo (@$root_menu=='kelola_profil')?"class='active'":"" ?>>
                        <a href="#"><i class="fa fa-drivers-license-o"></i> <span class="nav-label"> Kelola Data Profil</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse <?php (@$root_menu=='kelola_profil')?"in":"" ?>" >
                            <li <?php echo (@$child_menu=='profil_item')?"class='active'":"" ?>><a href="<?php echo site_url('profil_item') ?>"> Profil Item</a></li>
                            <li <?php echo (@$child_menu=='profil_group')?"class='active'":"" ?>><a href="<?php echo site_url('profil_group') ?>"> Profil Group</a></li>
                            <li <?php echo (@$child_menu=='user_profil')?"class='active'":"" ?>><a href="<?php echo site_url('user_profil') ?>"> Profil User</a></li>
                        </ul>
                    </li>

                    <li <?php echo (@$root_menu=='kelola_user')?"class='active'":"" ?>>
                        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Kelola User</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse  <?php echo (@$root_menu=='kelola_user')?"in":"" ?>">
                            <li <?php echo (@$child_menu=='user')?"class='active'":"" ?>><a href="<?php echo site_url('users') ?>"> Users</a></li>
                            <li <?php echo (@$child_menu=='group')?"class='active'":"" ?>><a href="<?php echo site_url('users_groups') ?>"> Groups</a></li>
                        </ul>
                    </li>

                    <li  <?php echo (@$root_menu=='pengaturan')?"class='active'":"" ?>>
                        <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Pengaturan</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse  <?php echo (@$root_menu=='pengaturan')?"in":"" ?>">
                            <li <?php echo (@$child_menu=='pengaturan_web')?"class='active'":"" ?>><a href="<?php echo site_url('pengaturan_web') ?>"> Pengaturan Web</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="<?php echo site_url('auth/logout') ?>">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php $this->load->view($content);?>
            <div class="footer">
                <div>
                    <strong>Copyright</strong> GINK-TECH &copy; 2013-<?php echo date('Y') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo theme_assets('inspina') ?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo theme_assets('inspina') ?>js/popper.min.js"></script>
    <script src="<?php echo theme_assets('inspina') ?>js/bootstrap.js"></script>
    <script src="<?php echo theme_assets('inspina') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo theme_assets('inspina') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo theme_assets('inspina') ?>js/inspinia.js"></script>
    <script src="<?php echo theme_assets('inspina') ?>js/plugins/pace/pace.min.js"></script>

    <!-- Load JS Library  -->
    <?php if(isset($footer) && !empty($footer)): ?>
        <?php foreach($footer as $footer): ?>
            <script src="<?php echo $footer?>"></script>
        <?php endforeach ?>
    <?php endif ?>
    <!-- Load JS SCRIPTPAGE  -->
    <?php if(isset($js_script) && !empty($js_script)): ?>
        <?php $this->load->view($js_script);?>
    <?php endif ?>
    <?php if(isset($c_script) && !empty($c_script)): ?>
        <?php $this->load->view($c_script);?>
    <?php endif ?>
</body>

</html>