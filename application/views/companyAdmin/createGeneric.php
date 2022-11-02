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
                    <li class="breadcrumb-item"><a href="#">Create Generic</a></li>
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
                    <form method="POST" action="<?= base_url('CompanyAdminController/saveGenericData');?>">

                        <!-- Story title -->

                        <?php
                            if(isset($userData)){
                                if($userData['level'] == "1"){
                        ?>
                        <div class="form-group">
                            <label for="">Generic Title</label>
                            <input type="text" class="form-control" id="genericTitleId" name="genericTitle" placeholder="">
                            <div id="err_storyTitle"></div>
                        </div>
                        <?php
                            }}
                        ?>                     

                        <div class="col-auto float-right">  
                            <button type="submit" class="btn btn-primary btn-user btn-block" onclick="return genericValidation();">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        function genericValidation()
        {
            var storyTitle = document.getElementById("genericTitleId").value;
            var err_storyTitle = document.getElementById("err_storyTitle");
            var patternStoryTitle = /([a-zA-Z_-]){3,15}$/g;

            if(storyTitle.match(patternStoryTitle))
            {
                err_storyTitle.innerHTML = "";                                
            }else{           
                document.getElementById("genericTitleId").focus();   
                err_storyTitle.style.color = "red";
                err_storyTitle.style.fontSize = "12px";                                
                err_storyTitle.innerHTML = "Wrong";  
                return false;                
            }
        }
    </script>
</html>