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

                    <!-- <//?php var_dump(count($storyData));?> -->

                    <form method="POST" action="<?= base_url('CompanyAdminController/saveAssignedStory');?>">

                    <!-- Dropdown to select Staff using StaffId -->
                      
                    <div class="form-group">
                        <label for="">Select Trainer to assign Story</label>
                        <select id="staffId" name="staff" class="form-control">
                            <option selected disabled>Select Trainer</option>

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

                    <h4 id="tableTitle">Company Stories</h4>
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
                $count = 0;
                foreach($storyData as $row){
                    $checkIdStr = "cId";
                    $temp = (string)$count;
                    $checkId = $checkIdStr.$temp;
                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>".$row->storyTitle."</td>";

                    if(($row->isPublic) == '1'){
                    ?>
                        <td>Public</td>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" id="<?=$checkId?>" name="story" value="<?=$row->storyId;?>">
                            </div>
                        </td>
                    <?php
                    }
                    else{
                    ?>
                        <td>Private</td>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" id="<?=$checkId?>" name="story" value="<?=$row->storyId;?>">
                            </div>
                        </td>
                    <?php
                    }
                ?>
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

// To enable stories which are not public as well as not assigned

var storyCount = '<?php echo(count($storyData))?>';
// alert(storyCount);
$('#staffId').on('change', function(){
    var trainerId = this.value;
    var checkIdStr = "cId";
    for(let i = 0; i < storyCount; i++){
        var idNumber = i.toString();
        var checkId = checkIdStr.concat(idNumber);
        document.getElementById(checkId).checked = false;
    }
    $.ajax({
        url: "<?= base_url('CompanyAdminController/getAssignedStories')?>",
        type: 'POST',
        data: {
            trainerId : trainerId,
        },
        success: function(response) {
            response = JSON.parse(response);
            var objLength = response.length;
            // console.log(response);
            var checkIdStr = "cId";
            document.getElementById('tableTitle').innerHTML = "Select Story(s)";
            for(let j = 0; j < storyCount; j++){
                var idNumber = j.toString();
                var checkId = checkIdStr.concat(idNumber);
                var idValue = document.getElementById(checkId).value;
                for(let k = 0; k < objLength; k++){
                    console.log(idValue);
                    console.log(response[k].storyId);
                    console.log('*');
                    if(idValue == response[k].storyId){
                        document.getElementById(checkId).checked = true;
                    }
                    else{
                        document.getElementById(checkId).checked = false;                    
                    }
                }
            }
        }
    });
});

// Stories are assigning to tariner using This ajax
var all=[];

$("#submitBtn").on('click',function(){

    staffId = $('#staffId :selected').val();  //Gettng Select trainer Id

    // console.log(staffId,all);

    $.ajax({
        url: "<?= base_url('CompanyAdminController/saveAssignedStory') ?>",
        type: 'POST',
        data: {
            trainerId : staffId,
            storyId : JSON.stringify(all),
        },
        success: function(data, textStatus, jqXHR) {
            console.log(data);
            window.location = "<?= base_url('assignStory'); ?>";
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


    // // Validating
    // var e = document.getElementById("hasScoreId");
    // var err_hasScore = document.getElementById('err_hasScore');
    // var optionSelIndex = e.options[e.selectedIndex].value;
    // var optionSelectedText = e.options[e.selectedIndex].text;
    // if (optionSelIndex == '') {
    //     document.getElementById("hasScoreId").focus();
    //     err_hasScore.style.color = "red";
    //     err_hasScore.style.fontSize = "12px";
    //     err_hasScore.innerHTML = "Wrong";
    //     return false;
    // } else {
    //     err_hasScore.innerHTML = "";
    // }

</script>
</html>