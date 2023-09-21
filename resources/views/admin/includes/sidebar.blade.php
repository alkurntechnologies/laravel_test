
<div  class="top-secret">
    <aside id="main-sidebar" class="main-sidebar sidebar-dark-primary elevation-4 sidebarSmal">
        <!-- Brand Logo -->
        <a href="{{url('/')}}" class="brand-link">
            {{-- <img loading="lazy" src="{{asset('/assets/admin/img/AdminLTELogo.png')}}" class="brand-image img-circle elevation-3"
                style="opacity: .8"> --}}
            <span class="brand-text font-weight-light">{{config('app.name')}} | Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">

                    <?php
                    if(Auth::check() && Auth::guard('admin')->check() && (Auth::User()->profile_pic == '' || Auth::User()->profile_pic == null))
                        $src = URL::asset('/')."/assets/admin/img/default-profile-pic.png";
                    else
                        $src = URL::to('storage/app')."/".Auth::User()->profile_pic;
                    ?>

                    <img loading="lazy" src="<?php echo ($src); ?>" class="img-circle elevation-2" id="adminProfileImgSidebar">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ ucfirst(Auth::User()->name)}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                    <li class="nav-item has-treeview">
                        <a href="{{URL::to('admin')}}" class="nav-link {{ (Request::segment(1) === 'admin' && Request::segment(2) === '' ) ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @can('Users-view')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>

                            <p>
                                Manage Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-buyers')}}" class="nav-link {{ URL::to('admin/manage-buyers') == url()->current() || URL::to('admin/add-buyer') == url()->current() || URL::to('admin/edit-buyer').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}">
                                <i class="fas fa-user-alt"></i> 
                                    <p>Manage User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <p>
                            Products
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Products-view')
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-product-management')}}"  class="nav-link {{ URL::to('admin/manage-product-management') == url()->current() || URL::to('admin/edit-product').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}" >
                                <i class="fas fa-user-alt"></i> 
                                    <p>Products</p>
                                </a>
                            </li>
                            @endcan
                            @can('Products-create')
                            <li class="nav-item">
                                <a href="{{URL::to('admin/add-product')}}" class="nav-link {{ URL::to('admin/add-product') == url()->current() ? 'active' : ' ' }}">
                                <i class="fas fa-user-alt"></i> 
                                    <p>Add New Product</p>
                                </a>
                            </li>
                            @endcan
                        </ul>    
                    </li>
                    @can('Roles-view')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <p>
                            Roles
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{URL::to('admin/manage-roles')}}"  class="nav-link {{ URL::to('admin/manage-roles') == url()->current() || URL::to('admin/edit-role').'/'.collect(request()->segments())->last() == url()->current() ? 'active' : ' ' }}" >
                                <i class="fas fa-user-alt"></i> 
                                    <p>Roles</p>
                                </a>
                            </li>
                        </ul>    
                    </li>
                    @endcan
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</div>


<script>
$(document).ready(function(){
    if ($('.nav-treeview li a.nav-link').hasClass('active')) {
        $('.nav-treeview li a.nav-link.active').parent().parent().parent().addClass('menu-open');
    }
});


</script>