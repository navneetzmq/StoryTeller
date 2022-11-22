<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Add Rule-Book for Story / Generic</li>
                </ol>
            </nav>
            <div class="col-md-9 col-lg-8 mx-auto">
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
                    <form method="POST" action="<?= base_url('CompanyAdminController/saveRuleBookData   ');?>"> 

                        <!-- Ask to change Number-of-options -->
                        <div class="form-group" id="storyOrGenericAreaId">
                            <label for=""><strong id="storyOrGenericLabel">Set rules for : Story / Generic</strong></label>
                            <select id="storyOrGeneric" name="storyOrGeneric" class="form-control">
                                <option value="" disabled="true" selected="true">Please Select</option>
                                <option value="1">Story</option>
                                <option value="0">Generic</option>
                            </select>
                            <div id="err_hasScore"></div>
                        </div>
                        
                        <!-- Dropdown to select Story -->
                        <div class="form-group" id="storyAreaId">
                            <label id="labelId" for=""><strong>Select Story</strong></label>
                            <select id="storyId" name="storyId" class="form-control">
                                <option value="0" disabled="true" selected="true">Select Story</option>
                                <?php
                                if(isset($storyData) && !empty($storyData)){
                                    for($i = 0 ; $i < count($storyData); $i++) { ?>
                                        <?php if(isset($storyData[$i]->storyId)){ ?>
                                            <option value="<?= $storyData[$i]->storyId; ?>">
                                            <?= $storyData[$i]->storyTitle; ?>  
                                        <?php }?>
                                            </option>
                                <?php }} ?>
                            </select>
                            <div id="err_story"></div>
                        </div>

                        <!-- Dropdown to select Generic -->
                        <div class="form-group" id="genericAreaId">
                            <label id="labelId" for=""><strong>Select Generic</strong></label>
                            <select id="genericId" name="genericId" class="form-control">
                                <option value="0" disabled="true" selected="true">Select Generic</option>
                                <?php
                                if(isset($genericData) && !empty($genericData)){
                                    for($i = 0 ; $i < count($genericData); $i++) { ?>
                                        <?php if(isset($genericData[$i]->genericId)){ ?>
                                            <option value="<?= $genericData[$i]->genericId; ?>">
                                            <?= $genericData[$i]->genericTitle; ?>
                                        <?php }?>
                                            </option>
                                <?php }} ?>
                            </select>
                            <div id="err_story"></div>
                        </div>

                        <div id="rulesTitle" class="alert alert-primary" role="alert"></div>
                        
                        <div id="rulesArea" class="container mt-3">
                            <!-- Answer Status -->
                            <div class="row mt-4" id="ansStatusArea">
                                <div class="col-lg-4">
                                    <strong>1. Answer Status : </strong>
                                </div>
                                <div class="custom-control custom-switch col-auto">
                                  <input type="checkbox" id="ansStatus" class="custom-control-input" name="ansStatus" value="0">
                                  <label class="custom-control-label" for="ansStatus"><strong id="ansStatusLabel">Hide / Show</strong></label>
                                </div>
                            </div>
                                            
                            <!-- Review Answer [Allow previous button] -->
                            <div class="row mt-4" id="reviewAnsArea">
                                <div class="col-lg-4">
                                    <strong>2. Review Answer : </strong>
                                </div>
                                <div class="custom-control custom-switch col-auto">
                                  <input type="checkbox" id="reviewAns" class="custom-control-input" name="reviewAns" value="0">
                                  <label class="custom-control-label" for="reviewAns"><strong id="reviewAnsLabel">Hide / Show</strong></label>
                                </div>
                            </div>

                            <!-- Display Test Timing -->
                            <div class="row mt-4" id="testTimeArea">
                                <div class="col-lg-4">
                                    <strong>3. Test Time : </strong>
                                </div>
                                <div class="custom-control custom-switch col-auto">
                                  <input id="testTime" type="checkbox" class="custom-control-input" name="testTime" value="0">
                                  <label class="custom-control-label" for="testTime"><strong id="testTimeLabel">Hide / Show</strong></label>
                                </div>
                            </div>
                            
                            <!-- Score Base -->
                            <div class="row mt-4" id="scoreBaseArea">
                                <div class="col-lg-4">
                                    <strong>4. Score Base : </strong>
                                </div>
                                <div class="custom-control custom-switch col-auto">
                                  <input type="checkbox" class="custom-control-input" name="scoreBase" id="scoreBase" value="0">
                                  <label class="custom-control-label" for="scoreBase"><strong id="scoreBaseLabel">Distinct / Identical</strong></label>
                                </div>
                            </div>

                            <!-- Autoplay audio -->
                            <div class="row mt-4" id="autoplayArea">
                                <div class="col-lg-4">
                                    <strong>5. Autoplay Audio : </strong>
                                </div>
                                <div class="custom-control custom-switch col-auto">
                                  <input id="autoplay" type="checkbox" class="custom-control-input" name="autoplay" value="0">
                                  <label class="custom-control-label" for="autoplay"><strong id="autoplayLabel">No / Yes</strong></label>
                                </div>
                            </div>
                            <hr class="mt-4" style="border: 1px solid skyblue;">
                            <div class="col-auto float-right">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-user btn-block btn-sm">Set Rules</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
<script>

    document.getElementById('genericAreaId').style.display = "none";
    document.getElementById('storyAreaId').style.display = "none";
    document.getElementById('rulesTitle').style.display = "none";
    document.getElementById('rulesArea').style.display = "none";

    // genericId
    $('#storyOrGeneric').on('change', function(){
        var storyOrGeneric = this.value;
        if(storyOrGeneric == '1'){
            document.getElementById('storyAreaId').style.display = "block";
            document.getElementById('genericAreaId').style.display = "none";
            document.getElementById('rulesTitle').innerHTML = "Set rules for Story : ";
        }
        else{
            document.getElementById('storyAreaId').style.display = "none";
            document.getElementById('genericAreaId').style.display = "block";
            document.getElementById('rulesTitle').innerHTML = "Set rules for Generic : ";
        }
    })

    // When story is selected
    $('#storyId').on('change', function(){
        var storyId = this.value;
        // Check rules according to testLayout table and using of StoryId
        $.ajax({
            url: "<?= base_url('CompanyAdminController/getStoryTestLayout')?>",
            type: 'POST',
            data: {
                storyId : storyId,
            },
            success: function(response) {
                response = JSON.parse(response);
                var temp = response.length;
                checkUncheckSwitch(response);
            }
        })
            document.getElementById('rulesTitle').style.display = "block";
            document.getElementById('rulesArea').style.display = "block";
    })

    // When generic is selected
    $('#genericId').on('change', function(){
        var genericId = this.value;
        // Check rules according to testLayout table and using of GenericId
        $.ajax({
            url: "<?= base_url('CompanyAdminController/getGenericTestLayout')?>",
            type: 'POST',
            data: {
                genericId : genericId,
            },
            success: function(response) {
                response = JSON.parse(response);
                var temp = response.length;
                console.log(response);
                checkUncheckSwitch(response);
            }
        })
        document.getElementById('rulesTitle').style.display = "block";
        document.getElementById('rulesArea').style.display = "block";
    })

    // To check / Uncheck Switch buttons using Databse Response
    function checkUncheckSwitch(response){
        // Check-UnCheck "Answer Status" Switch
        if(response['showStatus'] == '1'){
            document.getElementById("ansStatus").checked = true;
            document.getElementById("ansStatus").value = "1";
            document.getElementById("ansStatusLabel").innerHTML = "Show";
        }
        else{
            document.getElementById("ansStatus").checked = false;
            document.getElementById("ansStatusLabel").innerHTML = "Hide";
        }
        // Check-UnCheck "Review Answer" Switch
        if(response['allowPrevious'] == '1'){
            document.getElementById("reviewAns").checked = true;
            document.getElementById("reviewAns").value = "1";
            document.getElementById("reviewAnsLabel").innerHTML = "Allow";
        }
        else{
            document.getElementById("reviewAns").checked = false;
            document.getElementById("reviewAnsLabel").innerHTML = "Not-Allow";
        }
        // Check-UnCheck "Autoplay Audio" Switch
        if(response['autoplayAudio'] == '1'){
            document.getElementById("autoplay").checked = true;
            document.getElementById("autoplay").value = "1";
            document.getElementById("autoplayLabel").innerHTML = "Yes";
        }
        else{
            document.getElementById("autoplay").checked = false;
            document.getElementById("autoplayLabel").innerHTML = "No";
        }
        // Check-UnCheck "Test time" Switch
        if(response['testTime'] == '1'){
            document.getElementById("testTime").checked = true;
            document.getElementById("testTime").value = "1";
            document.getElementById("testTimeLabel").innerHTML = "Show";
        }
        else{
            document.getElementById("testTime").checked = false;
            document.getElementById("testTimeLabel").innerHTML = "Hide";
        }
        // Check-UnCheck "Score Base" Switch
        if(response['distinctScore'] == '1'){
            document.getElementById("scoreBase").checked = true;
            document.getElementById("scoreBase").value = "1";
            document.getElementById("scoreBaseLabel").innerHTML = "Distinct";
        }
        else{
            document.getElementById("scoreBase").checked = false;
            document.getElementById("scoreBaseLabel").innerHTML = "Identical";
        }
    }

    // Onchange answerStatus
    $('#ansStatus').on('change', function(){
        if(document.getElementById("ansStatus").checked){
            document.getElementById("ansStatus").value = "1";
            document.getElementById("ansStatusLabel").innerHTML = "Show";
        }
        else{
            document.getElementById("ansStatus").value = "0";
            document.getElementById("ansStatusLabel").innerHTML = "Hide";
        }
    })

    // Onchange reviewAns
    $('#reviewAns').on('change', function(){
        if(document.getElementById("reviewAns").checked){
            document.getElementById("reviewAns").value = "1";
            document.getElementById("reviewAnsLabel").innerHTML = "Allow";
        }
        else{
            document.getElementById("reviewAns").value = "0";
            document.getElementById("reviewAnsLabel").innerHTML = "Not-Allow";
        }
    })

    // Onchange autoplay audio
    $('#autoplay').on('change', function(){
        if(document.getElementById("autoplay").checked){
            document.getElementById("autoplay").value = "1";
            document.getElementById("autoplayLabel").innerHTML = "Yes";
        }
        else{
            document.getElementById("autoplay").value = "0";
            document.getElementById("autoplayLabel").innerHTML = "No";
        }
    })
    
    // Onchange testTime
    $('#testTime').on('change', function(){
        if(document.getElementById("testTime").checked){
            document.getElementById("testTime").value = "1";
            document.getElementById("testTimeLabel").innerHTML = "Show";
        }
        else{
            document.getElementById("testTime").value = "0";
            document.getElementById("testTimeLabel").innerHTML = "Hide";
        }
    })
    
    // Onchange scoreBase
    $('#scoreBase').on('change', function(){
        if(document.getElementById("scoreBase").checked){
            document.getElementById("scoreBase").value = "1";
            document.getElementById("scoreBaseLabel").innerHTML = "Distinct";
        }
        else{
            document.getElementById("scoreBase").value = "0";
            document.getElementById("scoreBaseLabel").innerHTML = "Identical";
        }
    })
</script>

</html>