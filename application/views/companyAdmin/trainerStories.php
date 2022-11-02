<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Assign Stories to Trainer</li>
                </ol>
            </nav>
            <div class="col-md-9 mx-auto">
                <?php if($this->session->flashdata('add_company_admin')) { ?>
    	        <?php echo '<p class="alert alert-success mt-3 text-center" id="add">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>' 
                .$this->session->flashdata('add_company_admin') . '</p>'; ?>
	  	        <?php } $this->session->unset_userdata('add_company_admin');  //unset session ?>

                <div class="card">
                    <div class="card-body">
                    
                    <!-- <//?php var_dump($storyData)?> -->

                    <!-- form -->

                    <!-- <//?php var_dump($storyData); die();?> -->
                    

                    <form method="POST" action="<?= base_url('CompanyAdminController/saveAssignedStory');?>">

                    <!-- Table with ckeckboxes to select Multiple Stories to assign Trainer -->

                    <h4>Available Stories</h4>
                    <hr>
                    <div class="container">
                    <table id="example" class="table table-sm table-responsive table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Story Title</th>
                            <th>Story Type</th>
                        </tr>
                    </thead>
                <tbody>
            
                <!-- Getting Story data into the table -->

                <?php
                $count = 1;
                foreach($storyData as $row){
                //   for(var $i=0; $i < count($staff); $i++ ) {  

                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>".$row->storyTitle."</td>";

                    if(($row->isPublic) == '1'){
                        echo "<td>"."Public"."</td>";
                    }
                    else{
                        echo "<td>"."Assigned"."</td>";
                    }
                ?>
                </tr>
                <?php
                    $count++;
                }
      
                ?>
                </tbody>
            </table>
        </div>
    </form>
</div>
</div>
</body>
</html>