<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Add Staff</li>
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
                    <form method="POST" action="<?= base_url('CompanyAdminController/saveStaffData');?>">
                        
                    <!-- To collect staff Info -->

                        <div class="form-group">
                            <label for="">Employee Name</label>
                            <input type="text" class="form-control" id="empNameId" name="empName" placeholder="">
                            <div id="err_empName"></div>
                        </div>
        
                        <div class="form-group">
                            <label for="">Employee Level</label>
                            <select id="empLevelId" name="empLevel" class="form-control">
                                <option value="">Select Type</option>
                                <option value="2">Content Writer</option>
                                <option value="3">Trainer</option>                
                            </select>
                            <div id="err_empLevel"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Contact Number</label>
                            <input type="text" class="form-control" id="empNumberId" name="empNumber" placeholder="">
                            <div id="err_empNumber"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="text" class="form-control" id="empEmailId" name="empEmail" placeholder="">
                            <div id="err_empEmail"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Date of Birth</label>
                            <input type="text" class="form-control" id="empDOBId" name="empDOB" placeholder="Eg: DD-MM-YYY">
                            <div id="err_empDOB"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea class="form-control" id="empAddId" name="empAdd"></textarea>
                            <div id="err_empAdd"></div>
                        </div>

                        <div class="alert alert-primary" role="alert">Password For Staff</div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" class="form-control" id="empPswdId" name="empPswd" placeholder="">
                            <div id="err_empPswd"></div>
                        </div>

                        <div class="col-auto float-right">  
                            <button type="submit" class="btn btn-primary mb-2" id="submitBtn" name="submit" onclick="return formValidation();">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!------------- Modal ---------------->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Note employee login credentials : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Login ID : </p>
                    <p id = "modalLoginId"></p>
                    <hr>
                    <p>Password : </p>
                    <p id = "modalPswd"></p>
                </div>
            </div>
        </div>
    </div>
</body>

    <script>

        // document.getElementById('exampleModal').style.display = "none";

        // $('#submitBtn').on('click', function(){

        //     var email = document.getElementById('empEmailId').value;
        //     var password = document.getElementById('empPswdId').value;
        //     document.getElementById('modalLoginId').innerHTML = email;
        //     document.getElementById('modalPswd').innerHTML = password;
        //     document.getElementById('exampleModal').style.display = "block";

        // });

        function formValidation()
        {
            var empNameId = document.getElementById("empNameId").value;
            var err_empName = document.getElementById("err_empName");
            var patternEmpNameId = /([a-zA-Z_-]){3,15}$/g;
           
            if(empNameId.match(patternEmpNameId))
            {
                // err_empName.style.fontSize = "12px";
                // err_empName.style.color = "green"; 
                err_empName.innerHTML = "";                                
            }else{           
                document.getElementById("empNameId").focus();      
                err_empName.style.color = "red";
                err_empName.style.fontSize = "12px";                                
                err_empName.innerHTML = "Wrong";
                return false;            
            }
            
            // Dropdown validations
            
            var e = document.getElementById("empLevelId");
            var err_empLevel = document.getElementById('err_empLevel');
           
            var optionSelIndex = e.options[e.selectedIndex].value;
            var optionSelectedText = e.options[e.selectedIndex].text;
           
            if (optionSelIndex == '') {
                document.getElementById("empLevelId").focus();
                  err_empLevel.style.color = "red";
                  err_empLevel.style.fontSize = "12px";
                  err_empLevel.innerHTML = "Wrong";
                return false;
            } else {
                //alert("Success !! You have selected Category : " + optionSelectedText); ;  
                        
                // err_empLevel.style.color = "green"; 
                // err_empLevel.style.fontSize = "12px";
                err_empLevel.innerHTML = "";  
                    
            }

            //Contact person number

            var empNumber = document.getElementById('empNumberId').value;
            var err_empNumber = document.getElementById('err_empNumber');
            var patternContact = /([0-9-+]){8,12}$/g;

            if(empNumber.match(patternContact))
            {              
                // err_empNumber.style.fontSize = "12px";
                // err_empNumber.style.color = "green"; 
                err_empNumber.innerHTML = "";    
                   
            }else{            
                document.getElementById("empNumberId").focus();        
                err_empNumber.style.fontSize = "12px";                          
                err_empNumber.style.color = "red";
                err_empNumber.innerHTML = "Wrong";  
                return false;                
            }

            //Email Address
            var empEmail = document.getElementById('empEmailId').value;
            var err_empEmail = document.getElementById("err_empEmail");
            var patternEmpEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/g;
            
            if(empEmail.match(patternEmpEmail))
            {
                
                // err_empEmail.style.fontSize = "12px";
                // err_empEmail.style.color = "green"; 
                err_empEmail.innerHTML = "";    
                                       
            }else{
                document.getElementById("empEmailId").focus();
                err_empEmail.style.fontSize = "12px";                      
                err_empEmail.style.color = "red";
                err_empEmail.innerHTML = "Wrong";
                return false;
            }

            //Date of Birth
            var empDOB = document.getElementById('empDOBId').value;
            var err_empDOB = document.getElementById("err_empDOB");
            var patternDOB = /^([0-9]{2})-([0-9]{2})-([0-9]{4})$/g;
            
            if(empDOB.match(patternDOB))
            {
                // err_empDOB.style.fontSize = "12px";
                // err_empDOB.style.color = "green"; 
                err_empDOB.innerHTML = "";

            }else{
                document.getElementById("empDOBId").focus();
                err_empDOB.style.fontSize = "12px";                      
                err_empDOB.style.color = "red";
                err_empDOB.innerHTML = "Supported Format: DD-MM-YYYY";
                return false;          
            }

            //Address
            var empAdd = document.getElementById('empAddId').value;
            var err_empAdd = document.getElementById('err_empAdd');
            var patternEmpAdd = /([a-zA-Z0-9_-]){3,20}$/g;

            if(empAdd.match(patternEmpAdd))
            {  
                // err_empAdd.style.fontSize = "12px";
                // err_empAdd.style.color = "green"; 
                err_empAdd.innerHTML = "";    
                  
            }else{
                document.getElementById("empAddId").focus();     
                err_empAdd.style.fontSize = "12px";                      
                err_empAdd.style.color = "red";
                err_empAdd.innerHTML = "Wrong";  
                return false;                
            }

            //company admin password

            var cAdminPswd = document.getElementById('empPswdId').value;
            var err_empPswd = document.getElementById('err_empPswd');
            var patterncAdminPswd = /([a-zA-Z0-9-]){3,15}$/g;

            if(cAdminPswd.match(patterncAdminPswd))
            {              
                // err_empPswd.style.fontSize = "12px";
                // err_empPswd.style.color = "green"; 
                err_empPswd.innerHTML = "";                   
            }else{
                document.getElementById('empPswdId').focus();
                err_empPswd.style.fontSize = "12px";                      
                err_empPswd.style.color = "red";
                err_empPswd.innerHTML = "Wrong";
                return false;                
            }
        }
    </script>
</html>