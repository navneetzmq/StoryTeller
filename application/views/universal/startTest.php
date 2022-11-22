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

    <!-- <//?php var_dump($storyOrGeneric);?> -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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
                        <button type="button" id="dismissId" class="close" onclick="closeModal()" data-dismiss="modal" aria-label="Close">Close
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="margin-left: 20px">
                        <!-- Emp Name -->
                        <h5 id="testTime"></h5>
                        <h5>All questions are Mandatory</h5>
                        <h5>No negative marking</h5>
                        <h5>Question type can be either MCQ or Single-Choice</h5>
                        <h5>Test Result will display only once (Immediately after test submittion)</h5>
                        <h5 id="allowPrevious"></h5>
                        <h5 id="scoreBase"></h5>
                        <h5 id="autoplayAudio"></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Modal -->

        <!-- <pre></?php var_dump($quesData[0]['questionId'] ); ?></pre> -->
        <div id="timerArea" class="d-flex justify-content-center">
            <strong id="timer" style="margin-right: 40px"></strong>
        </div>
        <?php
        for($i = 0; $i < (count($quesData)); $i++){
            $cardIdStr = "cardId";
            $optImgStr = "optImage";
            $cardId = $cardIdStr.($i+1);
            $btnIdStr = "BtnId";
            $btnId = $btnIdStr.($i+1);
            $quesId = $quesData[$i]['questionId'];
            $dbAns = $quesData[$i]['optNmbrForAns'];
            $ansStatusIdStr = "ansStatus";
            $ansStatusId = $ansStatusIdStr.($i+1);
            $quesAudioId = "quesAudio".$i;
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
                                    <strong>Answer Type<?php echo("")?>: </strong><?php echo("Multiple Choice");?>
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
                                <audio controls id="<?php echo($quesAudioId);?>">
                                    <source src="<?php echo(base_url($quesData[$i]['qAudio']));?>" type="audio/mpeg" />
                                </audio>
                            </p>
                        <?php } ?>
                    </div>
                    <hr>
                    <!-- Options for question -->
                    <div class="row">
                        <p class="col-lg-8"><strong>Select your answer :</strong></p>
                        <p class="col-lg-2"><strong id="<?php echo($ansStatusId);?>" class="float-right"></strong></p>
                        <?php
                        if($rules['showStatus'] == 1){
                        ?>
                            <p id="btnCheckAnsArea" class="col-lg-2" style="display:inline;"><button id="btnCheckAns" type="button" class="btn btn-outline-info btn-sm" style="color:black;" onclick="checkAnswer('<?= $quesId?>','<?= $dbAns?>','<?= $ansStatusId?>');">Check Answer</button></p>
                        <?php
                        }
                        ?>
                    </div>
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
                    <!-- <div id="</?php echo($optId);?>"></div> -->
                    <hr style="border: 1px solid skyblue;">
                    <button id="<?php echo('pre'.$btnId);?>" class="btn btn-primary btn-sm" onclick="preBtnClicked()"><< Previous</button>
                    <button id="<?php echo('nxt'.$btnId);?>" class="btn btn-primary btn-sm" style="margin-left: 30px;" onclick="nxtBtnClicked()">Next >></button>
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
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="background-color: skyblue; color: black;">
                    <div class="modal-header" style="text-align: center;">
                        <h3 class="modal-title" id="exampleModalLabel">Well Done : <strong><span id="nameId"></span></strong></h3>
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

    let rulesJson = `<?php echo json_encode($rules)?>`;
    let rules = JSON.parse(rulesJson);
    let playerId = <?php echo($playerId)?>;
    let quesJson = `<?php echo json_encode($quesData)?>`; // Converting php array to JSON String
    let quesData = JSON.parse(quesJson); // Converting JSON to JS object
    let storyOrGenericJson = `<?php echo json_encode($storyOrGeneric)?>`;
    let storyOrGeneric = JSON.parse(storyOrGenericJson);
    let totalQues = quesData.length;
    document.getElementById('submitId').style.display = 'none';
    function testTimer(){
        var minutes = totalQues; //totalQues;
        var seconds = 59;
        var interval = setInterval(function(){
            document.getElementById('timer').style.color = "red";
            document.getElementById('timer').innerHTML = minutes + " : " + seconds + " Left";
            seconds--;
            if(seconds <= 0){
                minutes--;
                seconds = 59;
            }
            if(minutes < 0){
                clearInterval(interval);
                document.getElementById('timer').style.color = "red";
                document.getElementById('timer').innerHTML = "Time Out!";
                document.getElementById("btnSubmit").click();
            }
        }, 1000);
    }

    $(window).on('load', function() {
        document.getElementById('submitId').style.display = 'none';
        document.getElementById('testErr').style.display = 'none';
        if(rules['allowPrevious'] == 1){
            document.getElementById('allowPrevious').innerHTML = "Jump to Previous Question : Allowed!";
        }
        else{
            document.getElementById('allowPrevious').innerHTML = "Jump to Previous Question : Not-Allowed!";
        }
        if(rules['distinctScore'] == 1){
            document.getElementById('scoreBase').innerHTML = "Questions may have distinct score!";
        }
        else{
            document.getElementById('scoreBase').innerHTML = "All questions have similar score!";
        }
        if(rules['autoplayAudio'] == 1){
            document.getElementById('autoplayAudio').innerHTML = "Quesion Audio is autoplay!";
        }
        else{
            document.getElementById('autoplayAudio').innerHTML = "Question Audio is not autoplay!";
        }
        if(rules['testTime'] == 1){
            document.getElementById('testTime').innerHTML = "Time started! You've got 1 minute extra to read rules!";
        }
        else{
            document.getElementById('testTime').innerHTML = "No Time limit (Test need to be submitted manually)!";
        }
        $('#preTestModalId').modal({backdrop: 'static', keyboard: false});
        $('#preTestModalId').modal('show');
    });

    var preAud;
    // Close molad "keep in mind"
    function closeModal(){
        if(rules['autoplayAudio'] == "1"){
            if(quesData[0]['qAudio'] != ""){
                var quesAudioId = "quesAudio".concat("0");
                preAud = document.getElementById(quesAudioId);
                document.getElementById(quesAudioId).play();
            }
        }
    }

    if(rules['testTime'] == 1){
        testTimer();
    }

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
        
        if(rules['allowPrevious'] == 1){
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
        else{
            document.getElementById(preBtnId).disabled = true;
            if(i == 1){
                document.getElementById(cardId).style.display = 'block';
                document.getElementById(preBtnId).disabled = true;
                document.getElementById(nxtBtnId).disabled = false;
                document.getElementById('submitId').style.display = 'block';
            }
            else if(i == totalQues){
                document.getElementById(cardId).style.display = 'none';
                document.getElementById(preBtnId).disabled = true;
                document.getElementById(nxtBtnId).disabled = true;
                document.getElementById('submitId').style.display = 'block';
            }
            else{
                document.getElementById(cardId).style.display = 'none';
                document.getElementById('submitId').style.display = 'none';
            }
        }
    }

    // Check Answer
    function checkAnswer(quesId, dbAns, ansStatusId){
        let ansObj = {};
        for(var i = 0; i < totalQues; i++){
            $('#'+ansStatusId).fadeIn();
            if(quesData[i]['questionId'] == quesId){
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
                        var obj = document.getElementById(checkId);
                        if((obj) && (document.getElementById(checkId).checked)){
                            var checkedVal = document.getElementById(checkId).value;
                            ansObj['answer'] += checkedVal;
                            ansObj['answer'] += ",";
                        }
                        countOpt++;
                    }
                    ansObj['answer'] = ansObj['answer'].replace(/,+$/, '');
                }
            }
        }
        if(ansObj['answer'] == dbAns){
            // correct
            document.getElementById(ansStatusId).innerHTML = "Correct!";
            document.getElementById(ansStatusId).style.color = "green";
            setTimeout(function() {
                $('#'+ansStatusId).fadeOut('fast');
            }, 1300);
        }
        else{
            // incorrect
            document.getElementById(ansStatusId).innerHTML = "Incorrect!";
            document.getElementById(ansStatusId).style.color = "red";
            setTimeout(function() {
                $('#'+ansStatusId).fadeOut('fast');
            }, 1200);
        }
    }

    var countClick = 1;
    // When click on PreBtn
    function preBtnClicked(){
        if(preAud){
            preAud.pause();
        }
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
        if(preAud){
            preAud.pause();
        }
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
        if(rules['autoplayAudio'] == "1"){
            if(quesData[countClick]['qAudio'] != ""){
                var quesAudioId = "quesAudio".concat(countClick);
                document.getElementById(quesAudioId).play();
                preAud = document.getElementById(quesAudioId);
                console.log(preAud);
            }
        }
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
            if(storyOrGeneric == 1){
                // it is story
                ansObj['storyId'] = quesData[i]['storyId'];
                ansObj['genericId'] = 0;
            }
            else{
                // it is generic
                ansObj['genericId'] = quesData[i]['genericId'];
                ansObj['storyId'] = 0;
            }
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
        }
        // If test time is enabled test will autosubmit and display result
        if(rules['testTime'] == 1){
            getResult(allAns);
        }

        // if test time is not enabled
        if(rules['testTime'] != 1){
            // also require to attempt all the questions
            if((countAttemptedQues == totalQues)){
                getResult(allAns);
            }
            else{
                document.getElementById('testErrText').innerHTML = "Error : All questions must be attempted!";
                document.getElementById('testErr').style.display = 'block';
            }
        }
    }

    function getResult(allAns){
        $.ajax({
            url: "<?= base_url('OpenPlayerController/submitTestdata') ?>",
            type: 'POST',
            data: {
                testData : JSON.stringify(allAns)
            },
            success: function(response) {
                response = JSON.parse(response);
                // console.log(response);
                if(response){
                    document.getElementById('nameId').innerHTML = response['playerName']+" !";
                    document.getElementById('storyTitleId').innerHTML = response['storyTitle'];
                    document.getElementById('totalQuesId').innerHTML = totalQues;
                    document.getElementById('correctAnsId').innerHTML = response['countCorrect'];
                    document.getElementById('scoreId').innerHTML = response['countCorrect']+" / "+totalQues;
                    $('#exampleModal').modal({backdrop: 'static', keyboard: false});
                    $("#exampleModal").modal('show');
                }
            }
        })
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