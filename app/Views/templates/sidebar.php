<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="<?php echo base_url('themes/dist'); ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Yuda Pratama</span>
    </a>
 
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block"><?= session()->get('USERNAME'); ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url('/'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/mesinfotocopy" class="nav-link">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Mesin Fotocopy</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/peramalan" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>Peramalan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/perusahaan" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Perusahaan</p>
                    </a>
                </li>
                <li class="nav-header">ACCOUNT</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('login/logout'); ?>" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>