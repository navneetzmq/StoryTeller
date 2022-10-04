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
                    
                    <!-- form -->

                    <!-- <//?php var_dump($storyData); die();?> -->

                    <form method="POST" action="<?= base_url('CompanyAdminController/saveAssignedStory');?>">

                    <!-- Dropdown to select Staff using StaffId -->
                      
                    <div class="form-group">
                        <label for="">Select Trainer to assign Story</label>
                        <select id="staffId" name="staff" class="form-control">
                            <option selected>Select Employee</option>

                            <?php
                                if(isset($staffData) && !empty($staffData)){
                                    for($i = 0 ; $i < count($staffData); $i++) { ?>
                                        <?php if(isset($staffData[$i]->staffId)){ ?>
                                            <option value="<?= $staffData[$i]->staffId; ?>"><?= $staffData[$i]->name; ?>
                                    <?php }?>
                                            </option>
                                <?php }} ?>
                        </select>
                    </div>
                    <hr>

                    <!-- Table with ckeckboxes to select Multiple Stories to assign Trainer -->

                    <h4>Select One or Multiple Stories</h4>
                    <hr>
                    <div class="container">
                    <table id="example" class="table table-sm table-responsive table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Story Title</th>
                            <th>Story Type</th>
                            <th>Select</th>
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
                        echo "<td>"."Private"."</td>";
                    }
                ?>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" id="storyId" name="story" value="<?=$row->storyId;?>">
                        </div>
                    </td>
                </tr>
                <?php
                    $count++;
                }
      
                ?>
                </tbody>
            </table>
            <div class="col-auto float-right">  
            <button type="button" id="submitBtn" class="btn btn-primary mb-2" name="submit">Submit</button>
        </div>
    </form>
</div>
</div>
</body>
</html>

<script>

// To get story Id in an array
var all=[];

$("#submitBtn").on('click',function(){

    staffId = $('#staffId :selected').val();  //Gettng Select trainer Id
    
    console.log(staffId,all);

    $.ajax({
        url: "<?= base_url('CompanyAdminController/saveAssignedStory') ?>",
        type: 'POST',
        data: {
            trainerId : staffId,
            storyId : JSON.stringify(all),
        },
        success: function(data, textStatus, jqXHR) {
            window.location = "<?= base_url("assignStory"); ?>";
        }
    })
});

    // ---------- Pushing ckeckbox values in an array --------

$(document).on('change','input[type=checkbox]' ,function(){
    
    all=[];

    $('input[type=checkbox]:checked').each(function(){          

        all.push($(this).val());

    })
    
});

</script>
</html>