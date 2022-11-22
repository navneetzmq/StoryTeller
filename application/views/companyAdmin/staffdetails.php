<html>
    <head>
    <?php
      $userData = $this->session->userdata('userData');
    ?>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Employees List</li>
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

                    <!-- <pre><//?php var_dump($staffData[0]->staffId)?></pre> -->

                    <!-- form -->              

                    <form method="POST" action="<?= base_url('CompanyAdminController/saveAssignedStory');?>">

                    <!-- Table with ckeckboxes to select Multiple Stories to assign Trainer -->

                    <div class="container">
                    <table id="example" class="table table-sm table-responsive table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Edit Info</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                <tbody>

                <!-- Getting Story data into the table -->

                <?php
                foreach($staffData as $row){
                    echo "<tr>";
                    echo "<td>".$row->name."</td>";
                    if(($row->level) == '1'){
                        echo "<td>"."Company Admin"."</td>";
                    }
                    elseif(($row->level) == '2'){
                        echo "<td>"."Content Writer"."</td>";
                    }
                    elseif(($row->level) == '3'){
                        echo "<td>"."Trainer"."</td>";
                    }
                    echo "<td>".$row->phone."</td>";
                    echo "<td>".$row->email."</td>";
                    echo "<td>".$row->address."</td>";
                    echo "<td>"."<input type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#exampleModal' value='Update' onclick='updateStaffData(".'"'.$row->staffId.'"'.");'>"."</td>";                        
                    if($row->isActive == 1){
                      if($userData['staffId'] == $row->staffId){
                        echo "<td>"."<input type='button' id='activeBtn' class='btn btn-outline-success btn-sm' data-toggle='modal' value='Active' disabled>"."</td>";                    
                      }
                      else{
                        echo "<td>"."<input type='button' id='activeBtn' class='btn btn-outline-success btn-sm' data-toggle='modal' onclick='activeInactiveEmp(".'"'.$row->staffId.'",'.'1'.");' value='Active'>"."</td>";
                      }
                    }
                    else{
                      echo "<td>"."<input type='button' id='inertBtn' class='btn btn-outline-danger btn-sm' data-toggle='modal' onclick='activeInactiveEmp(".'"'.$row->staffId.'",'.'0'.");' value='Inactive '>"."</td>";
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
</body>

<!-- Modal, to update Name, Phone, Email, addr -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Staff Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- <form id="updateFormId" method="post" action="<//?php echo base_url('update_staff');?>" enctype="multipart/form-data"> -->
          <form method="POST" action="<?= base_url('CompanyAdminController/updateStaffInfo');?>">

          <!-- Employee Id (which is hidden) -->
          <div class="form-group row" id="empId">
            <label for="emp_Id" class="col-sm-2 col-form-label">Id</label>
            <div class="col-sm-10">
              <input type="text" id="empIdInput" class="form-control" name="emp_Id" readonly>
            </div>
            <div id="err_emp_Id"></div>
          </div>

          <!-- Emp Name -->
          <div class="form-group row" id="empName">
            <label for="emp_name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input type="text" id="empNameInput" class="form-control" name="emp_name">
            </div>
            <div id="err_emp_name"></div>
          </div>
          
          <!-- Emp phone -->
          <div class="form-group row" id="empPhone">
            <label for="emp_phone" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
              <input type="text" id="empPhoneInput" class="form-control" name="emp_phone">
            </div>
            <div id="err_emp_phone"></div>
          </div>

          <!-- Emp Email -->
          <div class="form-group row" id="empEmail">
            <label for="emp_email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="text" id="empEmailInput" class="form-control" name="emp_email">
            </div>
            <div id="err_emp_email"></div>
          </div>

          <!-- Emp Address -->
          <div class="form-group row" id="empAddress">
            <label for="emp_address" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
              <input type="text" id="empAddressInput" class="form-control" name="emp_address">
            </div>
            <div id="err_emp_address"></div>
          </div>

          <!-- Emp password -->
          <div class="form-group row" id="empPswd">
            <label for="emp_pswd" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="text" id="empPswdInput" class="form-control" name="emp_pswd">
            </div>
            <div id="err_emp_pswd"></div>
          </div>

          <div class="modal-footer" id="modalFooter">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary mb-2" id="submitBtn" name="submit" onclick="return validateModal();">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ---------- Script --------- -->
<script>

document.getElementById('empId').style.display = "none";

// To update Name, Phone, Email(LoginId), Address

function updateStaffData(staffId){

  $.ajax({
    url: "<?= base_url('CompanyAdminController/getStaffDetails') ?>",
    type: 'POST',
    data: {
      staffId : staffId,
    },
    success: function(response) {
      response = JSON.parse(response);
      // console.log(response);
      document.getElementById('empIdInput').value = response['staffId'];
      document.getElementById('empNameInput').value = response['name'];
      document.getElementById('empPhoneInput').value = response['phone'];
      document.getElementById('empEmailInput').value = response['email'];
      document.getElementById('empAddressInput').value = response['address'];
      document.getElementById('empPswdInput').value = response['password'];

      document.getElementById('empName').style.display = "block";
      document.getElementById('empPhone').style.display = "block";
      document.getElementById('empEmail').style.display = "block";
      document.getElementById('empAddress').style.display = "block";
      document.getElementById('empPswd').style.display = "block";
      document.getElementById('modalFooter').style.display = "block";

    }
  })
}

function activeInactiveEmp(staffId, isActive){

  $.ajax({
    url: "<?= base_url('CompanyAdminController/activeInactiveStaff') ?>",
    type: 'POST',
    data: {
      staffId : staffId,
      isActive : isActive,
    },
    success: function(response) {
      window.location.href = "<?php echo base_url('staff')?>";
    }
  })
}

// To validate the model
function validateModal(){

  // Validate Name
  var name = document.getElementById("empNameInput").value;
  var err_emp_name = document.getElementById("err_emp_name");
  var patternName = /([a-zA-Z_-]){3,15}$/g;
           
  if(name.match(patternName)){

    err_emp_name.innerHTML = "";

  }else{           
    document.getElementById("empNameInput").focus();      
    err_emp_name.style.color = "red";
    err_emp_name.style.fontSize = "12px";                                
    err_emp_name.innerHTML = "Wrong";
    return false;            
  }

  //Contact person number

  var empNumber = document.getElementById('empPhoneInput').value;
  var err_emp_phone = document.getElementById('err_emp_phone');
  var patternContact = /([0-9-+]){8,12}$/g;

  if(empNumber.match(patternContact))
  {              
    err_emp_phone.innerHTML = "";
                   
  }else{            
    document.getElementById("empPhoneInput").focus();        
    err_emp_phone.style.fontSize = "12px";                          
    err_emp_phone.style.color = "red";
    err_emp_phone.innerHTML = "Wrong";  
    return false;                
  }

  //Email Address
  var empEmail = document.getElementById('empEmailInput').value;
  var err_emp_email = document.getElementById("err_emp_email");
  var patternEmpEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/g;
            
  if(empEmail.match(patternEmpEmail))
  {
                
  err_emp_email.innerHTML = "";    
                                       
  }else{
  document.getElementById("empEmailInput").focus();
  err_emp_email.style.fontSize = "12px";                      
  err_emp_email.style.color = "red";
  err_emp_email.innerHTML = "Wrong";
  return false;
  }

  //Address
  var empAdd = document.getElementById('empAddressInput').value;
  var err_emp_address = document.getElementById('err_emp_address');
  var patternEmpAdd = /([a-zA-Z0-9_-]){3,20}$/g;

  if(empAdd.match(patternEmpAdd))
  {  
    err_emp_address.innerHTML = "";    
                  
  }else{
    document.getElementById("empAddressInput").focus();     
    err_emp_address.style.fontSize = "12px";                      
    err_emp_address.style.color = "red";
    err_emp_address.innerHTML = "Wrong";  
    return false;                
  }   

  //company admin password

  var cAdminPswd = document.getElementById('empPswdInput').value;
  var err_emp_pswd = document.getElementById('err_emp_pswd');
  var patterncAdminPswd = /([a-zA-Z0-9-]){3,15}$/g;

  if(cAdminPswd.match(patterncAdminPswd))
  {              
    err_emp_pswd.innerHTML = "";                   
  }else{
    document.getElementById('empPswdInput').focus();
    err_emp_pswd.style.fontSize = "12px";                      
    err_emp_pswd.style.color = "red";
    err_emp_pswd.innerHTML = "Wrong";
    return false;                
  }

}
  
</script>

</html>