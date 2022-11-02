<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Test</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/adminAssets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/adminAssets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</head>

<body id="page-top">

    <!-- </?php var_dump($playerId);?> -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        
                        <li class="nav-item dropdown no-arrow">

                            <!-- Content Writer Logout -->

                            <?php if(isset($userData['level'])){
                                if ($userData['level'] == '1') {
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Company Admin
                                | <?php print_r($userData['loginId']); ?> </span>
                            </a>
                            <?php }} ?>

                            <!-- Trainer Logout -->

                            <?php if(isset($userData['level'])){
                                if ($userData['level'] == '3') {
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Trainer  
                                | <?php print_r($userData['loginId']); ?> </span>
                            </a>
                            <?php }} ?>

                            <!-- Trainer Logout -->

                            <?php if(isset($userData['level'])){
                                if ($userData['level'] == '5') {
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Player  
                                | <?php print_r($userData['loginId']); ?> </span>
                            </a>
                            <?php }} ?>


                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">   
                                <?php 
                                    $userData = $this->session->userdata('userData');
                                // print_r($userData);
                                if(isset($userData['level'])){
                                if ( $userData['level'] == '0' || $userData['level'] == '1' || $userData['level'] == '2' || $userData['level'] == '3') {
                                    ?>
                                    <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                        -> Logout
                                    </a>  
                                <?php } } ?> 
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- End of Topbar -->

        <!-- Modal to Show before begin test -->
        <div class="modal fade bd-example-modal-lg" id="preTestModalId" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: skyblue; color: black;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel"><strong>Keep in Mind :</strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="margin-left: 20px">
                        <!-- Emp Name -->
                        <div class="row">
                            <h5>1. All questions are Mandatory</h5>
                        </div>
                        <div class="row">
                            <h5>2. No negative marking</h5> 
                        </div>
                        <div class="row">
                            <h5>3. Question type can be either MCQ or Single-Choice</h5>
                        </div>
                        <div class="row">
                            <h5>4. Test Result will display only once (immediately after submitting the test)</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Modal -->

        <!-- <pre><//?php var_dump($quesData); ?></pre> -->
        <?php
        for($i = 0; $i < (count($quesData)); $i++){
            $cardIdStr = "cardId";
            $optImgStr = "optImage";
            $cardId = $cardIdStr.($i+1);
            $btnIdStr = "BtnId";
            $btnId = $btnIdStr.($i+1);
        ?>
        <div class="card" id="<?php echo($cardId);?>" style="padding: 0 10%; border: none;">
            <div class="card-body">
                <div class="card-title">
                    <div class="row">
                        <?php
                        if($quesData[$i]['isMCQ'] == 0){
                        ?>
                            <div class="col-lg-4">
                                <strong>Answer Type<?php echo(" ")?>: </strong><?php echo("Single Choice");?>
                            </div>
                        <?php
                        }
                        else{
                        ?>
                            <div class="col-lg-4">
                                <strong>Answer Type<?php echo(" ")?>: </strong><?php echo("Multiple Choice");?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <hr style="border: 1px solid skyblue;">
                    <div class="row">
                    <p class="card-text col-lg-6"><strong>Ques.<?php echo(($i+1))." Text ";?>: </strong><?php echo($quesData[$i]['qText']);?></p>
                    <?php if($quesData[$i]['qImage'] != "") { ?>
                        <p class="card-text col-lg-2">
                            <img src="<?php echo(base_url($quesData[$i]['qImage'])); ?>" alt="" height="50">
                        </p>
                    <?php } ?>
                    <?php if($quesData[$i]['qAudio'] != "") { ?>
                        <p class="card-text col-lg-4">
                            <audio controls>
                                <source src="<?php echo(base_url($quesData[$i]['qAudio']));?>" type="audio/mpeg">
                            </audio>
                        </p>
                    <?php } ?>
                </div>
                <hr>
                    <!-- Options for question -->
                    <p><strong>Select your answer :</strong></p>
                    <?php
                    if(($quesData[$i]['isMCQ']) == '0'){  // Creating Radio options
                        $j = 1;
                        $optStr = "opt";
                        while($j <= 5) {
                            $radioName = "q".($i+1)."radioName";
                            $optTxt = $optStr.($j);
                            $optImg = $optImgStr.($j);
                            if((($quesData[$i][$optTxt]) != "") && (($quesData[$i][$optImg]) != "")) { ?>
                            <div class="row">
                                <div style="margin-left: 20px; margin-right: 10px;">
                                    <input type="radio" name="<?php echo($radioName);?>" value="<?php echo($j);?>">
                                </div>
                                <div class="col-lg-1">
                                    <label><?php echo($quesData[$i][$optTxt]);?></label>
                                </div>
                                <div class="col-lg-1">
                                    <label><img src="<?php echo(base_url($quesData[$i][$optImg]));?>" alt="" height="50"></label>
                                </div>
                            </div>
                            <?php }

                            else if((($quesData[$i][$optTxt]) != "") && (($quesData[$i][$optImg]) == "")) { ?>
                                <div class="row">
                                    <div style="margin-left: 20px; margin-right: 10px;">
                                        <input type="radio" name="<?php echo($radioName);?>" value="<?php echo($j);?>">    
                                    </div>
                                    <div class="col-lg-1">
                                        <label><?php echo($quesData[$i][$optTxt]);?></label>
                                    </div>
                                </div>
                            <?php }
                            
                            else if((($quesData[$i][$optTxt]) == "") && (($quesData[$i][$optImg]) != "")) { ?>
                                <div class="row">
                                    <div style="margin-left: 20px; margin-right: 10px;">
                                        <input type="radio" name="<?php echo($radioName);?>" value="<?php echo($j);?>">
                                    </div>
                                    <div class="col-lg-1">
                                        <label><img src="<?php echo(base_url($quesData[$i][$optImg]));?>" alt="" height="50"></label>
                                    </div>
                                </div>
                            <?php }
                            $j++;
                        }
                    }
                    else {   // Creating Checkbox options
                        $j = 1;
                        $optStr = "opt";
                        while($j <= 5) {
                            $checkboxId = "q".($i+1)."check".$j;
                            $optTxt = $optStr.($j);
                            $optImg = $optImgStr.($j);
                            if((($quesData[$i][$optTxt]) != "") && (($quesData[$i][$optImg]) != "")) {?>
                            <div class="row">
                                <div style="margin-left: 20px; margin-right: 10px;">
                                    <input type="checkbox" id="<?php echo($checkboxId);?>" value="<?php echo($j);?>">
                                </div>
                                <div class="col-lg-1">
                                    <label><?php echo($quesData[$i][$optTxt]);?></label>
                                </div>
                                <div class="col-lg-1">
                                    <label><img src="<?php echo(base_url($quesData[$i][$optImg]));?>" alt="" height="50"></label>
                                </div>
                            </div>
                            <?php }

                            else if((($quesData[$i][$optTxt]) != "") && (($quesData[$i][$optImg]) == "")) { ?>
                                <div class="row">
                                    <div style="margin-left: 20px; margin-right: 10px;">
                                        <input type="checkbox" id="<?php echo($checkboxId);?>" value="<?php echo($j);?>">
                                    </div>
                                    <div class="col-lg-1">
                                        <label><?php echo($quesData[$i][$optTxt]);?></label>
                                    </div>
                                </div>
                            <?php }
                            
                            else if((($quesData[$i][$optTxt]) == "") && (($quesData[$i][$optImg]) != "")) { ?>
                                <div class="row">
                                    <div style="margin-left: 20px; margin-right: 10px;">
                                        <input type="checkbox" id="<?php echo($checkboxId);?>" value="<?php echo($j);?>">
                                    </div>
                                    <div class="col-lg-1">
                                        <label><img src="<?php echo(base_url($quesData[$i][$optImg]));?>" alt="" height="50"></label>
                                    </div>
                                </div>
                            <?php }
                            $j++;
                        }
                    }?>

                    <!-- Dynamic options for question -->
                    <!-- <div id="</?php echo($optId);?>"></div> -->
                    <hr style="border: 1px solid skyblue;">
                    <button id="<?php echo('pre'.$btnId);?>" class="btn btn-primary btn-sm" onclick="preBtnClicked()"><<- Previous</button>
                    <button id="<?php echo('nxt'.$btnId);?>" class="btn btn-primary btn-sm" style="margin-left: 30px;" onclick="nxtBtnClicked()">Next ->></button>
                </div>  
            </div>
        </div>
        <?php
        }
        ?>
        <!-- Submit button -->
                    
        <div class="float-right" id="submitId" style="padding: 1% 20%; display: none;">
            <input id="btnSubmit" type="button" class="btn btn-success mb-2 btn-sm" name="submit" value="Submit" onclick="submitTest();">
        </div>
        <!-- Error msg if player not attempted all the messages -->
        <div id="testErr">
            <h4 id="testErrText" style="margin-left: 200px; color: red;"></h4   >
        </div>
        <!-- End of test -->

        <!-- Modal to show result -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: skyblue; color: black;">
                    <div class="modal-header" style="text-align: center;">
                        <h3 class="modal-title" id="exampleModalLabel">Well Done : <strong><span id="nameId"></span></strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="margin-left: 40px">
                        <!-- Emp Name -->
                        <div class="row">
                            <h5>Story Played : <span id="storyTitleId"></span></h5>
                        </div>
                        <div class="row">
                            <h5>Total Qusestions : <span id="totalQuesId"></span></h5>
                        </div>
                        <div class="row">
                            <h5>Correct Aswers : <span id="correctAnsId"></span></h5>
                        </div>
                        <div class="row">
                            <h5>Your Score : <strong><span id="scoreId"></span></strong></h5>
                        </div>

                        <form method="POST" action="<?= base_url('OpenPlayerController/resultOk');?>">
                            <div class="modal-footer" id="modalFooter">
                                <button type="submit" class="btn btn-primary">Done!</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- End of Modal -->

<script>

    $(window).on('load', function() {
        document.getElementById('submitId').style.display = 'none';
        document.getElementById('testErr').style.display = 'none';
        $('#preTestModalId').modal('show');
    });
    
    var playerId = <?php echo($playerId)?>;
    var quesJson = `<?php echo json_encode($quesData)?>`; // Converting php array to JSON String
    var quesData = JSON.parse(quesJson); // Converting JSON to JS object
    var totalQues = quesData.length;
    // console.log(quesData);
    document.getElementById('submitId').style.display = 'none';
    // On page load
    if(totalQues == 1){
        document.getElementById('preBtnId1').disabled = true;
        document.getElementById('nxtBtnId1').disabled = true;
        document.getElementById('submitId').style.display = 'block';
    }

    // Enable-disable buttons and load next-previous questions
    for(let i = 1; i <= totalQues; i++){
        var cardStr = "cardId";
        var optionStr = "opt";
        var preBtnStr = "preBtnId";
        var nxtBtnStr = "nxtBtnId";
        var idNumber = i.toString();
        var cardId = cardStr.concat(idNumber);
        var optId = optionStr.concat(idNumber);
        var preBtnId = preBtnStr.concat(idNumber);
        var nxtBtnId = nxtBtnStr.concat(idNumber);

        if(i == 1){
            document.getElementById(cardId).style.display = 'block';
            document.getElementById(preBtnId).disabled = true;
            document.getElementById(nxtBtnId).disabled = false;
            document.getElementById('submitId').style.display = 'block';
        }
        else if(i == totalQues){
            document.getElementById(cardId).style.display = 'none';
            document.getElementById(preBtnId).disabled = false;
            document.getElementById(nxtBtnId).disabled = true;
            document.getElementById('submitId').style.display = 'block';
        }
        else{
            document.getElementById(cardId).style.display = 'none';
            document.getElementById('submitId').style.display = 'none';
        }
    }

    var countClick = 1;
    // When click on PreBtn
    function preBtnClicked(){
        // document.getElementById('submitId').style.display = 'none';
        document.getElementById('testErr').style.display = 'none';
        document.getElementById('submitId').style.display = 'none';
        var cardStr = "cardId";
        var preBtnStr = "preBtnId";
        var idNumber = countClick.toString();
        var cardId = cardStr.concat(idNumber);
        var preBtnId = preBtnStr.concat(idNumber);
        var temp = countClick-1;
        var preIdNumber = temp.toString();
        var preCardId = cardStr.concat(preIdNumber);
        document.getElementById(cardId).style.display = 'none';
        document.getElementById(preCardId).style.display = 'block';
        countClick--;
        if(countClick == totalQues){
            document.getElementById('submitId').style.display = 'block';
        }
        else{
            document.getElementById('submitId').style.display = 'none';
        }
    }

    // When click on nxtBtn
    function nxtBtnClicked(){
        document.getElementById('submitId').style.display = 'none';
        document.getElementById('testErr').style.display = 'none';
        var cardStr = "cardId";
        var nxtBtnStr = "nxtBtnId";
        var idNumber = countClick.toString();
        var cardId = cardStr.concat(idNumber);
        var nxtBtnId = nxtBtnStr.concat(idNumber);
        var temp = countClick+1;
        var nxtIdNumber = temp.toString();
        var nxtCardId = cardStr.concat(nxtIdNumber);
        document.getElementById(cardId).style.display = 'none';
        document.getElementById(nxtCardId).style.display = 'block';
        countClick++;
        if(countClick == totalQues){
            document.getElementById('submitId').style.display = 'block';
        }
        else{
            document.getElementById('submitId').style.display = 'none';
        }
    }

    // Collecting the answers given by user (On click submit button)
    let countAttemptedQues = 0;
    function submitTest(){
        let allAns = [];
        let sessionId = Date.now();
        sessionId = sessionId.toString();
        for(let i = 0; i < totalQues; i++){
            let ansObj = {};
            ansObj['sessionId'] = sessionId;
            ansObj['questionId'] = quesData[i]['questionId'];
            ansObj['palyerId'] = playerId;
            ansObj['storyId'] = quesData[i]['storyId'];
            ansObj['score'] = quesData[i]['weight'];
            // Collecting if options are Radio buttons
            if(quesData[i]['isMCQ'] == '0'){
                var radioNameStr = "radioName";
                var radioNum = (i+1).toString();
                var radioName = "q"+radioNum+radioNameStr;
                if(document.querySelector('input[name='+radioName+']:checked')){
                    ansObj['answer'] = document.querySelector('input[name='+radioName+']:checked').value;
                }
                else{
                    ansObj['answer'] = "";
                }
                allAns.push(ansObj);
                // console.log(allAns);
            }
            // Collecting if options are checkboxes
            else{
                var countOpt = 1;
                var checkIdStr = "check";
                var checkNum = (i+1).toString();
                var optStr = "opt";
                var countOptStr = countOpt.toString();
                var optNum = optStr.concat(countOptStr);
                var checkedArr = [];
                ansObj['answer'] = '';
                while(countOpt <= 5){
                    var countOptNum = countOpt.toString();
                    var checkId = "q"+checkNum+checkIdStr+countOptNum;
                    // console.log(checkId);
                    var obj = document.getElementById(checkId);
                    // console.log(obj);
                    if((obj) && (document.getElementById(checkId).checked)){
                        var checkedVal = document.getElementById(checkId).value;
                        ansObj['answer'] += checkedVal;
                        ansObj['answer'] += ",";
                        // alert(checkedVal);
                    }
                    // else{
                    //     ansObj['answer'] = "";
                    // }
                    countOpt++;
                }
                ansObj['answer'] = ansObj['answer'].replace(/,+$/, '');
                allAns.push(ansObj);
            }
        }
        for(let i = 0; i < totalQues; i++){
            if(allAns[i]['answer'] != ""){
                countAttemptedQues++;
            }
            else{
                break;
            }
            // console.log(allAns);
        }

        if(countAttemptedQues == totalQues){
            // Ajax to save session data in dataBase
            $.ajax({
                url: "<?= base_url('OpenPlayerController/submitTestdata') ?>",
                type: 'POST',
                data: {
                    testData : JSON.stringify(allAns)
                },
                success: function(response) {
                    response = JSON.parse(response);
                    console.log(response);
                    if(response){
                        document.getElementById('nameId').innerHTML = response['playerName']+" !";
                        document.getElementById('storyTitleId').innerHTML = response['storyTitle'];
                        document.getElementById('totalQuesId').innerHTML = totalQues;
                        document.getElementById('correctAnsId').innerHTML = response['countCorrect'];
                        document.getElementById('scoreId').innerHTML = response['countCorrect']+" / "+totalQues;
                        $("#exampleModal").modal('show');
                        // window.location.href = "</?php echo base_url('test')?>";
                    }
                }
            })
        }
        else{
            document.getElementById('testErrText').innerHTML = "Error : All questions must be attempted!";
            document.getElementById('testErr').style.display = 'block';
        }
    }

</script>



    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/adminAssets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/adminAssets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/adminAssets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/adminAssets/js/sb-admin-2.min.js'); ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/adminAssets/vendor/chart.js/Chart.min.js'); ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/adminAssets/js/demo/chart-area-demo.js'); ?>"></script>
    <script src="<?= base_url('assets/adminAssets/js/demo/chart-pie-demo.js'); ?>"></script>

</body>

</html>