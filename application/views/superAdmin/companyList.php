<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">List of Companies</li>
                </ol>
            </nav>
            <div class="col-md-9 col-lg-12 mx-auto">
                <?php if($this->session->flashdata('add_company_admin')) { ?>
    	        <?php echo '<p class="alert alert-success mt-3 text-center" id="add">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>'
                .$this->session->flashdata('add_company_admin') . '</p>'; ?>
	  	        <?php } $this->session->unset_userdata('add_company_admin');  //unset session ?>

                <div id="hideTableId" class="card">
                    <div class="card-body">

                    <!-- form -->
                    <form method="POST" action="<?= base_url('SuperAdminController/saveCompanyAdminData');?>">
                        <h4>Companies</h4>
                        <hr>
                        <div class="container">
                            <table class="table table-sm table-responsive table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Location</th>
                                        <th>Email</th>
                                        <th>Creation Time</th>
                                        <th>Assign Admin</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <!-- Getting Story data into the table -->

                                <?php
                                foreach($companyData as $row){
                                //   for(var $i=0; $i < count($staff); $i++ ) {     

                                echo "<tr>";
                                    echo "<td>".$row->companyName."</td>";
                                    echo "<td>".$row->location."</td>";
                                    echo "<td>".$row->email."</td>";
                                    echo "<td>".$row->createdDateTime."</td>";
                                    if($row->adminId == 0){
                                        echo "<td>"."<input type='button' class='btn btn-primary btn-sm assignAdmin' data-target='#exampleModal' data-toggle='modal' onclick='assignAdmin(".'"'.$row->companyId.'"'.");' value='Assign Admin'>"."</td>";
                                    }
                                    else{
                                        echo "<td>"."<input type='button' class='btn btn-info btn-sm assignAdmin' onclick='adminDetails(".'"'.$row->companyId.'"'.");' value='Admin Details'>"."</td>";
                                    }
                                    if($row->isActive == 1){
                                        echo "<td>"."<input type='button' id='activeBtn' class='btn btn-outline-success btn-sm' data-toggle='modal' onclick='activeInActiveCompany(".'"'.$row->companyId.'",'.'1'.");' value='Active'>"."</td>";
                                    }
                                    else{
                                        echo "<td>"."<input type='button' id='inertBtn' class='btn btn-outline-danger btn-sm' data-toggle='modal' onclick='activeInActiveCompany(".'"'.$row->companyId.'",'.'0'.");' value='Inactive '>"."</td>";
                                    }
                                ?>
                                </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!------------------ Modal -------------->

        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create new Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?= base_url('SuperAdminController/saveCompanyAdminData');?>">
                            <div class="form-group" id="hideCompanyId">
                                <label for="">CompanyId</label>
                                <input type="text" class="form-control" id="companyId" name="companyId" placeholder="" >
                                <div id="err_companyId"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Admin Name</label>
                                <input type="text" class="form-control" id="empNameId" name="empName" placeholder="">
                                <div id="err_empName"></div>
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

                            <div class="alert alert-primary" role="alert">Create Password for Company Admin</div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="text" class="form-control" id="empPswdId" name="empPswd" placeholder="">
                                <div id="err_empPswd"></div>
                            </div>

                                <div class="col-auto float-right">  
                                    <button type="submit" class="btn btn-primary mb-2" name="submit" onclick="return formValidation();">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to show result -->
        <div class="modal fade" id="adminInfoModal" tabindex="-1" aria-labelledby="adminInfoModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: skyblue; color: black;">
                <div class="modal-header" style="text-align: center;">
                    <h4 class="modal-title" id="adminInfoModalLabel">Admin : </h4>
                    <button type="button" id="dismissId" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 40px">
                    <!-- Emp Name -->
                    <div class="row">
                        <h5>Name : <strong><span id="adminNameId"></span></strong></h5>
                    </div>
                    <div class="row">
                        <h5>Phone : <span id="adminPhoneId"></span></h5>
                    </div>
                    <div class="row">
                        <h5>Email : <span id="adminEmailId"></span></h5>
                    </div>
                    <div class="row">
                        <h5>Address : <span id="adminAddressId"></span></h5>
                    </div>
            </div>
        </div>
    <script>

        // Assign Admin
        function assignAdmin(companyId){
            document.getElementById('hideCompanyId').style.display = "none";
            let companyIdObj = document.getElementById('companyId');
            companyIdObj.value = companyId;
            companyIdObj.readOnly = true;

        }

        // Fetch admin Details
        function adminDetails(companyId){
            $.ajax({
                url: "<?= base_url('SuperAdminController/getCompanyAdmin') ?>",
                type: 'POST',
                data: {
                    companyId : companyId,
                },
                success: function(response) {
                    response = JSON.parse(response);
                    document.getElementById('adminNameId').innerHTML = response['name'];
                    document.getElementById('adminPhoneId').innerHTML = response['phone'];
                    document.getElementById('adminEmailId').innerHTML = response['email'];
                    document.getElementById('adminAddressId').innerHTML = response['address'];
                    $('#adminInfoModal').modal({backdrop: 'static', keyboard: false});
                    $('#adminInfoModal').modal('show');
                }
            })
        }

        // Start : Active and Inactive button behaviour
        function activeInActiveCompany(companyId, isActive){
            $.ajax({
                url: "<?= base_url('SuperAdminController/activeInActiveCompany') ?>",
                type: 'POST',
                data: {
                    companyId : companyId,
                    isActive : isActive,
                },
                success: function(response) {
                    window.location.href = "<?php echo base_url('company')?>";
                }
            })
        } // End : Active and Inactive button behaviour

        // Modal validation
        function formValidation(){

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

            // Credentials
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
    </body>
</html>