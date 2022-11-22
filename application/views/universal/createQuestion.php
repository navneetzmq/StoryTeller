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
                        <form method="POST" name="questionForm" action="<?= base_url('SuperAdminController/saveQuestionData');?>" enctype="multipart/form-data">

                            <!-- Select Story or Generic to create question -->
                            <div class="form-group" id="isGenericAreaId">
                                <label for=""><strong>Create Question for: Story or Generic ?</strong></label>
                                <select id="isGenericId" name="isGeneric" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="1">Add question for Generic</option>
                                    <option value="0">Add question for Story</option>
                                </select>
                                <div id="err_isGeneric"></div>
                            </div>

                            <!-- Dropdown to select Story -->
                            <div class="form-group" id="storyAreaId">
                                <label id="labelId" for=""><strong>Select Story</strong></label>
                                <select id="storyId" name="storyId" class="form-control">
                                    <option value="0">Select Story</option>

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
                            </div>

                            <!-- If No Story Available -->
                            <strong><p id="noStory" style="color:red; text-align:center"></p></strong>

                            <!-- Dropdown to select Generic -->
                            <div class="form-group" id="genericAreaId">
                                <label id="labelId" for=""><strong>Select Generic</strong></label>
                                <select id="genericId" name="genericId" class="form-control">
                                    <option value="0">Select Generic</option>
                                    <?php 
                                    if(isset($genericData) && !empty($genericData)){
                                        for($i = 0 ; $i < count($genericData); $i++) { ?>
                                            <?php if(isset($genericData[$i]->genericId)){ ?>
                                                <option value="<?= $genericData[$i]->genericId; ?>">
                                                <?= $genericData[$i]->genericTitle; ?>
                                            <?php }?>
                                                </option>
                                    <?php }} ?>
                                </select>
                            </div>

                            <!-- If No Generic Available -->
                            <strong><p id="noGeneric" style="color:red; text-align:center;"></p></strong>

                            <div id="hideForm">
                                <!-- Question text -->
                                <div class="form-group">
                                    <label for=""><strong>Question Text</strong></label>
                                    <input type="text" class="form-control" id="questionId" name="question" placeholder="">
                                    <div id="err_question"></div>
                                </div>

                                <!-- Question Image -->
                                <div class="row">
                                    <div class="form-group col-lg-5">
                                        <label for="questionImage">Image</label>
                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" id="questionImage" name="questionImage">
                                    </div>

                                    <!-- Question Audio -->
                                    <div class="form-group col-lg-5">
                                        <label for="questionAudio">Audio</label>
                                        <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="questionAudio" id="questionAudio">
                                    </div>
                                </div>
                                
                                <!-- How many Options the Question has ? -->
                                <div class="form-group" id="radioBtn">
                                    <label for=""><strong>Number of options to answer?</strong></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="2" name="option" id="id2" onchange="openOptionField(2);">
                                        <label class="form-check-label" for="id2">Two</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="3" name="option" id="id3" onchange="openOptionField(3);">
                                        <label class="form-check-label" for="id3">Three</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="4" name="option" id="id4" onchange="openOptionField(4) ;">
                                        <label class="form-check-label" for="id4">Four</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="5" name="option" id="id5" onchange="openOptionField(5);">
                                        <label class="form-check-label" for="id5">Five</label>
                                    </div>
                                    <div id="err_optionCount"></div>
                                </div>

                                <!-- Format for options -->
                                <div class="form-group" id="optionFormatRadioBtn">
                                    <label for=""><strong>Format for Options ?</strong></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="1" name="optionFormat" id="optionFormat1" onchange="openOptionFileUpload(1)">
                                        <label class="form-check-label" for="optionFormat1">Text Only</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="2" name="optionFormat" id="optionFormat2" onchange="openOptionFileUpload(2)">
                                        <label class="form-check-label" for="optionFormat2">Image Only</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="3" name="optionFormat" id="optionFormat3" onchange="openOptionFileUpload(3)">
                                        <label class="form-check-label" for="optionFormat3">Text + Image</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="4" name="optionFormat" id="optionFormat4" onchange="openOptionFileUpload(4)">
                                        <label class="form-check-label" for="optionFormat4">Text + Audio</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="5" name="optionFormat" id="optionFormat5" onchange="openOptionFileUpload(5)">
                                        <label class="form-check-label" for="optionFormat5">Image + Audio</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="6" name="optionFormat" id="optionFormat6" onchange="openOptionFileUpload(6)">
                                        <label class="form-check-label" for="optionFormat6">Text + Image + Audio</label>
                                    </div>
                                    <div id="err_optionFormat"></div>
                                </div>


                                <!------------- options for question ------------->

                                <!-- Option A Text-->
                                <label for="" id="optLabelId1"><strong>Option-A</strong></label>
                                <div class="form-group" id="optionArea1" style="display: none;">
                                    <input type="text" class="form-control" id="optId1" name="optA" placeholder="">
                                    <div id="err_optId1"></div>
                                </div>

                                <!-- Option A Image -->
                                
                                    <div class="row">
                                        <div id="optImgId1" class="form-group col-lg-5">
                                            <label for="optImageId1">Image</label>
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optAImage" id="optImageId1">
                                            <div id="err_optImgId1"></div>
                                        </div>
                                <!-- Option A Audio -->
                                        <div id="optAudioId1" class="form-group col-lg-5">
                                            <label for="optAudioId1">Audio</label>
                                            <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optAAudio" id="optAudId1">
                                            <div id="err_optAudioId1"></div>
                                        </div>
                                    </div>
                        

                                <!-- Option B Text -->
                                <label for="" id="optLabelId2"><strong>Option-B</strong></label>
                                <div class="form-group" id="optionArea2" style="display: none;">
                                    <input type="text" class="form-control" id="optId2" name="optB" placeholder="">
                                    <div id="err_optId2"></div>
                                </div>

                                <!-- Option B Image -->
    
                                    <div class="row">
                                        <div id="optImgId2" class="form-group col-lg-5">
                                            <label for="optImageId2">Image</label>
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optBImage" id="optImageId2">
                                            <div id="err_optImgId2"></div>
                                        </div>
                                    <!-- Option B Audio -->
                                        <div id="optAudioId2" class="form-group col-lg-5">
                                            <label for="optAudioId2">Audio</label>
                                            <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optBAudio" id="optAudId2">
                                            <div id="err_optAudioId2"></div>
                                        </div>
                                    </div>

                                <!-- Option C Text -->
                                <label for="" id="optLabelId3"><strong>Option-C</strong></label>
                                <div class="form-group" id="optionArea3" style="display: none;">
                                    <input type="text" class="form-control" id="optId3" name="optC" placeholder="">
                                    <div id="err_optId3"></div>
                                </div>

                                <!-- Option C Image -->
            
                                    <div class="row">
                                        <div id="optImgId3" class="form-group col-lg-5">
                                            <label for="optImageId3">Image</label>
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optCImage" id="optImageId3">
                                            <div id="err_optImgId3"></div>
                                        </div>
                                        <!-- Option C Audio -->
                                        <div id="optAudioId3" class="form-group col-lg-5">
                                            <label for="optAudioId3">Audio</label>
                                            <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optCAudio" id="optAudId3">
                                            <div id="err_optAudioId3"></div>
                                        </div>
                                    </div>
            

                                <!-- Option D Text -->
                                <label for="" id="optLabelId4"><strong>Option-D</strong></label>
                                <div class="form-group" id="optionArea4" style="display: none;">
                                    <input type="text" class="form-control" id="optId4" name="optD" placeholder="">
                                    <div id="err_optId4"></div>
                                </div>

                                <!-- Option D Image -->
            
                                    <div class="row">
                                        <div id="optImgId4" class="form-group col-lg-5">
                                            <label for="optImageId4">Image</label>
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optDImage" id="optImageId4">
                                            <div id="err_optImgId4"></div>
                                        </div>
                                        <!-- Option D Audio -->
                                        <div id="optAudioId4" class="form-group col-lg-5">
                                            <label for="optAudioId4">Audio</label>
                                            <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optDAudio" id="optAudId4">
                                            <div id="err_optAudioId4"></div>
                                        </div>
                                    </div>
            

                                <!-- Optio E Text -->
                                <label for="" id="optLabelId5"><strong>Option-E</strong></label>
                                <div class="form-group" id="optionArea5" style="display: none;">
                                    <input type="text" class="form-control" id="optId5" name="optE" placeholder="">
                                    <div id="err_optId5"></div>
                                </div>

                                <!-- Option E Image -->
        
                                    <div class="row">
                                        <div id="optImgId5" class="form-group col-lg-5">
                                            <label for="optImageId5">Image</label>
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optEImage" id="optImageId5">
                                            <div id="err_optImgId5"></div>
                                        </div>
                                        <!-- Option E Audio -->
                                        <div id="optAudioId5" class="form-group col-lg-5">
                                            <label for="optAudioId5">Audio</label>
                                            <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optEAudio" id="optAudId5">
                                            <div id="err_optAudioId5"></div>
                                        </div>
                                    </div>
        

                                <!-- Option "None of Above" -->
                                <!-- <div class="form-group" id="noneId" style="display: none;">
                                    <label for=""><strong>None of above</strong></label>
                                    <input type="text" class="form-control" id="none" name="none" placeholder="">
                                    <div id="err_none"></div>
                                </div> -->

                                <!-- Has score -->
                                <div class="form-group" id="hasScoreDiv">
                                    <label for=""><strong>Has Score ?</strong></label>
                                    <select id="hasScoreId" name="hasScore" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="1">Yes, has Score</option>
                                        <option value="0">No!, Dosen't has Score</option> 
                                    </select>
                                    <div id="err_hasScore"></div>
                                </div>

                                <!-- Question weight -->
                                <div class="form-group" id="weightId">
                                    <label for=""><strong>Weight</strong></label>
                                    <input type="text" class="form-control" id="weight" name="weight" placeholder="">
                                    <div id="err_weight"></div>
                                </div>

                                <!-- Queston Type -->
                                <div class="form-group">
                                    <label for=""><strong>Answer Type</strong></label>
                                    <select id="quesTypeId" name="quesType" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="0">Single Choice</option>
                                        <option value="1">Multiple Choice</option> 
                                    </select>
                                    <div id="err_quesType"></div>
                                </div>

                                <!-- Radio buttons to select aswers-->
                                <div class="form-group">
                                    <label for="" id="selectAnsRadioId"><strong>Choose your Answer :</strong></label>
                                    <div class="form-check" id="ansRadioId1">
                                        <input class="form-check-input" type="radio" id="ansRid1" name="selectAnsRadio" value="1">
                                        <label class="form-check-label" id="optradioLabel1" for="ansRid1"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId2">
                                        <input class="form-check-input" type="radio" id="ansRid2" name="selectAnsRadio" value="2">
                                        <label class="form-check-label" id="optradioLabel2" for="ansRid2"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId3">
                                        <input class="form-check-input" type="radio" id="ansRid3" name="selectAnsRadio" value="3">
                                        <label class="form-check-label" id="optradioLabel3" for="ansRid3"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId4">
                                        <input class="form-check-input" type="radio" id="ansRid4" name="selectAnsRadio" value="4">
                                        <label class="form-check-label" id="optradioLabel4" for="ansRid4"></label>
                                    </div>

                                    <div class="form-check" id="ansRadioId5">
                                        <input class="form-check-input" type="radio" id="ansRid5" name="selectAnsRadio" value="5">
                                        <label class="form-check-label" id="optradioLabel5" for="ansRid5"></label>
                                    </div>
                                    <div id="err_selectAnsRadio"></div>
                                </div>

                                <!-- Checkboxes to select aswers -->
                                <div class="form-group">
                                    <label for="" id="selectAnsCheckId"><strong>Select your Answer :</strong>`  </label>
                                    <div class="form-check" id="ansCheckId1">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid1" name="ansCid1" value="1">
                                        <label class="form-check-label" id="optCheckLabel1" for="ansCid1">One</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId2">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid2" name="ansCid2" value="2">
                                        <label class="form-check-label" id="optCheckLabel2" for="ansCid2">Two</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId3">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid3" name="ansCid3" value="3">
                                        <label class="form-check-label" id="optCheckLabel3" for="ansCid3">Three</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId4">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid4" name="ansCid4" value="4">
                                        <label class="form-check-label" id="optCheckLabel4" for="ansCid4">Four</label>
                                    </div>

                                    <div class="form-check" id="ansCheckId5">
                                        <input class="form-check-input checkAns" type="checkbox" id="ansCid5" name="ansCid5" value="5">
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
                                        <input type="button" id="preBtn" class="btn btn-primary btn-user btn-block btn-sm" value="Add Pre Question" onclick='loadForm()'>
                                    </div>

                                    <div class="col-auto float-right"> 
                                        <input type="button" id="postBtn" class="btn btn-primary btn-user btn-block btn-sm" value="Add Post Question" onclick='loadForm()'>
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
var optFormat;
var isGeneric;

let genericJson = `<?php echo json_encode($genericData)?>`; // Converting php array to JSON String
let genericData = JSON.parse(genericJson); // Converting JSON to JS object
let storyJson = `<?php echo json_encode($storyData)?>`; // Converting php array to JSON String
let storyData = JSON.parse(storyJson); // Converting JSON to JS object

// On page load
document.getElementById('genericAreaId').style.display = 'none';
document.getElementById('storyAreaId').style.display = 'none';

document.getElementById('isPreValueId').style.display = 'none';
document.getElementById('hideForm').style.display = 'none';
document.getElementById('preBtn').style.display = 'none';
document.getElementById('postBtn').style.display = 'none';

// When we select "Add question for Story/Generic"
$('#isGenericId').on('change', function(){
    isGeneric = this.value;
    var genericLength = genericData.length;
    var storyLength = storyData.length;
    if(isGeneric == 1){
        if(genericLength > 0){
            document.getElementById('genericAreaId').style.display = 'block';
            document.getElementById('isGenericAreaId').style.display = 'none';
            document.getElementById('noStory').innerHTML = "";
        }
        else{
            document.getElementById('genericAreaId').style.display = 'none';
            document.getElementById('isGenericAreaId').style.display = 'block';
            document.getElementById('noGeneric').innerHTML = "No Generic availabe!";
        }
    }
    else{
        if(storyLength > 0){
            document.getElementById('storyAreaId').style.display = 'block';
            document.getElementById('isGenericAreaId').style.display = 'none';
            document.getElementById('noGeneric').innerHTML = "";
        }
        else{
            document.getElementById('storyAreaId').style.display = 'none';
            document.getElementById('isGenericAreaId').style.display = 'block';
            document.getElementById('noStory').innerHTML = "No Story available!";
        }
    }
});

// When we select a Story
$('#storyId').on('change', function(){

    var storyId = this.value;
    alert(storyId);
    $.ajax({
        url: "<?= base_url('SuperAdminController/checkStoryHasPreQues') ?>",
        type: 'POST',
        data: {
            storyId : storyId,
        },
        success: function(response) {
            response = JSON.parse(response);
            let prePost = response["prePostQues"];
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

// When we select a Generic
$('#genericId').on('change', function(){
    var genericId = this.value;
    alert(genericId);
    document.getElementById('genericAreaId').style.display = 'none';
    loadForm();
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
    document.getElementById('optImgId1').style.display = 'none';
    document.getElementById('optImgId2').style.display = 'none';
    document.getElementById('optImgId3').style.display = 'none';
    document.getElementById('optImgId4').style.display = 'none';
    document.getElementById('optImgId5').style.display = 'none';
    document.getElementById('optAudioId1').style.display = 'none';
    document.getElementById('optAudioId2').style.display = 'none';
    document.getElementById('optAudioId3').style.display = 'none';
    document.getElementById('optAudioId4').style.display = 'none';
    document.getElementById('optAudioId5').style.display = 'none';
    document.getElementById('optLabelId1').style.display = 'none';
    document.getElementById('optLabelId2').style.display = 'none';
    document.getElementById('optLabelId3').style.display = 'none';
    document.getElementById('optLabelId4').style.display = 'none';
    document.getElementById('optLabelId5').style.display = 'none';
    document.getElementById('optionFormatRadioBtn').style.display = 'none';
}

// When select, How many options the question has

function openOptionField(radioValue){
    numOfOptions = radioValue;
    document.getElementById('radioBtn').style.display = 'none';
    document.getElementById('optionFormatRadioBtn').style.display = 'block';
}

// Open Upload file options
function openOptionFileUpload(format){
    optFormat = format;
    var optImgStr = 'optImgId';
    var optAudioStr = 'optAudioId';
    var optLabelStr = 'optLabelId';
    var idStr = "optionArea";
    for(let i = 1; i <= numOfOptions; i++){
        var idNumber = i.toString();
        var id = idStr.concat(idNumber);
        var idOptLebel = optLabelStr.concat(idNumber);
        var idOptImg = optImgStr.concat(idNumber);
        var idOptAudio = optAudioStr.concat(idNumber);
        document.getElementById(idOptLebel).style.display = "block";
        if(format == '1'){
            document.getElementById(idOptImg).style.display = 'none';
            document.getElementById(idOptAudio).style.display = 'none';
            document.getElementById(id).style.display = 'block';
        }
        else if(format == '2'){
            document.getElementById(id).style.display = 'none';
            document.getElementById(idOptAudio).style.display = 'none';
            document.getElementById(idOptImg).style.display = 'inline';
        }
        else if(format == '3'){
            document.getElementById(idOptAudio).style.display = 'none';
            document.getElementById(id).style.display = 'block';
            document.getElementById(idOptImg).style.display = 'inline';
        }
        else if(format == '4'){
            document.getElementById(idOptImg).style.display = 'none';
            document.getElementById(id).style.display = 'block';
            document.getElementById(idOptAudio).style.display = 'inline';
        }
        else if(format == '5'){
            document.getElementById(id).style.display = 'none';
            document.getElementById(idOptImg).style.display = 'inline';
            document.getElementById(idOptAudio).style.display = 'inline';

        }
        else if(format == '6'){
            document.getElementById(id).style.display = 'block';
            document.getElementById(idOptImg).style.display = 'inline';
            document.getElementById(idOptAudio).style.display = 'inline';
        }
        else{
            document.getElementById(id).style.display = 'none';
            document.getElementById(idOptImg).style.display = 'none';
            document.getElementById(idOptAudio).style.display = 'none';
        }
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
        var optImgStr = "optImageId";
        var optAudioStr = "optAudioId";
        var idStr = "ansRadioId";
        var optionIdStr = "optId";
        var ansInputStr = "ansRid";
        for(let i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var id = idStr.concat(idNumber);
            document.getElementById(id).style.display = 'block';  //To display radio buttons
            
            var labelId = optionLabelStr.concat(idNumber);
            var optionId = optionIdStr.concat(idNumber);
            var ansOptId = ansInputStr.concat(idNumber);

            // If text option value is not empty
            if(document.getElementById(optionId).value != ""){

                var inputValue = document.getElementById(optionId).value; // Value of option
                document.getElementById(labelId).innerHTML = inputValue; //Option input value, insert to label
            }
            // If text in option is empty
            else{
                var imgId = optImgStr.concat(idNumber);
                var imgPath = document.getElementById(imgId).value;
                var imgPathLength = imgPath.length;
                var imgName = imgPath.slice(12, imgPathLength);
                document.getElementById(labelId).innerHTML = imgName;
            }   
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

        var optImgStr = "optImageId";
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
            var ansOptId = ansInputStr.concat(idNumber);

            if(document.getElementById(optionId).value != ""){
                var inputValue = document.getElementById(optionId).value;
                document.getElementById(labelId).innerHTML = inputValue;
            }
            else{
                var imgId = optImgStr.concat(idNumber);
                var imgPath = document.getElementById(imgId).value;
                var imgPathLength = imgPath.length;
                var imgName = imgPath.slice(12, imgPathLength);
                document.getElementById(labelId).innerHTML = imgName;
            }
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

    // Radio button validation (Format for Options)
    var formatArr = document.getElementsByName('optionFormat');
    if(formatArr[0].checked || formatArr[1].checked || formatArr[2].checked || formatArr[3].checked || formatArr[4].checked || formatArr[5].checked){
        err_optionFormat.innerHTML = "";
    }
    else{
        err_optionFormat.style.color = "red";
        err_optionFormat.style.fontSize = "12px"; 
        err_optionFormat.innerHTML = "Wrong";
        return false; 
    }

    // ----------------- Dynamic validation Option(Text, Image) ---------------- //

    // Validate iff Option is Text Only
    if(optFormat == 1){
        var optIdStr = "optId";
        var errOptStr = "err_optId";
        for(var i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var optId = optIdStr.concat(idNumber);
            var optErrId = errOptStr.concat(idNumber);
            var optValue = document.getElementById(optId).value;
            var err_opt = document.getElementById(optErrId);
            var patternOpt = /([a-zA-Z0-9?_-]){1,45}$/g;
            if(optValue.match(patternOpt)){
                err_opt.innerHTML = "";
            }
            else{
                document.getElementById(optId).focus();
                err_opt.style.color = "red";
                err_opt.style.fontSize = "12px"; 
                err_opt.innerHTML = "Text required!"; 
                return false;
            }
        }
    }

    // Validate iff Option has Image Only
    else if(optFormat == 2){
        var optImgStr = "optImageId";
        var errImgStr = "err_optImgId";
        for(var i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var optImgId = optImgStr.concat(idNumber);
            var errImgId = errImgStr.concat(idNumber);
            var errImg = document.getElementById(errImgId);
            var imgValue = document.getElementById(optImgId).value;
            if(imgValue != ""){
                errImg.innerHTML = "";
            }
            else{
                document.getElementById(optImgId).focus();
                errImg.style.color = "red";   
                errImg.style.fontSize = "12px"; 
                errImg.innerHTML = "Image required!";
                return false;
            }
        }
    }

    // Validate iff Option has Text + Image
    else if(optFormat == 3){
        var optIdStr = "optId";
        var errOptStr = "err_optId";
        var optImgStr = "optImageId";
        var errImgStr = "err_optImgId";
        for(var i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var optId = optIdStr.concat(idNumber);
            var optErrId = errOptStr.concat(idNumber);
            var optImgId = optImgStr.concat(idNumber);
            var errImgId = errImgStr.concat(idNumber);
            var optValue = document.getElementById(optId).value;
            var err_opt = document.getElementById(optErrId);
            var errImg = document.getElementById(errImgId);
            var imgValue = document.getElementById(optImgId).value;
            var patternOpt = /([a-zA-Z0-9?_-]){1,45}$/g;
            if(optValue.match(patternOpt) && imgValue != ""){
                err_opt.innerHTML = "";
                errImg.innerHTML = "";
            }
            else if(optValue.match(patternOpt) && imgValue == ""){
                err_opt.innerHTML = "";
                document.getElementById(optId).focus();
                errImg.style.color = "red";   
                errImg.style.fontSize = "12px"; 
                errImg.innerHTML = "Image required!";
                return false;
            }
            else if(!(optValue.match(patternOpt)) && imgValue != ""){
                errImg.innerHTML = "";
                document.getElementById(optId).focus();
                err_opt.style.color = "red";
                err_opt.style.fontSize = "12px"; 
                err_opt.innerHTML = "Text required!";
                return false;
            }
            else{
                document.getElementById(optId).focus();
                err_opt.style.color = "red";
                err_opt.style.fontSize = "12px"; 
                err_opt.innerHTML = "Text required!";
                errImg.style.color = "red";   
                errImg.style.fontSize = "12px"; 
                errImg.innerHTML = "Image required!";
                return false;
            }
        }
    }

    // Validate iff option has Text + Audio
    else if(optFormat == 4){
        var optIdStr = "optId";
        var errOptStr = "err_optId";
        var optAudioStr = 'optAudId';
        var errAudioStr = 'err_optAudioId';
        for(var i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var optId = optIdStr.concat(idNumber);
            var optErrId = errOptStr.concat(idNumber);
            var optAudioId = optAudioStr.concat(idNumber);
            var errAudioId = errAudioStr.concat(idNumber);
            var optValue = document.getElementById(optId).value;
            var err_opt = document.getElementById(optErrId);
            var errAudio = document.getElementById(errAudioId);
            var audioValue = document.getElementById(optAudioId).value;
            var patternOpt = /([a-zA-Z0-9?_-]){1,45}$/g;
            if(optValue.match(patternOpt) && audioValue != ""){
                err_opt.innerHTML = "";
                errAudio.innerHTML = "";
            }
            else if(optValue.match(patternOpt) && audioValue == ""){
                err_opt.innerHTML = "";
                document.getElementById(optId).focus();
                errAudio.style.color = "red";
                errAudio.style.fontSize = "12px"; 
                errAudio.innerHTML = "Audio required!";
                return false;
            }
            else if(!(optValue.match(patternOpt)) && audioValue != ""){
                errAudio.innerHTML = "";
                document.getElementById(optId).focus();
                err_opt.style.color = "red";
                err_opt.style.fontSize = "12px"; 
                err_opt.innerHTML = "Text required!";
                return false;
            }
            else{
                document.getElementById(optId).focus();
                err_opt.style.color = "red";
                err_opt.style.fontSize = "12px"; 
                err_opt.innerHTML = "Text required!";
                errAudio.style.color = "red";
                errAudio.style.fontSize = "12px"; 
                errAudio.innerHTML = "Audio required!";
                return false;
            }
        }
    }

    // Validate if option has Image + Audio
    else if(optFormat == 5){
        var optImgStr = "optImageId";
        var errImgStr = "err_optImgId";
        var optAudioStr = 'optAudId';
        var errAudioStr = 'err_optAudioId';
        for(var i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var optImgId = optImgStr.concat(idNumber);
            var errImgId = errImgStr.concat(idNumber);
            var optAudioId = optAudioStr.concat(idNumber);
            var errAudioId = errAudioStr.concat(idNumber);
            var errImg = document.getElementById(errImgId);
            var imgValue = document.getElementById(optImgId).value;
            var errAudio = document.getElementById(errAudioId);
            var audioValue = document.getElementById(optAudioId).value;
            if(imgValue != "" && audioValue != ""){
                errImg.innerHTML = "";
                errAudio.innerHTML = "";
            }
            else if(imgValue != "" && audioValue == ""){
                errImg.innerHTML = "";
                errAudio.style.color = "red";
                errAudio.style.fontSize = "12px"; 
                errAudio.innerHTML = "Audio required!";
                return false;
            }
            else if(imgValue == "" && audioValue != ""){
                errAudio.innerHTML = "";
                errImg.style.color = "red";   
                errImg.style.fontSize = "12px"; 
                errImg.innerHTML = "Image required!";
                return false;
            }
            else{
                errImg.style.color = "red";   
                errImg.style.fontSize = "12px"; 
                errImg.innerHTML = "Image required!";
                errAudio.style.color = "red";
                errAudio.style.fontSize = "12px"; 
                errAudio.innerHTML = "Audio required!";
                return false;
            }
        }
    }

    // Validate iff option has Text + Image + Audio
    else if(optFormat == 6){
        var optIdStr = "optId";
        var errOptStr = "err_optId";
        var optImgStr = "optImageId";
        var errImgStr = "err_optImgId";
        var optAudioStr = 'optAudId';
        var errAudioStr = 'err_optAudioId';
        for(var i = 1; i <= numOfOptions; i++){
            var idNumber = i.toString();
            var optId = optIdStr.concat(idNumber);
            var optErrId = errOptStr.concat(idNumber);
            var optImgId = optImgStr.concat(idNumber);
            var errImgId = errImgStr.concat(idNumber);
            var optAudioId = optAudioStr.concat(idNumber);
            var errAudioId = errAudioStr.concat(idNumber);
            var optValue = document.getElementById(optId).value;
            var err_opt = document.getElementById(optErrId);
            var errImg = document.getElementById(errImgId);
            var imgValue = document.getElementById(optImgId).value;
            var errAudio = document.getElementById(errAudioId);
            var audioValue = document.getElementById(optAudioId).value;
            var patternOpt = /([a-zA-Z0-9?_-]){1,45}$/g;
            if(optValue.match(patternOpt) && imgValue != "" && audioValue != ""){
                err_opt.innerHTML = "";
                errImg.innerHTML = "";
                errAudio.innerHTML = "";
            }
            else{
                document.getElementById(optId).focus();
                err_opt.style.color = "red";
                err_opt.style.fontSize = "12px"; 
                err_opt.innerHTML = "Text required!"; 
                errImg.style.color = "red";   
                errImg.style.fontSize = "12px"; 
                errImg.innerHTML = "Image required!";
                errAudio.style.color = "red";
                errAudio.style.fontSize = "12px"; 
                errAudio.innerHTML = "Audio required!";
                return false;
            }
        }   
    }

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
}    
</script>
</html>