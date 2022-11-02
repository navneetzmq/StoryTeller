<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Audience Information</li>
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

                    <!-- <//?php var_dump($storyData);?> -->
                    
                    <!-- form -->
                    <form method="POST" action="<?= base_url('CompanyAdminController/saveAudience');?>">

                    <!-- Dropdown to select story -->

                    <div class="form-group">
                        <label for="">Select Story</label>
                        <select id="storyId" name="storyId" class="form-control">
                            <option value="" selected>Select Story Name</option>

                            <?php 
                                if(isset($storyData) && !empty($storyData)){
                                    for($i = 0 ; $i < count($storyData); $i++) { ?>
                                        <?php if(isset($storyData[$i]->storyId)){ ?>
                                            <option value="<?= $storyData[$i]->storyId; ?>"><?= $storyData[$i]->storyTitle; ?>
                                    <?php }?>
                                            </option>
                                <?php }} ?>
                        </select>
                        <div id="err_story"></div>
                    </div>
                        
                        <div class="form-group">
                            <label for="">Male Count</label>
                            <input type="text" class="form-control" id="maleId" name="male" placeholder="">
                            <div id="err_male"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Female Count</label>
                            <input type="text" class="form-control" id="femaleId" name="female" placeholder="">
                            <div id="err_female"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Location</label>
                            <textarea class="form-control" id="locationId" name="location"></textarea>
                            <div id="err_location"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Upload Image</label>
                            <input type="file" id="imageId" name="image" accept="image/*">
                            <input type="submit" value="Upload Image">
                            <div id="err_image"></div>
                        </div>

                        <div class="col-auto float-right">  
                        <button type="submit" class="btn btn-primary mb-2" name="submit" onclick="return validateAudience();">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        function validateAudience()
        {
            // Dropdown validations
            
            var e = document.getElementById("storyId");
            var err_story = document.getElementById('err_story');
           
            var optionSelIndex = e.options[e.selectedIndex].value;
            var optionSelectedText = e.options[e.selectedIndex].text;
           
            if (optionSelIndex == "") {
                document.getElementById("storyId").focus();
                  err_story.style.color = "red";
                  err_story.style.fontSize = "12px";
                  err_story.innerHTML = "Wrong";
                return false;
            } else {
                //alert("Success !! You have selected Category : " + optionSelectedText); 
                        
                // err_story.style.color = "green"; 
                // err_story.style.fontSize = "12px";
                err_story.innerHTML = "";
                    
            }

            // Male count
            var male = document.getElementById('maleId').value;
            var err_male = document.getElementById('err_male');
            var patternMale = /([0-9]){1,3}$/g;

            if(male.match(patternMale))
            {              
                // err_male.style.fontSize = "12px";
                // err_male.style.color = "green"; 
                err_male.innerHTML = "";    
                   
            }else{            
                document.getElementById("maleId").focus();        
                err_male.style.fontSize = "12px";                      
                err_male.style.color = "red";
                err_male.innerHTML = "Wrong";  
                return false;                
            }
            
            // Female count
            var female = document.getElementById('femaleId').value;
            var err_female = document.getElementById('err_female');
            var patternFemale = /([0-9]){1,3}$/g;

            if(female.match(patternFemale))
            {              
                // err_female.style.fontSize = "12px";
                // err_female.style.color = "green"; 
                err_female.innerHTML = "";    
                   
            }else{            
                document.getElementById("femaleId").focus();        
                err_female.style.fontSize = "12px";                      
                err_female.style.color = "red";
                err_female.innerHTML = "Wrong";  
                return false;                
            }
            
            // Location
            var location = document.getElementById('locationId').value;
            var err_location = document.getElementById('err_location');
            var patternLocation = /([a-zA-Z0-9_-]){3,20}$/g;

            if(location.match(patternLocation))
            {
                 
                // err_location.style.fontSize = "12px";
                // err_location.style.color = "green";
                err_location.innerHTML = "";    
                  
            }else{
                document.getElementById("locationId").focus();     
                err_location.style.fontSize = "12px";                      
                err_location.style.color = "red";
                err_location.innerHTML = "Error msg";  
                return false;                
            }
        }
    </script>
</html>