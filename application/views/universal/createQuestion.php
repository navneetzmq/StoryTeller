<html>
    <head>
    </head>
    <body>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Add New Question</li>
                </ol>
            </nav>
            <div class="col-md-9 mx-auto">
                <?php if($this->session->flashdata('add_company_admin')) { ?>
                <?php echo '<p class="alert alert-success mt-3 text-center" id="add">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>' 
                .$this->session->flashdata('add_company_admin') . '</p>'; ?>
                <?php } $this->session->unset_userdata('add_company_admin'); //unset session ?>

                <div class="card">
                    <div class="card-body">
                    <!-- form -->
                        <form method="POST" action="<?= base_url('SuperAdminController/saveQuestionData');?>">

                            <!-- Dropdown to select Story -->
                            
                            <div class="form-group">
                                <label id="labelId" for="">Select Story</label>
                                <select id="storyId" name="storyId" class="form-control">
                                    <option value="" selected>Select Story</option>

                                    <?php 
                                    if(isset($storyData) && !empty($storyData)){
                                        for($i = 0 ; $i < count($storyData); $i++) { ?>
                                            <?php if(isset($storyData[$i]->storyId)){ ?>
                                                <option value="<?= $storyData[$i]->storyId; ?>">
                                                <?= $storyData[$i]->storyTitle; ?>
                                                - [ <span>Pre(<?= $storyData[$i]->totalPre; ?>)</span>  
                                                / <span>Post(<?= $storyData[$i]->totalPost; ?>)</span>]
                                            <?php }?>
                                                </option>
                                    <?php }} ?>
                                </select>
                                <div id="err_story"></div>
                            </div>

                            <div id="hideForm">
                                <div class="form-group">
                                    <label for="">Question Text</label>
                                    <input type="text" class="form-control" id="questionId" name="question" placeholder="">
                                    <div id="err_question"></div>
                                </div>

                                <!-- How many Options the Question has ? -->
                                <div class="form-group" id="radioBtn">
                                    <label for="">How many options to answer?</label>   
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="2" name="option" id="id2" onchange="openOptionField(2);">
                                        <label class="form-check-label" for="id2">Two</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="3" name="option" id="id3" onchange="openOptionField(3);">
                                        <label class="form-check-label" for="id3">Three</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="4" name="option" id="id4" onchange="openOptionField(4);">
                                        <label class="form-check-label" for="id4">Four</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="5" name="option" id="id5" onchange="openOptionField(5);">
                                        <label class="form-check-label" for="id5">Five</label>
                                    </div>
                                    <div id="err_optionCount"></div>
                                </div>

                                <!------------- options for question ------------->

                                <div class="form-group" id="optionArea1" style="display: none;">
                                    <label for="">Option-A</label>
                                    <input type="text" class="form-control" id="optId1" name="optA" placeholder="">
                                    <div id="err_optId1"></div>
                                </div>

                                <div class="form-group" id="optionArea2" style="display: none;">
                                    <label for="">Option-B</label>
                                    <input type="text" class="form-control" id="optId2" name="optB" placeholder="">
                                    <div id="err_optId2"></div>
                                </div>

                                <div class="form-group" id="optionArea3" style="display: none;">
                                    <label for="">Option-C</label>
                                    <input type="text" class="form-control" id="optId3" name="optC" placeholder="">
                                    <div id="err_optId3"></div>
                                </div>

                                <div class="form-group" id="optionArea4" style="display: none;">
                                    <label for="">Option-D</label>
                                    <input type="text" class="form-control" id="optId4" name="optD" placeholder="">
                                    <div id="err_optId4"></div>
                                </div>

                                <div class="form-group" id="optionArea5" style="display: none;">
                                    <label for="">Option-E</label>
                                    <input type="text" class="form-control" id="optId5" name="optE" placeholder="">
                                    <div id="err_optId5"></div>
                                </div>

                                <!-- Has score -->
                                <div class="form-group" id="hasScoreDiv">
                                    <label for="">Has Score ?</label>
                                    <select id="hasScoreId" name="hasScore" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1">Yes, has Score</option>
                                        <option value="0">No!, Dosen't has Score</option> 
                                    </select>
                                    <div id="err_hasScore"></div>
                                </div>

                                <!-- Question weight -->
                                <div class="form-group" id="weightId">
                                    <label for="">Weight</label>
                                    <input type="text" class="form-control" id="weight" name="weight" placeholder="">
                                    <div id="err_weight"></div>
                                </div>

                                <!-- Queston Type -->
                                <div class="form-group">
                                    <label for="">Question Type</label>
                                    <select id="quesTypeId" name="quesType" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="0">Single Choice</option>
                                        <option value="1">Multiple Choice</option> 
                                    </select>
                                    <div id="err_quesType"></div>
                                </div>

                                <!-- Radio buttons to select aswers-->
                                <div class="form-group">
                                    <label for="" id="selectAnsRadioId">Choose your Answer :</label>
                                    <div class="form-check" id="ansRadioId1">
                                        <input class="form-check-input" type="radio" id="ansRid1" name="selectAnsRadio">
                                        <label class="form-check-label" id="optradioLabel1" for="ansRid1"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId2">
                                        <input class="form-check-input" type="radio" id="ansRid2" name="selectAnsRadio">
                                        <label class="form-check-label" id="optradioLabel2" for="ansRid2"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId3">
                                        <input class="form-check-input" type="radio" id="ansRid3" name="selectAnsRadio">
                                        <label class="form-check-label" id="optradioLabel3" for="ansRid3"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId4">
                                        <input class="form-check-input" type="radio" id="ansRid4" name="selectAnsRadio">
                                        <label class="form-check-label" id="optradioLabel4" for="ansRid4"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId5">
                                        <input class="form-check-input" type="radio" id="ansRid5" name="selectAnsRadio">
                                        <label class="form-check-label" id="optradioLabel5" for="ansRid5"></label>
                                    </div>
                                    <div id="err_selectAnsRadio"></div>
                                </div>

                                <!-- Checkboxes to select aswers -->
                                <div class="form-group">
                                    <label for="" id="selectAnsCheckId">Select your Answer :</label>
                                    <div class="form-check" id="ansCheckId1">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid1" name="ansCid1" value="">
                                        <label class="form-check-label" id="optCheckLabel1" for="ansCid1">One</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId2">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid2" name="ansCid2" value="">
                                        <label class="form-check-label" id="optCheckLabel2" for="ansCid2">Two</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId3">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid3" name="ansCid3" value="">
                                        <label class="form-check-label" id="optCheckLabel3" for="ansCid3">Three</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId4">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid4" name="ansCid4" value="">
                                        <label class="form-check-label" id="optCheckLabel4" for="ansCid4">Four</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId5">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid5" name="ansCid5" value="">
                                        <label class="form-check-label" id="optCheckLabel5" for="ansCid5">Five</label>
                                    </div>
                                    <div id="err_selectAnsCheck"></div>
                                </div>
                                    <div class="col-auto float-right"> 
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-user btn-block" onclick="return createQuesValidation();">Submit</button>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class="col-auto float-right"> 
                                        <input type="button" id="preBtn" class="btn btn-primary btn-user btn-block" value="Add Pre Question" onclick='loadForm()'>
                                    </div>  

                                    <div class="col-auto float-right"> 
                                        <input type="button" id="postBtn" class="btn btn-primary btn-user btn-block" value="Add Post Question" onclick='loadForm()'>
                                    </div>
                                </div> 

                                <!-- To hold the isPre value -->
                                <input type="text" name="isPreValue" id="isPreValueId">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </body>
<script>

let numOfOptions;
var option = ['A', 'B', 'C', 'D', 'E'];
var isPre;
var isMCQ;
var hasScoreValue;

// On page load
document.getElementById('isPreValueId').style.display = 'none';
document.getElementById('hideForm').style.display = 'none';
document.getElementById('preBtn').style.display = 'none';
document.getElementById('postBtn').style.display = 'none';

// When we select a Story
$('#storyId').on('change', function(){

    var storyId = this.value;

    $.ajax({
        url: "<?= base_url('SuperAdminController/checkStoryHasPreQues') ?>",
        type: 'POST',
        data: {
            storyId : storyId,
        },
        success: function(response) {
            response = JSON.parse(response);
            let prePost = response["prePostQues"];
            console.log(prePost);
            if(prePost == 1){
                document.getElementById('preBtn').style.display = 'block';
                document.getElementById('postBtn').style.display = 'none';
            }
            else if(prePost == 2){
                document.getElementById('preBtn').style.display = 'none';
                document.getElementById('postBtn').style.display = 'block';
            }
            else if(prePost == 3){
                document.getElementById('preBtn').style.display = 'block';
                document.getElementById('postBtn').style.display = 'block';
            }

        }
    })

});

$("#preBtn").on('click', function(){
    isPre = "1";
    document.getElementById('isPreValueId').value = isPre;
});

$("#postBtn").on('click', function(){
    isPre = "0";
    document.getElementById('isPreValueId').value = isPre;
});
// When we click on Buttons "Add Pre question" or "Add Post question"
function loadForm(){

    document.getElementById('preBtn').style.display = 'none';
    document.getElementById('postBtn').style.display = 'none';
    document.getElementById('storyId').style.display = 'none';
    document.getElementById('labelId').style.display = 'none';
    document.getElementById('hideForm').style.display = 'block';
    document.getElementById('weightId').style.display = 'none';
    document.getElementById('selectAnsRadioId').style.display = 'none';
    document.getElementById('ansRadioId1').style.display = 'none';
    document.getElementById('ansRadioId2').style.display = 'none';
    document.getElementById('ansRadioId3').style.display = 'none';
    document.getElementById('ansRadioId4').style.display = 'none';
    document.getElementById('ansRadioId5').style.display = 'none';
    document.getElementById('selectAnsCheckId').style.display = 'none';
    document.getElementById('ansCheckId1').style.display = 'none';
    document.getElementById('ansCheckId2').style.display = 'none';
    document.getElementById('ansCheckId3').style.display = 'none';
    document.getElementById('ansCheckId4').style.display = 'none';
    document.getElementById('ansCheckId5').style.display = 'none';
}

// When select, How many options the question has

function openOptionField(radioValue){
    numOfOptions = radioValue;
    // document.getElementById('radioBtn').style.display = 'none';
    var idStr = "optionArea";
    for(let i = 1; i <= radioValue; i++){
        var idNumber = i.toString();
        var id = idStr.concat(idNumber);
        document.getElementById(id).style.display = 'block';
    }
}

// The question has score, or not ?
$('#hasScoreId').on('change', function(){
    hasScoreValue = this.value;
    if(hasScoreValue == '1'){
        document.getElementById('weightId').style.display = 'block';
    }
    else{
        document.getElementById('weightId').style.display = 'none';
    }
});

// Load radio button or checkboxes (depends on single choice or MCQ)
$('#quesTypeId').on('change', function(){
    isMCQ = this.value;
    // Single Choice
    if(isMCQ == 0){
        document.getElementById('selectAnsCheckId').style.display = 'none';
        document.getElementById('ansCheckId1').style.display = 'none';
        document.getElementById('ansCheckId2').style.display = 'none';
        document.getElementById('ansCheckId3').style.display = 'none';
        document.getElementById('ansCheckId4').style.display = 'none';
        document.getElementById('ansCheckId5').style.display = 'none';
        document.getElementById('selectAnsRadioId').style.display = 'block';

        var optionLabelStr = "optradioLabel";
        var idStr = "ansRadioId";
        var optionIdStr = "optId";
        var ansInputStr = "ansRid";
        for(let i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var id = idStr.concat(idNumber);
            document.getElementById(id).style.display = 'block';  //To display radio buttons
            var optionId = optionIdStr.concat(idNumber);
            var labelId = optionLabelStr.concat(idNumber);
            var inputValue = document.getElementById(optionId).value; // Value of option
            document.getElementById(labelId).innerHTML = inputValue; //Option input value, insert to label
            var ansOptId = ansInputStr.concat(idNumber);
            document.getElementById(ansOptId).value = inputValue; //Giving option value to radio button
        }
    }
    // Multiple Choice
    if(isMCQ == 1){
        document.getElementById('selectAnsRadioId').style.display = 'none';
        document.getElementById('ansRadioId1').style.display = 'none';
        document.getElementById('ansRadioId2').style.display = 'none';
        document.getElementById('ansRadioId3').style.display = 'none';
        document.getElementById('ansRadioId4').style.display = 'none';
        document.getElementById('ansRadioId5').style.display = 'none';
        document.getElementById('selectAnsCheckId').style.display = 'block';

        var optionLabelStr = "optCheckLabel";
        var idStr = "ansCheckId";
        var optionIdStr = "optId";
        var ansInputStr = "ansCid";
        for(let i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var id = idStr.concat(idNumber);
            document.getElementById(id).style.display = 'block';
            var optionId = optionIdStr.concat(idNumber);
            var labelId = optionLabelStr.concat(idNumber);
            var inputValue = document.getElementById(optionId).value;
            document.getElementById(labelId).innerHTML = inputValue;
            var ansOptId = ansInputStr.concat(idNumber);
            document.getElementById(ansOptId).value = inputValue;
        }
    }
});

// ------------- The Form validation -----------

function createQuesValidation(){
    // Question Text
    var question = document.getElementById("questionId").value;
    var err_question = document.getElementById("err_question");
    var patternQuestion = /([a-zA-Z0-9?_-]){1,45}$/g;
    if(question.match(patternQuestion)){
        err_question.innerHTML = ""; 
    } else{ 
        document.getElementById("questionId").focus(); 
        err_question.style.color = "red";
        err_question.style.fontSize = "12px"; 
        err_question.innerHTML = "Wrong"; 
        return false; 
    }

    // Radio button validation (how many options question has?)
    var quesArr = document.getElementsByName('option');
    if((quesArr[0].checked || quesArr[1].checked || quesArr[2].checked || quesArr[3].checked)){
        err_optionCount.innerHTML = "";
    }
    else{
        err_optionCount.style.color = "red";
        err_optionCount.style.fontSize = "12px"; 
        err_optionCount.innerHTML = "Wrong";
        return false; 
    }

    // Dynamic Options validation
    // var optIdStr = "optId";
    // var errStr = "err_optId";
    // var patternOpt= /([a-zA-Z0-9_-]){1,45}$/g;
    // var count = 0;
    // for(var i = 1; i <= numOfOptions; i++){
    //     var idNumber = i.toString();
    //     var optId = optIdStr.concat(idNumber);
    //     var errId = errStr.concat(idNumber);
    //     var optionValue = document.getElementById(optId).value;
    //     var errId = document.getElementById("errId");
    //     // alert(optionValue);
    //     if(optionValue.match(patternOpt))
    //     {
    //         document.getElementById(errId).innerHTML = "";    
    //     }
    //     else{
    //         document.getElementById(optId).focus();
    //         document.getElementById(errId).style.fontSize = "12px"; 
    //         document.getElementById(errId).style.color = "red";
    //         document.getElementById(errId).innerHTML = "Wrong"; 
    //         return false; 
    //     }
    // }

    // Has Score ? validation
    var e = document.getElementById("hasScoreId");
    var err_hasScore = document.getElementById('err_hasScore');
    var optionSelIndex = e.options[e.selectedIndex].value;
    var optionSelectedText = e.options[e.selectedIndex].text;
    if (optionSelIndex == '') {
        document.getElementById("hasScoreId").focus();
        err_hasScore.style.color = "red";
        err_hasScore.style.fontSize = "12px";
        err_hasScore.innerHTML = "Wrong";
        return false;
    } else {
        err_hasScore.innerHTML = "";
    }

    // Answer Weight
    if(hasScoreValue == 1){
        var weight = document.getElementById('weight').value;
        var err_weight = document.getElementById('err_weight');
        var PatternWeight = /([0-9]){1,2}$/g;
        if(weight.match(PatternWeight))
        { 
            err_weight.innerHTML = ""; 
        }else{ 
            document.getElementById('weight').focus();
            err_weight.style.fontSize = "12px"; 
            err_weight.style.color = "red";
            err_weight.innerHTML = "Wrong"; 
            return false; 
        }
    }

    // Question Type
    var e = document.getElementById("quesTypeId");
    var err_quesType = document.getElementById('err_quesType');
    var optionSelIndex = e.options[e.selectedIndex].value;
    var optionSelectedText = e.options[e.selectedIndex].text;
    if (optionSelIndex == '') {
        document.getElementById("quesTypeId").focus();
        err_quesType.style.color = "red";
        err_quesType.style.fontSize = "12px";
        err_quesType.innerHTML = "Wrong";
        return false;
    } else {
        err_quesType.innerHTML = "";
    }



    //Radio button for Answer 
    if(isMCQ == 0){
        err_quesType.innerHTML = "";
        err_selectAnsCheck.innerHTML = "";
        var ansValid = false;
        var ansRadio = document.getElementsByName('selectAnsRadio');
        // answer[0] = $("input[type='radio'][name='selectAnsRadio']:checked").val();
        for(let i = 0; i < ansRadio.length; i++){
            if(ansRadio[i].checked){
                ansValid = true;
            }
        }
        if(ansValid){
            err_selectAnsRadio.innerHTML = "";
        }
        else{
            err_selectAnsRadio.style.color = "red";
            err_selectAnsRadio.style.fontSize = "12px"; 
            err_selectAnsRadio.innerHTML = "Wrong";
        return false; 
        }
    }
    // CkheckBox validation
    else{
        err_quesType.innerHTML = "";
        err_selectAnsRadio.innerHTML = "";
        var answer = [];
        var ansValid = false;
        var ansCheckbox = document.getElementsByClassName('checkAns');
        for(let i = 0; i < numOfOptions; i++){
            if(ansCheckbox[i].checked){
                checkedValue = ansCheckbox[i].value;
                answer.push(checkedValue);
            }
        }
        if(answer.length == '1'){
            err_selectAnsCheck.style.color = "red";
            err_selectAnsCheck.style.fontSize = "12px"; 
            err_selectAnsCheck.innerHTML = "A MCQ, Need to have more then one answer.";
            return false; 
        }
        else if(answer.length > 1){
            err_selectAnsCheck.innerHTML = "";
        }
        else{
            err_selectAnsCheck.style.color = "red";
            err_selectAnsCheck.style.fontSize = "12px"; 
            err_selectAnsCheck.innerHTML = "Wrong";
            return false; 
        }
    }

// Dynamic option entry validation



}


</script>
</html>
