<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Company Setup</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Company</li>
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

                    <form method="POST" id="createCompanyId" action="<?= base_url('SuperAdminController/saveCompanyData');?>">
                        
                        <!-- To collect Company Info -->
                        
                        <div class="form-group">
                            <label for="">Company Name</label>
                            <input type="text" class="form-control" id="companyNameId" name="companyName" placeholder="">
                            <div id="err_company_name"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Contact Number</label>
                            <input type="text" class="form-control" id="companyContactId" name="companyContact" placeholder="">
                            <div id="err_contact_number"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="text" class="form-control" id="companyEmailId" name="companyEmail" placeholder="">
                            <div id="err_email_addres"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Company Location</label>
                            <textarea class="form-control" id="companyLocationId" name="companyLocation"></textarea>
                            <div id="err_company_location"></div>
                        </div>

                        <div class="col-auto float-right">  
                        <button type="submit" class="btn btn-primary btn-user btn-block" onclick="return formValidation()">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

    <script>

        // To validate the form

        function formValidation()
        {
            var companyName = document.getElementById("companyNameId").value;
            var err_company_name = document.getElementById("err_company_name");
            var paternName = /([a-zA-Z0-9_-]){3,15}$/g;
           
            if(companyName.match(paternName))
            {
                // err_company_name.style.fontSize = "12px";
                // err_company_name.style.color = "green"; 
                err_company_name.innerHTML = "";                                
            }else{           
                document.getElementById("companyNameId").focus();      
                err_company_name.style.color = "red";
                err_company_name.style.fontSize = "12px";                                
                err_company_name.innerHTML = "Wrong";
                return false;                
            }
            
            //Contact number

            var companyContact = document.getElementById('companyContactId').value;
            var err_contact_number = document.getElementById('err_contact_number');
            var patternContact = /([0-9-+]){8,12}$/g;

            if(companyContact.match(patternContact))
            {              
                // err_contact_number.style.fontSize = "12px";
                // err_contact_number.style.color = "green"; 
                err_contact_number.innerHTML = "";    
                   
            }else{            
                document.getElementById("companyContactId").focus();        
                err_contact_number.style.fontSize = "12px";                      
                err_contact_number.style.color = "red";
                err_contact_number.innerHTML = "Wrong";
                return false;         
            }

            //Email Address

            var companyEmailId = document.getElementById('companyEmailId').value;
            var err_email_addres = document.getElementById("err_email_addres");
            var patternEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            
            if(companyEmailId.match(patternEmail))
            {
                // err_email_addres.style.fontSize = "12px";
                // err_email_addres.style.color = "green"; 
                err_email_addres.innerHTML = "";    
                                       
            }else{
                document.getElementById("companyEmailId").focus(); 
                err_email_addres.style.fontSize = "12px";                      
                err_email_addres.style.color = "red";
                err_email_addres.innerHTML = "Wrong";  
                return false;                
            }


            //Company Location

            var companyLocation = document.getElementById('companyLocationId').value;
            var err_company_location = document.getElementById('err_company_location');
            var patternLocation = /([a-zA-Z0-9_-]){3,20}$/g;

            if(companyLocation.match(patternLocation))
            {
                 
                // err_company_location.style.fontSize = "12px";
                // err_company_location.style.color = "green";
                err_company_location.innerHTML = "";    
                  
            }else{
                document.getElementById("companyLocationId").focus();     
                err_company_location.style.fontSize = "12px";                      
                err_company_location.style.color = "red";
                err_company_location.innerHTML = "Error msg";  
                return false;                
            }
            
        //     // Credentials

        //     var cAdminName = document.getElementById("cAdminNameId").value;
        //     var err_cAdminName = document.getElementById("err_cAdminName");
        //     var paternAdminName = /([a-zA-Z_-]){3,15}$/g;
           
        //     if(cAdminName.match(paternAdminName))
        //     {
        //         // err_cAdminName.style.fontSize = "12px";
        //         // err_cAdminName.style.color = "green"; 
        //         err_cAdminName.innerHTML = "";                                
        //     }else{           
        //         document.getElementById("cAdminNameId").focus();      
        //         err_cAdminName.style.color = "red";
        //         err_cAdminName.style.fontSize = "12px";                                
        //         err_cAdminName.innerHTML = "Wrong";  
        //         return false;            
        //     }

        //     //Company admin Login Id

        //     var cAdminLogin = document.getElementById('cAdminLoginId').value;
        //     var err_cAdminLoginId = document.getElementById('err_cAdminLoginId');
        //     var patterncAdminLogin = /([a-zA-Z0-9-+]){3,15}$/g;

        //     if(cAdminLogin.match(patterncAdminLogin))
        //     {              
        //         // err_cAdminLoginId.style.fontSize = "12px";
        //         // err_cAdminLoginId.style.color = "green"; 
        //         err_cAdminLoginId.innerHTML = "";    
                
        //     }else{
        //         document.getElementById('cAdminLoginId').focus();
        //         err_cAdminLoginId.style.fontSize = "12px";                      
        //         err_cAdminLoginId.style.color = "red";
        //         err_cAdminLoginId.innerHTML = "Wrong";  
        //         return false;
        //     }
            
        //     //company admin password

        //     var cAdminPswd = document.getElementById('cAdminPswdId').value;
        //     var err_cAdminPswd = document.getElementById('err_cAdminPswd');
        //     var patterncAdminPswd = /([a-zA-Z0-9-]){3,15}$/g;

        //     if(cAdminPswd.match(patterncAdminPswd))
        //     {              
        //         // err_cAdminPswd.style.fontSize = "12px";
        //         // err_cAdminPswd.style.color = "green"; 
        //         err_cAdminPswd.innerHTML = "";                   
        //     }else{
        //         document.getElementById('cAdminPswdId').focus();
        //         err_cAdminPswd.style.fontSize = "12px";                      
        //         err_cAdminPswd.style.color = "red";
        //         err_cAdminPswd.innerHTML = "Wrong";
        //         return false;                
        //     }
        }

    </script>
</html>