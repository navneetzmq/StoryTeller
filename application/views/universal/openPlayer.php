<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Fill Your Details before Play</li>
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

                    <!-- <//?php var_dump($story)?> -->

                    
                    <!-- form -->
                    <form method="POST" action="<?= base_url('OpenPlayerController/saveOpenPlayerData');?>">
                        <div class="form-group">
                            <label for="">Full Name</label>
                            <input type="text" class="form-control" id="openNameId" name="openName" placeholder="">
                            <div id="err_openName"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Contact Number</label>
                            <input type="text" class="form-control" id="openNumberId" name="openNumber" placeholder="">
                            <div id="err_openNumber"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="text" class="form-control" id="openEmailId" name="openEmail" placeholder="">
                            <div id="err_openEmail"></div>
                        </div>

                        <!-- Dropdown to select Story to Play -->
                        
                        <div class="form-group">
                        <label for="">Select Story</label>
                        <select id="storyId" name="storyId" class="form-control">
                            <option value='' selected>Select Story to Play</option>
                                <?php 
                                if(isset($story) && !empty($story)){
                                    for($i = 0 ; $i < count($story); $i++) { ?>
                                        <?php if(isset($story[$i]->storyId)){ ?>
                                            <option value="<?= $story[$i]->storyId; ?>"><?= $story[$i]->storyTitle; ?>
                                    <?php }?>
                                            </option>
                                <?php }} ?>
                        </select>
                        <div id="err_story"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Date of Birth</label>
                            <input type="text" class="form-control" id="openDOBId" name="openDOB" placeholder="Eg: DD-MM-YYY">
                            <div id="err_openDOB"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea class="form-control" id="openAddId" name="openAdd"></textarea>
                            <div id="err_openAdd"></div>
                        </div>
                        
                        <hr>

                        <div class="col-auto float-right">  
                            <button type="submit" class="btn btn-primary mb-2" name="submit" onclick="return validateOpenPlayer();">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateOpenPlayer()
        {
            var openName = document.getElementById("openNameId").value;
            var err_openName = document.getElementById("err_openName");
            var patternOpenName = /([a-zA-Z ]){3,15}$/g;

            if(openName.match(patternOpenName))
            {
                // err_openName.style.fontSize = "12px";
                // err_openName.style.color = "green"; 
                err_openName.innerHTML = "";                                
            }else{           
                document.getElementById("openNameId").focus();      
                err_openName.style.color = "red";
                err_openName.style.fontSize = "12px";                                
                err_openName.innerHTML = "Wrong";
                return false;
            }

            //Contact person number

            var openNumber = document.getElementById('openNumberId').value;
            var err_openNumber = document.getElementById('err_openNumber');
            var patternOpenNumber = /([0-9-+]){8,12}$/g;

            if(openNumber.match(patternOpenNumber))
            {              
                // err_openNumber.style.fontSize = "12px";
                // err_openNumber.style.color = "green"; 
                err_openNumber.innerHTML = "";    

            }else{            
                document.getElementById("openNumberId").focus();        
                err_openNumber.style.fontSize = "12px";                          
                err_openNumber.style.color = "red";
                err_openNumber.innerHTML = "Wrong";  
                return false;                
            }

            //Email Address
            var openEmail = document.getElementById('openEmailId').value;
            var err_openEmail = document.getElementById("err_openEmail");
            var patternOpenEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/g;
            
            if(openEmail.match(patternOpenEmail))
            {
                
                // err_openEmail.style.fontSize = "12px";
                // err_openEmail.style.color = "green"; 
                err_openEmail.innerHTML = "";    
                                       
            }else{
                document.getElementById("openEmailId").focus();
                err_openEmail.style.fontSize = "12px";                      
                err_openEmail.style.color = "red";
                err_openEmail.innerHTML = "Wrong";
                return false;
            }

            // Dropdown validations
            
            var e = document.getElementById("storyId");
            var err_story = document.getElementById('err_story');
           
            var optionSelIndex = e.options[e.selectedIndex].value;
            var optionSelectedText = e.options[e.selectedIndex].text;
           
            if (optionSelIndex == '') {
                document.getElementById("storyId").focus();
                  err_story.style.color = "red";
                  err_story.style.fontSize = "12px";
                  err_story.innerHTML = "Wrong";
                return false;
            } else {
                //alert("Success !! You have selected Category : " + optionSelectedText); ;  
                        
                // err_story.style.color = "green"; 
                // err_story.style.fontSize = "12px";
                err_story.innerHTML = "";  
                    
            }

            //Date of Birth
            var openDOB = document.getElementById('openDOBId').value;
            var err_openDOB = document.getElementById("err_openDOB");
            var patternDOB = /^([0-9]{2})-([0-9]{2})-([0-9]{4})$/g;
            
            if(openDOB.match(patternDOB))
            {
                // err_openDOB.style.fontSize = "12px";
                // err_openDOB.style.color = "green"; 
                err_openDOB.innerHTML = "";
                         
            }else{
                document.getElementById("openDOBId").focus();
                err_openDOB.style.fontSize = "12px";                      
                err_openDOB.style.color = "red";
                err_openDOB.innerHTML = "Supported Format: DD-MM-YYYY";
                return false;          
            }

            //Address
            var openAdd = document.getElementById('openAddId').value;
            var err_openAdd = document.getElementById('err_openAdd');
            var patternOpenAdd = /([a-zA-Z0-9_-]){3,20}$/g;

            if(openAdd.match(patternOpenAdd))
            {
                 
                // err_openAdd.style.fontSize = "12px";
                // err_openAdd.style.color = "green"; 
                err_openAdd.innerHTML = "";    
 
            }else{
                document.getElementById("openAddId").focus();     
                err_openAdd.style.fontSize = "12px";                      
                err_openAdd.style.color = "red";
                err_openAdd.innerHTML = "Wrong";  
                return false;                
            }
        }
    </script>
    </script>
</body>