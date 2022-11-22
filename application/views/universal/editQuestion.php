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
                    <li class="breadcrumb-item active" aria-current="page">Questions List</li>
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

                    <!-- <pre><//?php var_dump($genericData)?></pre> -->

                    <!-- form -->              

                    <form method="POST" action="<?= base_url('CompanyAdminController/saveAssignedStory');?>">

                    <!-- Dropdown to ask "Edit question forostory or Generic" -->
                        <div class="form-group" id="editQuesAreaId">
                            <label for=""><strong>Edit Question for: Story or Generic ?</strong></label>
                            <select id="editQuesForId" name="editQues" class="form-control">
                                <option value="">Please Select</option>
                                <option value="1">Edit question for Generic</option>
                                <option value="0">Edit question for Story</option>
                            </select>
                            <div id="err_editQues"></div>
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
                            <div id="err_story"></div>
                        </div>

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
                            <div id="err_story"></div>
                        </div>

                        <!-- Title for story or generic -->
                        <strong><div id="titleId" class="alert alert-primary" role="alert"></div></strong>
                        <div class="container" id="quesTableId">
                            <table id="" class="table table-sm table-responsive table-striped table-bordered" style="width:100%">
                                <thead id="quesTableHeadId">
                                    <tr>
                                        <th>Question Text</th>
                                        <th>Update</th>
                                        <!-- <th>Status</th> -->
                                    </tr>
                                </thead>
                                <tbody id="quesTableBodyId">
                                </tbody>
                            </table>
                            <div id="noDataAreaId"><h3 id="noDataId"></h3></div>
                        </div>
                    </form>
                </div>
            </div>
        </body>

<!-- Modal, to update Question data -->

<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Question Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" name="updateQuesForm" action="<?= base_url('SuperAdminController/saveUpdatedQuesData');?>" enctype="multipart/form-data">
            <div class="row">
              <!-- PreQues / PostQues -->
              <div class="col-lg-2"></div>
              <div id="prePostSwitchId" class="custom-control custom-switch col-auto float-right col-lg-4">
                <input type="checkbox" class="custom-control-input" name="prePost" id="prePost">
                <label class="custom-control-label" for="prePost"><strong id="prePostLabel"></strong></label>
              </div>

              <!-- Active / Inactive switch -->
              <div class="custom-control custom-switch col-auto float-right col-lg-4">
                <input type="checkbox" class="custom-control-input" name="activeInactive" id="activeInactive">
                <label class="custom-control-label" for="activeInactive"><strong id="activeInactiveLabel"></strong></label>
              </div>
            </div>
            <hr>
            <!-- Question text -->
            <div class="form-group">
                <label for=""><strong>Question Text</strong></label>
                <input type="text" class="form-control" id="questionId" name="question" placeholder="">
                <div id="err_question"></div>
            </div>

            <!-- Question Response Image -->
            <div class="row">
                <div id="quesResAreaImg" class="form-group col-lg-5" style="display: none;">
                  <img id="quesResImg" src="" alt="" height="50">
                </div>

                <!-- Question Response Audio -->
                <div class="form-group col-lg-5" style="display: none;">
                <audio controls>
                  <source id="quesResAudio" src="" type="audio/mpeg">
                </audio>
                </div>
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

            <!-- Ask to change Number-of-options -->
            <div class="form-group" id="changeNumOfOptAreaId">
                <label for=""><strong id="changeNumOfOptLabel"></strong></label>
                <select id="changeNumOfOpt" name="changeNumOfOpt" class="form-control">
                    <option value="">Please Select</option>
                    <option value="1">Yes!, Need to Change</option>
                    <option value="0">No!, Need to Change</option>
                </select>
                <div id="err_hasScore"></div>
            </div>

            <!-- How many Options the Question has ? -->
            <div class="form-group" id="radioBtn" style="display: none;">
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

            <!-- Ask to change Option Format -->
            <div class="form-group" id="changeOptFormatAreaId" style="display: none;">
                <label for=""><strong id="changeOptFormatLabel"></strong></label>
                <select id="changeOptFormat" name="changeOptFormat" class="form-control">
                    <option value="">Please Select</option>
                    <option value="1">Yes!, Need to Change</option>
                    <option value="0">No!, Need to Change</option>
                </select>
                <div id="err_hasScore"></div>
            </div>
            
            <!-- Format for options -->
            <div class="form-group" id="optionFormatRadioBtn" style="display: none;">
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
            <label for="" id="optLabelId1" style="display: none;"><strong>Option-A</strong></label>
            <div class="form-group" id="optionArea1" style="display: none;">
                <input type="text" class="form-control" id="optId1" name="optA" placeholder="">
                <div id="err_optId1"></div>
            </div>

            <!-- Option A Response Image -->
            <div class="row">
                <div id="optResAreaImg1" class="form-group col-lg-5" style="display: none;">
                  <img id="optResImg1" src="" alt="" height="50">
                </div>

                <!-- Option A Response Audio -->
                <div id="optResAreaAudio1" class="form-group col-lg-5" style="display: none;">
                  <audio controls>
                    <source id="optResAudio1" src="" type="audio/mpeg">
                  </audio>
                </div>
            </div>

            <!-- Option A Image -->
            <div class="row">
                <div id="optImgId1" class="form-group col-lg-5" style="display: none;">
                    <label for="optImageId1">Image</label>
                    <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optAImage" id="optImageId1">
                    <div id="err_optImgId1"></div>
                </div>
              <!-- Option A Audio -->
                <div id="optAudioId1" class="form-group col-lg-5" style="display: none;">
                    <label for="optAudioId1">Audio</label>
                    <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optAAudio" id="optAudId1">
                    <div id="err_optAudioId1"></div>
                </div>
            </div>
                        
            <!-- Option B Text -->
            <label for="" id="optLabelId2" style="display: none;"><strong>Option-B</strong></label>
            <div class="form-group" id="optionArea2" style="display: none;">
                <input type="text" class="form-control" id="optId2" name="optB" placeholder="">
                <div id="err_optId2"></div>
            </div>
            
            <!-- Option B Response Image -->
            <div class="row">
                <div id="optResAreaImg2" class="form-group col-lg-5" style="display: none;">
                  <img id="optResImg2" src="" alt="" height="50">
                </div>

                <!-- Option B Response Audio -->
                <div id="optResAreaAudio2" class="form-group col-lg-5" style="display: none;">
                  <audio controls>
                    <source id="optResAudio2" src="" type="audio/mpeg">
                  </audio>
                </div>
            </div>

            <!-- Option B Image -->
            <div class="row">
                <div id="optImgId2" class="form-group col-lg-5" style="display: none;">
                    <label for="optImageId2">Image</label>
                    <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optBImage" id="optImageId2">
                    <div id="err_optImgId2"></div>
                </div>
            <!-- Option B Audio -->
                <div id="optAudioId2" class="form-group col-lg-5" style="display: none;">
                    <label for="optAudioId2">Audio</label>
                    <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optBAudio" id="optAudId2">
                    <div id="err_optAudioId2"></div>
                </div>
            </div>

            <!-- Option C Text -->
            <label for="" id="optLabelId3" style="display: none;"><strong>Option-C</strong></label>
            <div class="form-group" id="optionArea3" style="display: none;">
                <input type="text" class="form-control" id="optId3" name="optC" placeholder="">
                <div id="err_optId3"></div>
            </div>
            
            <!-- Option C Response Image -->
            <div class="row">
                <div id="optResAreaImg3" class="form-group col-lg-5" style="display: none;">
                  <img id="optResImg3" src="" alt="" height="50">
                </div>

                <!-- Option C Response Audio -->
                <div id="optResAreaAudio3" class="form-group col-lg-5" style="display: none;">
                  <audio controls>
                    <source id="optResAudio3" src="" type="audio/mpeg">
                  </audio>
                </div>
            </div>

            <!-- Option C Image -->
            <div class="row">
                <div id="optImgId3" class="form-group col-lg-5" style="display: none;">
                    <label for="optImageId3">Image</label>
                    <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optCImage" id="optImageId3">
                    <div id="err_optImgId3"></div>
                </div>
                <!-- Option C Audio -->
                <div id="optAudioId3" class="form-group col-lg-5" style="display: none;">
                    <label for="optAudioId3">Audio</label>
                    <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optCAudio" id="optAudId3">
                    <div id="err_optAudioId3"></div>
                </div>
            </div>

            <!-- Option D Text -->
            <label for="" id="optLabelId4" style="display: none;"><strong>Option-D</strong></label>
            <div class="form-group" id="optionArea4" style="display: none;">
                <input type="text" class="form-control" id="optId4" name="optD" placeholder="">
                <div id="err_optId4"></div>
            </div>
            
            <!-- Option D Response Image -->
            <div class="row">
                <div id="optResAreaImg4" class="form-group col-lg-5" style="display: none;">
                  <img id="optResImg4" src="" alt="" height="50">
                </div>

                <!-- Option D Response Audio -->
                <div id="optResAreaAudio4" class="form-group col-lg-5" style="display: none;">
                  <audio controls>
                    <source id="optResAudio4" src="" type="audio/mpeg">
                  </audio>
                </div>
            </div>

            <!-- Option D Image -->
            <div class="row">
                <div id="optImgId4" class="form-group col-lg-5" style="display: none;">
                    <label for="optImageId4">Image</label>
                    <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optDImage" id="optImageId4">
                    <div id="err_optImgId4"></div>
                </div>
                <!-- Option D Audio -->
                <div id="optAudioId4" class="form-group col-lg-5" style="display: none;">
                    <label for="optAudioId4">Audio</label>
                    <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optDAudio" id="optAudId4">
                    <div id="err_optAudioId4"></div>
                </div>
            </div>

            <!-- Optio E Text -->
            <label for="" id="optLabelId5" style="display: none;"><strong>Option-E</strong></label>
            <div class="form-group" id="optionArea5" style="display: none;">
                <input type="text" class="form-control" id="optId5" name="optE" placeholder="">
                <div id="err_optId5"></div>
            </div>
            
            <!-- Option E Response Image -->
            <div class="row">
                <div id="optResAreaImg5" class="form-group col-lg-5" style="display: none;">
                  <img id="optResImg5" src="" alt="" height="50">
                </div>

                <!-- Option E Response Audio -->
                <div id="optResAreaAudio5" class="form-group col-lg-5" style="display: none;">
                  <audio controls>
                    <source id="optResAudio5" src="" type="audio/mpeg">
                  </audio>
                </div>
            </div>

            <!-- Option E Image -->
            <div class="row">
                <div id="optImgId5" class="form-group col-lg-5" style="display: none;">
                    <label for="optImageId5">Image</label>
                    <input type="file" accept="image/*" class="form-control-file form-control-sm" name="optEImage" id="optImageId5">
                    <div id="err_optImgId5"></div>
                </div>
                <!-- Option E Audio -->
                <div id="optAudioId5" class="form-group col-lg-5" style="display: none;">
                    <label for="optAudioId5">Audio</label>
                    <input type="file" accept="audio/*" class="form-control-file form-control-sm" name="optEAudio" id="optAudId5">
                    <div id="err_optAudioId5"></div>
                </div>
            </div>

            <!-- Has score -->
            <div class="form-group" id="hasScoreArea">
                <label for=""><strong id="hasScoreLabelId"></strong></label>
                <select id="hasScoreId" name="hasScore" class="form-control">
                    <option value="">Please Select</option>
                    <option value="1">Yes!, Need to Change</option>
                    <option value="0">No!, Need to Change</option> 
                </select>
                <div id="err_hasScore"></div>
            </div>

            <!-- Question weight -->
            <div class="form-group" id="weightAreaId" style="display: none;">
                <label for=""><strong>Weight</strong></label>
                <input type="text" class="form-control" id="weight" name="weight" placeholder="">
                <div id="err_weight"></div>
            </div>

            <!-- Queston Type -->
            <div class="form-group">
                <label for=""><strong id="quesTypeLabelId"></strong></label>
                <select id="quesTypeId" name="quesType" class="form-control">
                    <option value="">Please Select</option>
                    <option value="1">MCQ Type</option>
                    <option value="0">Single Choice</option> 
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
                <label for="" id="selectAnsCheckId"><strong>Select your Answer :</strong></label>
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
            <div id="currImgId" style="display:none;">
              <input type="text" id="currQuesImg" name="currQuesImg">
              <input type="text" id="currImg1" name="img1">
              <input type="text" id="currImg2" name="img2">
              <input type="text" id="currImg3" name="img3">
              <input type="text" id="currImg4" name="img4">
              <input type="text" id="currImg5" name="img5">
              <input type="text" id="format" name="optionFormat">
            </div>
              <div class="col-auto float-right">
                <button type="submit" id="submitBtn" class="btn btn-primary btn-user btn-block btn-sm">Update</button>
              </div>
              <input type="text" name="quesId" id="quesId" style="display: none;">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ---------- Script --------- -->
<script>

let currentNumOfOpt = 0;
let newNumOfOpt = 0;
let currentOptFormat;
let newOptFormat;
let currentOptFormatTxt;
let changeOptionFormat;
let changeNumOpt;
let numOpt;
let format;
let quesData;
let isCurrentMCQ;
let currentWeight;

document.getElementById('titleId').style.display = "none";
document.getElementById('quesTableId').style.display = "none";
document.getElementById('genericAreaId').style.display = 'none';
document.getElementById('storyAreaId').style.display = 'none';
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

// on IsPre changed
$('#prePost').on('change', function(){
  var e = document.getElementById('prePost');
  if(e.checked){
    e.value = 1;
    document.getElementById("prePostLabel").innerHTML = " : Pre-Question";
  }
  else{
    e.value = 0;
    document.getElementById("prePostLabel").innerHTML = " : Post-Question";
  }
})

// on Active-Inactive change
$('#activeInactive').on('change', function(){
  var e = document.getElementById('activeInactive');
  if(e.checked){
    e.value = 1;
    document.getElementById("activeInactiveLabel").innerHTML = " : Active";
  }
  else{
    e.value = 0;
    document.getElementById("activeInactiveLabel").innerHTML = " : Inactive";
  }
})

// The question has score, or not ?
$('#editQuesForId').on('change', function(){
    var editFor = this.value;
    if(editFor == '0'){
        document.getElementById('genericAreaId').style.display = 'none';
        document.getElementById('storyAreaId').style.display = 'block';
            // url: "</?= base_url('') ?>",
    }
    else{
        document.getElementById('genericAreaId').style.display = 'block';
        document.getElementById('storyAreaId').style.display = 'none';
    }
});

// Do you want to change Number-of-options
$('#changeNumOfOpt').on('change', function(){
  changeNumOpt = this.value;
  if(changeNumOpt == 1){
    document.getElementById('radioBtn').style.display = 'block';
    document.getElementById('changeOptFormatAreaId').style.display = 'none';
  }
  else{
    document.getElementById('optionFormatRadioBtn').style.display = 'none';
    document.getElementById('changeNumOfOptAreaId').style.display = 'block';
    document.getElementById('radioBtn').style.display = 'none';
    document.getElementById('changeOptFormatAreaId').style.display = 'block';
  }
})

// On change of Radio buttons for Number of options
function openOptionField(newNumOpt){
  newNumOfOpt = newNumOpt;
  document.getElementById('changeNumOfOptAreaId').style.display = 'none';
  document.getElementById('radioBtn').style.display = 'none';
  document.getElementById('changeOptFormatAreaId').style.display = 'block';
}

// Do you want to change option format
$('#changeOptFormat').on('change', function(){
  changeOptionFormat = this.value;
  if(changeOptionFormat == 1){
    document.getElementById('optionFormatRadioBtn').style.display = 'block';
  }
  else{
    document.getElementById('optionFormatRadioBtn').style.display = 'none';
    openOptionFileUpload(currentOptFormat);  // Display option fields if No change in format
  }
})

//To fill data according (NumOfOpt and Format) and To load option fields
function openOptionFileUpload(newFormat){
  if(changeNumOpt == 1){
    numOpt = newNumOfOpt;
  }
  else{
    numOpt = currentNumOfOpt;
  }
  if(changeOptionFormat == 1){
    format = newFormat;
  }
  else{
    format = currentOptFormat;
  }
  
  document.getElementById('format').value = format;
  var optInputStr = "optId";
  var optResStr = "opt";
  var optResImgStr = "optResImg";
  var optResAreaAudioStr = "optResAreaAudio";
  var optResAudioStr = "optResAudio";
  // var optImgInputStr = "optImageId";
  var optImgStr = 'optImgId';
  var optImgDbStr = "optImage";
  var optAudioStr = 'optAudioId';
  var optLabelStr = 'optLabelId';
  var idStr = "optionArea";
  var optResAreaImgStr = "optResAreaImg";
  var currImgStr = "currImg";
  for(let i = 1; i <= 5; i++){

    var idNumber = i.toString();
    var id = idStr.concat(idNumber);
    var idOptLebel = optLabelStr.concat(idNumber);
    var idOptImg = optImgStr.concat(idNumber);
    var idOptAudio = optAudioStr.concat(idNumber);
    var optInputId = optInputStr.concat(idNumber);
    var optResId = optResStr.concat(idNumber);
    var optResAreaImgId = optResAreaImgStr.concat(idNumber);
    var optResImgId = optResImgStr.concat(idNumber);
    var optResAreaAudioId = optResAreaAudioStr.concat(idNumber);
    var optResAudioId = optResAudioStr.concat(idNumber);
    var currImgId = currImgStr.concat(idNumber);
    var optImgDb = optImgDbStr.concat(idNumber);
    if(i <= numOpt){
      document.getElementById(idOptLebel).style.display = "block";
      if(format == '1'){
          document.getElementById(optInputId).value = quesData[optResId]; //Text
          document.getElementById(optResImgId).src = "";                 //Image
          document.getElementById(currImgId).value = "";
          // document.getElementById(optResAudioId).src = "";                //Audio
          document.getElementById(idOptImg).style.display = 'none';
          document.getElementById(idOptAudio).style.display = 'none';
          document.getElementById(id).style.display = 'block';
          if(quesData[optImgDb] != ""){
            document.getElementById(optResAreaImgId).style.display = 'inline';            
          }
          else{
            document.getElementById(optResAreaImgId).style.display = 'none';
          }
      }
      else if(format == '2'){
          document.getElementById(optInputId).value = "";
          document.getElementById(optResImgId).src = "<?= base_url();?>"+quesData[optImgDb];
          document.getElementById(currImgId).value = quesData[optImgDb];
          // document.getElementById(optResAudioId).src = "";
          document.getElementById(id).style.display = 'none';
          document.getElementById(idOptAudio).style.display = 'none';
          document.getElementById(idOptImg).style.display = 'inline';
        
          // document.getElementById(optImgInputId).fileName = "<?= base_url();?>"+quesData[optImgDb];
          if(quesData[optImgDb] != ""){
            document.getElementById(optResAreaImgId).style.display = 'inline';            
          }
          else{
            document.getElementById(optResAreaImgId).style.display = 'none';
          }
      }
      else if(format == '3'){
          document.getElementById(optInputId).value = quesData[optResId];
          document.getElementById(optResImgId).src = "<?= base_url();?>"+quesData[optImgDb];
          document.getElementById(currImgId).value = quesData[optImgDb];
          // document.getElementById(optResAudioId).src = "";
          document.getElementById(idOptAudio).style.display = 'none';
          document.getElementById(id).style.display = 'block';
          document.getElementById(idOptImg).style.display = 'inline';
          // document.getElementById(optImgInputId).fileName = "<?= base_url();?>"+quesData[optImgDb];
          if(quesData[optImgDb] != ""){
            document.getElementById(optResAreaImgId).style.display = 'inline';            
          }
          else{
            document.getElementById(optResAreaImgId).style.display = 'none';
          }
      }
      else if(format == '4'){
          document.getElementById(optInputId).value = quesData[optResId];
          document.getElementById(optResImgId).src = "";
          document.getElementById(currImgId).value = "";
          // document.getElementById(optResAudioId).src = "</?= base_url();?>"+quesData[idOptAudio];
          document.getElementById(idOptImg).style.display = 'none';
          document.getElementById(id).style.display = 'block';
          document.getElementById(idOptAudio).style.display = 'inline';
          if(quesData[optImgDb] != ""){
            document.getElementById(optResAreaImgId).style.display = 'inline';            
          }
          else{
            document.getElementById(optResAreaImgId).style.display = 'none';
          }
      }
      else if(format == '5'){
          document.getElementById(optInputId).value = "";
          document.getElementById(optResImgId).src = "<?= base_url();?>"+quesData[optImgDb];
          document.getElementById(currImgId).value = quesData[optImgDb];
          // document.getElementById(optResAudioId).src = "</?= base_url();?>"+quesData[idOptAudio];
          document.getElementById(id).style.display = 'none';
          document.getElementById(idOptImg).style.display = 'inline';
          document.getElementById(idOptAudio).style.display = 'inline';
          if(quesData[optImgDb] != ""){
            document.getElementById(optResAreaImgId).style.display = 'inline';            
          }
          else{
            document.getElementById(optResAreaImgId).style.display = 'none';
          }
      }
      else if(format == '6'){
          document.getElementById(optInputId).value = quesData[optResId];
          document.getElementById(optResImgId).src = "<?= base_url();?>"+quesData[optImgDb];
          document.getElementById(currImgId).value = quesData[optImgDb];
          // document.getElementById(optResAudioId).src = "</?= base_url();?>"+quesData[idOptAudio];
          document.getElementById(id).style.display = 'block';
          document.getElementById(idOptImg).style.display = 'inline';
          document.getElementById(idOptAudio).style.display = 'inline';
          // document.getElementById(optImgInputId).fileName = "<?= base_url();?>"+quesData[optImgDb];
          if(quesData[optImgDb] != ""){
            document.getElementById(optResAreaImgId).style.display = 'inline';            
          }
          else{
            document.getElementById(optResAreaImgId).style.display = 'none';
          }
      }
      else{
          document.getElementById(optInputId).value = "";
          document.getElementById(optResImgId).src = "";
          document.getElementById(currImgId).value = "";
          // document.getElementById(optResAudioId).src = "";
          document.getElementById(id).style.display = 'none';
          document.getElementById(idOptImg).style.display = 'none';
          document.getElementById(idOptAudio).style.display = 'none';
          document.getElementById(optResAreaImgId).style.display = 'none';
      }
    }
    else{
      document.getElementById(optResAreaImgId).style.display = 'none';
      document.getElementById(optInputId).value = "";
      document.getElementById(optResImgId).src = "";
      document.getElementById(currImgId).value = "";
      // document.getElementById(optResAudioId).src = "";
    }
  }
}

// Need to change weight
$('#hasScoreId').on('change', function(){
  var hasScore = this.value;
  if(hasScore == "1"){
    document.getElementById('weightAreaId').style.display = 'block';
  }
  else{
    document.getElementById('weightAreaId').style.display = 'none';
    document.getElementById('weight').value = currentWeight;
  }
})

// Need to change weight
$('#quesTypeId').on('change', function(){
  var isMCQ = this.value;
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
    for(let i = 1; i <= numOpt; i++){
        var imgId = optImgStr.concat(idNumber);
        var idNumber = i.toString();
        var id = idStr.concat(idNumber);
        document.getElementById(id).style.display = 'block';  //To display radio buttons
        var labelId = optionLabelStr.concat(idNumber);
        var optionId = optionIdStr.concat(idNumber);
        var ansOptId = ansInputStr.concat(idNumber)
        // If text option value is not empty
        if(document.getElementById(optionId).value != ""){
          var inputValue = document.getElementById(optionId).value; // Value of option
          document.getElementById(labelId).innerHTML = inputValue; //Option input value, insert to label
        }
        // If text in option is empty
        else{
          var ascii = 64;
          ascii += i;
          var optChar = "Opt-"+String.fromCharCode(ascii);
          document.getElementById(labelId).innerHTML = optChar;
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
      for(let i = 1; i <= numOpt; i++){
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
            var ascii = 64;
            ascii += i;
            var optChar = "Opt-"+String.fromCharCode(ascii);
            document.getElementById(labelId).innerHTML = optChar;
          }
      }
    }
})

// When update button is clicked.!
function updateQuestion(questionId){
  currentNumOfOpt = 0;
  $.ajax({
        url: "<?= base_url('SuperAdminController/getQuestionData') ?>",
        type: 'POST',
        data: {
          questionId : questionId,
        },
        success: function(response) {
          response = JSON.parse(response);
          // console.log(response);
          quesData = response;
          console.log(response);
          // Count number of options for question
          var optStr = "opt";
          var optImgStr = "optImage";
          currentWeight = response['weight'];
          for(let i = 1; i <= 5; i++){
            var idNumber = (i+1).toString();
            var optTxt = optStr.concat(idNumber);
            var optImg = optImgStr.concat(idNumber);
            if((response[optTxt] != "") || (response[optImg] != "")){
              currentNumOfOpt++;
            }
          }

          // Active / inactive switch button
          if(response['isActive'] == "1"){
            document.getElementById("activeInactive").checked = true;
            document.getElementById("activeInactive").value = 1;
            document.getElementById("activeInactiveLabel").innerHTML = " : Active";
          }
          else{
            document.getElementById("activeInactive").checked = false;
            document.getElementById("activeInactive").value = 0;
            document.getElementById("activeInactiveLabel").innerHTML = " : Inactive";
          }

          // Pre / Post Switch button
          if(response['isPre'] == "1"){
            document.getElementById("prePost").checked = true;
            document.getElementById("prePost").value = 1;
            document.getElementById("prePostLabel").innerHTML = " : Pre-Question";
          }
          else{
            document.getElementById("prePost").checked = false;
            document.getElementById("prePost").value = 0;
            document.getElementById("prePostLabel").innerHTML = " : Post-Question";
          }

          if(response['storyId'] == 0){
            document.getElementById("prePostSwitchId").style.display = "none";
          }

          document.getElementById('quesId').value = response['questionId'];
          document.getElementById('changeNumOfOptLabel').innerHTML = 'Number-of-options : "'+currentNumOfOpt+'", need to Change ?';

          // Know current option format
          if((response['opt1'] != "") && (response['optImage1'] == "") && (response['optAudio1'] == "")){
            currentOptFormat = 1;
            currentOptFormatTxt = "Text Only";
          }
          else if((response['opt1'] == "") && (response['optImage1'] != "") && (response['optAudio1'] == "")){
            currentOptFormat = 2;
            currentOptFormatTxt = "Image Only";
          }
          else if((response['opt1'] != "") && (response['optImage1'] != "") && (response['optAudio1'] == "")){
            currentOptFormat = 3;
            currentOptFormatTxt = "Text + Image";
          }
          else if((response['opt1'] != "") && (response['optImage1'] == "") && (response['optAudio1'] != "")){
            currentOptFormat = 4;
            currentOptFormatTxt = "Text + Audio";
          }
          else if((response['opt1'] == "") && (response['optImage1'] != "") && (response['optAudio1'] != "")){
            currentOptFormat = 5;
            currentOptFormatTxt = "Image + Audio";
          }
          else if((response['opt1'] != "") && (response['optImage1'] != "") && (response['optAudio1'] != "")){
            currentOptFormat = 6;
            currentOptFormatTxt = "Text + Image + Audio";
          }
          document.getElementById('questionId').value = response['qText'];
          document.getElementById('changeOptFormatLabel').innerHTML = 'Option format : "'+currentOptFormatTxt+'", need to Change ?';
          if(response['qImage'] != ""){
            // console.log(response['qImage']);
            document.getElementById('quesResImg').src = "<?= base_url();?>"+response['qImage'];
            document.getElementById('currQuesImg').value = response['qImage'];
            document.getElementById('quesResAreaImg').style.display = 'inline';
            // document.getElementById('quesResAudio').style.display = 'inline';
          }

          if(response['weight'] != ""){
            document.getElementById('hasScoreLabelId').innerHTML = 'Weight is : "'+response['weight']+'" , need to change ?';
          }
          else{
            document.getElementById('hasScoreLabelId').innerHTML = "No Weight, Need to change ?"
          }

          var isMcq = isMCQorNot(response['optNmbrForAns']);
          if(isMcq == 1){
            document.getElementById('quesTypeLabelId').innerHTML = 'Answer Type : MCQ, need to Change ?';
          }
          else{
            document.getElementById('quesTypeLabelId').innerHTML = 'Answer Type : Single Choice, need to Change ?';
          }

          $('#exampleModal').modal('show');
        }
    })
}

// To check is MCQ?
function isMCQorNot(answer){
  var arr = answer.split(",");
  if(arr.length > 1){
    isCurrentMCQ = 1;
    return isCurrentMCQ;
  }
  else{
    isCurrentMCQ = 0;
    return isCurrentMCQ;
  }
}

// When Generic is selected
$('#genericId').on('change', function(){
    var genericId = this.value;
    var e = document.getElementById('genericId');
    document.getElementById('genericAreaId').style.display = 'none';
    document.getElementById('storyAreaId').style.display = 'none';
    document.getElementById('editQuesAreaId').style.display = 'none';
    document.getElementById('quesTableId').style.display = "block";
    document.getElementById('titleId').innerHTML = "Question List : "+e.options[e.selectedIndex].text;
    document.getElementById('titleId').style.display = "block";
    $.ajax({
        url: "<?= base_url('SuperAdminController/getGenericQuestions') ?>",
        type: 'POST',
        data: {
            genericId : genericId,
        },
        success: function(response) {
            response = JSON.parse(response);
            var temp = response.length;
            // console.log(response);
            if(temp > 0){
              for(let i = 0; i < temp; i++){
                let tbody = document.getElementById('quesTableBodyId');
                var btnUpdate = document.createElement("button");
                var quesId = response[i]['questionId'];
                btnUpdate.innerHTML = "Update";
                btnUpdate.className = "btnUpdateClass";
                btnUpdate.name = "btnUpdate";
                btnUpdate.type = "button";
                btnUpdate.value = quesId;
                var btnUpdateId = "btnUpdateId"+i;
                btnUpdate.id = btnUpdateId;
                let row = tbody.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                cell1.innerHTML = response[i]['qText'];
                cell2.appendChild(btnUpdate);
              }
              $(".btnUpdateClass").on("click", function() {
                var questionId = this.value;
                updateQuestion(questionId);
              });
            }
        }
    })
});

// When Story is selected
$('#storyId').on('change', function(){
    var storyId = this.value;
    var e = document.getElementById('storyId');
    document.getElementById('genericAreaId').style.display = 'none';
    document.getElementById('storyAreaId').style.display = 'none';
    document.getElementById('editQuesAreaId').style.display = 'none';
    document.getElementById('quesTableId').style.display = "block";
    document.getElementById('titleId').innerHTML = "Question List : "+e.options[e.selectedIndex].text;
    document.getElementById('titleId').style.display = "block";
    $.ajax({
        url: "<?= base_url('SuperAdminController/getStoryQuestions')?>",
        type: 'POST',
        data: {
            storyId : storyId,
        },
        success: function(response) {
            response = JSON.parse(response);
            var temp = response.length;
            // console.log(response);
            if(temp > 0){
              for(let i = 0; i < temp; i++){
                let tbody = document.getElementById('quesTableBodyId');
                var btnUpdate = document.createElement("button");
                var quesId = response[i]['questionId'];
                btnUpdate.innerHTML = "Update";
                btnUpdate.className = "btnUpdateClass";
                btnUpdate.name = "btnUpdate";
                btnUpdate.type = "button";
                btnUpdate.value = quesId;
                var btnUpdateId = "btnUpdateId"+i;
                btnUpdate.id = btnUpdateId;
                let row = tbody.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                cell1.innerHTML = response[i]['qText'];
                cell2.appendChild(btnUpdate);
              }
              $(".btnUpdateClass").on("click", function() {
                var questionId = this.value;
                updateQuestion(questionId);
              });
            }
            else{

            }
            
        }
    })
});

// To update Name, Phone, Email(LoginId), Address
// function updateStaffData(staffId){

//   $.ajax({
//     url: "</?= base_url('CompanyAdminController/getStaffDetails') ?>",
//     type: 'POST',
//     data: {
//       staffId : staffId,
//     },
//     success: function(response) {
//       response = JSON.parse(response);

//       console.log(response);

//       document.getElementById('empIdInput').value = response['staffId'];
//       document.getElementById('empNameInput').value = response['name'];
//       document.getElementById('empPhoneInput').value = response['phone'];
//       document.getElementById('empEmailInput').value = response['email'];
//       document.getElementById('empAddressInput').value = response['address'];
//       document.getElementById('empPswdInput').value = response['password'];

//       document.getElementById('empName').style.display = "block";
//       document.getElementById('empPhone').style.display = "block";
//       document.getElementById('empEmail').style.display = "block";
//       document.getElementById('empAddress').style.display = "block";
//       document.getElementById('empPswd').style.display = "block";
//       document.getElementById('modalFooter').style.display = "block";

//     }
//   })
// }

// function activeInactiveEmp(staffId, isActive){

//   $.ajax({
//     url: "</?= base_url('CompanyAdminController/activeInactiveStaff') ?>",
//     type: 'POST',
//     data: {
//       staffId : staffId,
//       isActive : isActive,
//     },
//     success: function(response) {
//       window.location.href = "</?php echo base_url('staff')?>";
//     }
//   })
// }

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