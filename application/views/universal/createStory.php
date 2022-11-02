<html>
    <head>
    </head>
    <body>

        <?php $userData = $this->session->userdata('userData'); 
        
            // var_dump($userData['level']);

        ?>

        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Create Story</a></li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
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
                    <form method="POST" action="<?= base_url('SuperAdminController/saveStoryData');?>">

                        <!-- Story title -->

                        <?php
                            if(isset($userData)){
                                if($userData['level'] == "0" || $userData['level'] == "1" || $userData['level'] == "2"){
                        ?>
                        <div class="form-group">
                            <label for="">Story Title</label>
                            <input type="text" class="form-control" id="storyTitleId" name="storyTitle" placeholder="">
                            <div id="err_storyTitle"></div>
                        </div>
                        <?php
                            }}
                        ?>

                        <!-- Has Pre Question ? Post Question ? Or Both ? -->
                        
                        <?php
                            if(isset($userData)){
                                if($userData['level'] == "1" || $userData['level'] == "2"){
                        ?>
                        <div class="form-group">
                            <label for="">Question Appearance Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="quesType" id="quesTypeId">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Pre Story
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="2" name="quesType" id="quesTypeId">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Post Story
                                </label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="3" name="quesType" id="quesTypeId">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Both
                                </label>
                            </div>
                            <div id="err_storyHasPre"></div>
                        </div>
                        <?php
                                }}
                        ?>

                        <!-- Story type for SuperAdmin level-0 -->
                        
                        <?php
                            if(isset($userData)){
                                if($userData['level'] == "0"){
                        ?>

                        <div class="form-group">
                            <label for="">Story Type</label>
                            <select id="storyTypeId" name="storyType" class="form-control">
                                <option value="">Please Select</option> 
                                <option value="1">Public</option> 
                            </select>
                            <div id="err_storyType"></div>
                        </div>

                        <?php
                                }}
                        ?>

                        
                        <!-- Story Type for CompanyAdmin level-1  and Content creater level-2-->

                        <?php
                            if(isset($userData)){
                                if($userData['level'] == "1" || $userData['level'] == "2"){
                        ?>

                        <div class="form-group">
                            <label for="">Story Type</label>
                            <select id="storyTypeId" name="storyType" class="form-control">
                                <option value="">Please Select</option>
                                <option value="1">Public</option>
                                <option value="0">Private</option>       
                            </select>
                            <div id="err_storyType"></div>
                        </div>

                        <?php
                                }}
                        ?>

                        <div class="col-auto float-right">  
                            <button type="submit" class="btn btn-primary btn-user btn-block" onclick="return storyValidation();">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        function storyValidation()
        {
            var storyTitle = document.getElementById("storyTitleId").value;
            var err_storyTitle = document.getElementById("err_storyTitle");
            var patternStoryTitle = /([a-zA-Z_-]){3,15}$/g;
           
            if(storyTitle.match(patternStoryTitle))
            {
                // err_storyTitle.style.fontSize = "12px";
                // err_storyTitle.style.color = "green"; 
                err_storyTitle.innerHTML = "";                                
            }else{           
                document.getElementById("storyTitleId").focus();   
                err_storyTitle.style.color = "red";
                err_storyTitle.style.fontSize = "12px";                                
                err_storyTitle.innerHTML = "Wrong";  
                return false;                
            }

            // Radio button validation

            var quesArr = document.getElementsByName('quesType');
            if((quesArr[0].checked || quesArr[1].checked || quesArr[2].checked)){
                err_storyHasPre.innerHTML = "";
            }
            else{
                err_storyHasPre.style.color = "red";
                err_storyHasPre.style.fontSize = "12px";                       
                err_storyHasPre.innerHTML = "Wrong";
                return false;             
            }
            
            // Dropdown validations
            
            var e = document.getElementById("storyTypeId");
            var err_storyType = document.getElementById('err_storyType');
           
            var optionSelIndex = e.options[e.selectedIndex].value;
            var optionSelectedText = e.options[e.selectedIndex].text;
           
            if (optionSelIndex == '') {
                document.getElementById("storyTypeId").focus();
                  err_storyType.style.color = "red";
                  err_storyType.style.fontSize = "12px";
                  err_storyType.innerHTML = "Wrong";
                return false;
            } else {
                //alert("Success !! You have selected Category : " + optionSelectedText); ;  
                        
                // err_storyType.style.color = "green";
                // err_storyType.style.fontSize = "12px";
                err_storyType.innerHTML = "";
                    
            }
        }
    </script>
</html>