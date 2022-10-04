<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/adminAssets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/adminAssets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <?php 
            
        $userData = $this->session->userdata('userData');
        // var_dump($userData);

    ?>

</head>

<body id="page-top">
    
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar bg-gradient-primary sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3">Story Teller</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - SuperAdmin Menu - Company Setup -->
            <?php
         
                if (isset($userData['level'])){
                    if($userData['level'] == '0') {
            
            ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_company"
                    aria-expanded="true" aria-controls="collapse_company">
                    <span>Comapny Setup</span>
                </a>
                <div id="collapse_company" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('createCompany');?>">Create Company</a>
                    </div>
                </div>
            <?php
                } }
            ?>
            </li>

           <!-- Nav Item - SuperAdmin Menu - View company list -->
           <?php
         
                if (isset($userData['level'])){
                    if($userData['level'] == '0') {

            ?>
             <li class="nav-item">
                <a class="nav-link" href="<?= base_url('company'); ?>">
                    <span>Company List</span>
                </a>
            </li>
            <?php
                } }
            ?> 

            <!-- Nav Item - Content level-1 & level-2 -->

            <?php
         
                if (isset($userData['level'])){
                    if($userData['level'] == '1' || $userData['level'] == '2') {
            
            ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_company"
                            aria-expanded="true" aria-controls="collapse_company">
                            <span>Content</span>
                        </a>
                        <div id="collapse_company" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="<?= base_url('createStory');?>">Create Story</a>
                            </div>
                        </div>
                        <div id="collapse_company" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="<?= base_url('createQuestion');?>">Create Question</a>
                            </div>
                        </div>
                    </li>
            <?php
                } }
            ?>

        <!-- Nav Item - Company Admin Menu - View Available Stories -->

        <?php
         
            if (isset($userData['level'])){
                if($userData['level'] == '3') { 

        ?>
        <li class="nav-item">
                <a class="nav-link" href="<?= base_url('stories'); ?>">
                <span>Available Stories</span>
                </a>
            </li>
        <?php
            } }
        ?> 
        </li>

        <!-- Nav Item - Comapny Admin Menu - View Staff details -->

        <?php
         
        if (isset($userData['level'])){
            if($userData['level'] == '1') {
        ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_staff"
                        aria-expanded="true" aria-controls="collapse_company">
                        <span>Staff</span>
                    </a>
                    <div id="collapse_staff" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?= base_url('createStaff');?>">Add Staff</a>
                        </div>
                    </div>
                    <div id="collapse_staff" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?= base_url('staff');?>">Staff Details</a>
                        </div>
                    </div>         
                    <div id="collapse_staff" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?= base_url('assignStory');?>">Assign Story</a>
                        </div>
                    </div>
                    <div id="collapse_staff" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="">Add Designation</a>
                        </div>
                    </div>
                </li>
        <?php
            }
        }
        ?>

        <!-- ----- Reporting ---- -->
        <?php
         
            if(isset($userData['level'])){
                if($userData['level'] == '1') {
         ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_reporting"
                            aria-expanded="true" aria-controls="collapse_company">
                            <span>Reporting</span>
                        </a>
                        <div id="collapse_reporting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="<?= base_url('');?>">Reporting</a>
                            </div>
                        </div>
                    </li>
        <?php
                }
            }
        ?>

        <!-- Nav Item - Comapny Trainer level-3 - Add Audience data -->
        
        <?php
         
        if (isset($userData['level'])){
            if($userData['level'] == '3') {
        ?>
            <li class="nav-item">
            <a class="nav-link" href="<?= base_url('audience'); ?>">
            <span>Collect Audience Info</span>
            </a>
        </li>
        <?php
            } }
        ?>
        </ul>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->

                        <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                                       
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        
                        <li class="nav-item dropdown no-arrow">

                        <!-- Super Admin Logout -->
                        
                        <?php 
                            $userData = $this->session->userdata('userData');
                     
                            if(isset($userData['level'])){
                                if ($userData['level'] == '0') {
                        ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Super Admin
                                | <?php print_r($userData['loginId']); ?> </span>
                                
                            </a>
                            <? }} ?>

                            <!-- Company Admin Logout -->

                            <?php if(isset($userData['level'])){
                                if ($userData['level'] == '1') {
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> 
                                Company Admin 
                                | <?php print_r($userData['loginId']); ?> </span>
                                
                            </a>
                            <?php 
                                }}
                            ?>

                            <!-- Content Writer Logout -->

                            <?php if(isset($userData['level'])){
                                if ($userData['level'] == '2') {
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Content Writer
                                | <?php print_r($userData['loginId']); ?> </span>
                            </a>
                            <?php }} ?>

                            <!-- Trainer Logout -->

                            <?php if(isset($userData['level'])){
                                if ($userData['level'] == '3') {
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Trainer  
                                | <?php print_r($userData['loginId']); ?> </span>
                            </a>
                            <?php }} ?>


                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">   
                                <?php 
                                    $userData = $this->session->userdata('userData');
                                // print_r($userData);
                                if(isset($userData['level'])){
                                if ( $userData['level'] == '0' || $userData['level'] == '1' || $userData['level'] == '2' || $userData['level'] == '3') {
                                    ?>
                                    <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                        -> Logout
                                    </a>  
                                <?php } } ?> 
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/adminAssets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/adminAssets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/adminAssets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/adminAssets/js/sb-admin-2.min.js'); ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/adminAssets/vendor/chart.js/Chart.min.js'); ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/adminAssets/js/demo/chart-area-demo.js'); ?>"></script>
    <script src="<?= base_url('assets/adminAssets/js/demo/chart-pie-demo.js'); ?>"></script>

</body>

</html>