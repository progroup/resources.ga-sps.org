<?php snippet('header') ?>
<?php snippet('banner') ?>
<script>
    function success_msg() {
        alert('Successfully Completed, Thank You!');
    }
    function success_msg_request()
    {
        var selectagency= $('select[name="agency"]').val();
        var selectfname= $('select[name="fname"]').val();
        var selectlname= $('select[name="lname"]').val();
        var selectemail= $('select[name="email"]').val();
        var selectphone= $('select[name="cnt_no"]').val();
        if(selectagency=='') {
            alert('Select Agency'); return false;
        }
        else if(selectfname=='' || selectlname=='')
        {
            alert('Enter First Name or Last Name'); return false;
        }
        else if(selectemail=='')
        {
            alert('Enter Email'); return false;
        }
        else
        {
            alert('Successfully Completed, Thank You!');
            return true;
        }
    }

    function refresh() {
        window.location.reload();
    }
</script>
<?php echo css('/assets/css/prism.css') ?>
<?php echo css('/assets/css/chosen.css') ?>

<?php include_once('ecco/config.php');
error_reporting(0);
#-------Report insert-----------
if(isset($_POST['tta_reports'])){
    if(is_array($_SESSION['AttachmentUpload'])){
        $UploadFolderName_temp = array();
        $UploadFileName_temp = array();
        foreach($_SESSION['AttachmentUpload'] as $key => $value){
            $UploadFolderName_temp[] = $key;
            $UploadFileName_temp[] = $value;
        }
        $UploadFolderName = serialize($UploadFolderName_temp);
        $UploadFileName = serialize($UploadFileName_temp);
    }else{
        $UploadFolderName = "";
        $UploadFileName = "";
    }
   $agency_id= $_POST['report_agency'];
    $SQL = "INSERT INTO TTA_Reports_uploads
    (agency, fname, lname, position, emailid, contact_no, report_note, uploadfoldername, uploadfilename,uploaduser)
    VALUES(
        '" . $_POST['report_agency'] . "',
        '" . $_POST['report_fname'] . "',
        '" . $_POST['report_lname'] . "',
        '" . $_POST['report_position'] . "',
        '" . $_POST['report_email'] . "',
        '" . $_POST['report_cnt_no'] . "',
        '" . $_POST['report_notes'] . "',
        '" . $UploadFolderName . "',
        '" . $UploadFileName . "','Help'
     )";
    $result = mysql_query($SQL);
    $insert_report_id=mysql_insert_id();

    #------------REport Import---------------

    set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
    include 'Classes/PHPExcel/IOFactory.php';
    $inputFileName = $_SERVER['DOCUMENT_ROOT']."/assets/uploader/php-traditional-server/files/".$UploadFolderName_temp[0]."/".$UploadFileName_temp[0];
    //$inputFileName = $_SERVER['DOCUMENT_ROOT'].'/test.csv';

    try {
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    } catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

    //$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    //$arrayCount = count($allDataInSheet);

    //$worksheet=$objPHPExcel->getActiveSheet();
    //$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $cell_titles_val='';

    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;

    //------Check "Setting / Location" is in 2E
    $cell_titles = $worksheet->getCellByColumnAndRow(4,2);
    $cell_titles_val = $cell_titles->getValue();
    //------Check "Setting / Location" is in A3
    $cell_Strategy = $worksheet->getCellByColumnAndRow(0,3);
    $cell_Strategy_val = $cell_Strategy->getValue();

    //---------2E cell value location - sheet only insert to DB
    if($cell_titles_val == 'Setting / Location' || $cell_titles_val=='Setting/Location' || $cell_titles_val=='Setting/    Location' || $cell_titles_val=='Location'){
    for ($row = 3; $row <= $highestRow; ++ $row) {
    $val=array();
    for ($col = 4; $col < $highestColumnIndex; ++ $col) {
    $cell = $worksheet->getCellByColumnAndRow($col, $row);
    if($col=='6'||$col=='7'||$col=='8'||$col=='9'){
    $val[] = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'm/d/Y');
    }else{
    $val[] = $cell->getValue();
    }
    }

    $location               = trim($val[0]);
    $responsible            = trim($val[1]);
        if($val[2]=='') $projected_start_date='';
        else
        {
            $prj_start=explode('/',trim($val[2]));
            $projected_start_date   = $prj_start[2].'-'.$prj_start[0].'-'.$prj_start[1];
        }
        if($val[3]=='') $projected_end_date     ='';
        else
        {
            $prj_end=explode('/',trim($val[3]));
            $projected_end_date     = $prj_end[2].'-'.$prj_end[0].'-'.$prj_end[1];
        }
        if($val[4]=='') $actual_start_date='';
        else
        {
            $act_start=explode('/',trim($val[4]));
            $actual_start_date      = $act_start[2].'-'.$act_start[0].'-'.$act_start[1];
        }
        if($val[5]=='') $actual_end_date        = '';
        else
        {
            $act_end=explode('/',trim($val[5]));
            $actual_end_date        = $act_end[2].'-'.$act_end[0].'-'.$act_end[1];
        }

    $comment                = trim($val[6]);
    $status_code            = trim($val[7]);

    $count_feilds=@count(array_count_values($val));
    if($count_feilds>0){
    $created=date('Y-m-d H:i:s');
    $uploaduser='Help';
        if($projected_start_date<>'' && $projected_end_date)
        {
            $insertTable1='insert into TTA_Reports_imports (location,responsible,projected_start_date,projected_end_date,actual_start_date,actual_end_date,comment,status_code,sheet_name,report_id,agency_id,created,uploaduser) values("'.$location.'","'.$responsible.'","'.$projected_start_date.'","'.$projected_end_date.'","'.$actual_start_date.'","'.$actual_end_date.'","'.$comment.'","'.$status_code.'","'.$worksheetTitle.'","'.$insert_report_id.'","'.$agency_id.'","'.$created.'","'.$uploaduser.'")';
            $result1=mysql_query($insertTable1);
        }

    }
    }
    }//--------------Setting / Location

    //---------A3 cell value as Evidenced-based Strategy Name: - sheet only insert to DB
    if($cell_Strategy_val == 'Evidenced-based Strategy Name:'){
    $Strategy_val=array();
    for($row = 3; $row <= 11; ++ $row) {
    $cell = $worksheet->getCellByColumnAndRow(1, $row);
    $Strategy_val[] = $cell->getValue();
    }
    //print_r($Strategy_val);

    $strategy_name          = trim($Strategy_val[0]);
    $variables_factors      = trim($Strategy_val[1]);
    $strategy_intent        = trim($Strategy_val[2]);
    $target_audience        = trim($Strategy_val[3]);
    $iom_category           = trim($Strategy_val[4]);
    $estimated_reach        = trim($Strategy_val[5]);
    $strategy_dosage        = trim($Strategy_val[6]);
    $strategy_frequent      = trim($Strategy_val[7]);
    $resources              = trim($Strategy_val[8]);

    $count_feilds=@count(array_count_values($Strategy_val));
    if($count_feilds>0){
    $insertTable1='insert into TTA_Reports_imports_strategy (strategy_name,variables_factors,strategy_intent,target_audience,iom_category,estimated_reach,strategy_dosage,strategy_frequent,resources,sheet_name,report_id,uploaduser) values("'.$strategy_name.'","'.$variables_factors.'","'.$strategy_intent.'","'.$target_audience.'","'.$iom_category.'","'.$estimated_reach.'","'.$strategy_dosage.'","'.$strategy_frequent.'","'.$resources.'","'.$worksheetTitle.'","'.$insert_report_id.'","Help")';
    $result1=mysql_query($insertTable1);
    //echo '<br>';
    }

    }//--------------Evidenced-based Strategy Name:

    }


    #------------REport Import---------------
    if($insert_report_id)
    {
        $inputFileName = "http://ga-sps.org/assets/uploader/php-traditional-server/files/".$UploadFolderName_temp[0]."/".$UploadFileName_temp[0];
        $username=$_POST['report_fname'].' '.$_POST['report_lname'];

        $sql_agency = mysql_query("SELECT name FROM agency WHERE id =".$_POST['report_agency']);
        $agency_name_row=mysql_fetch_row($sql_agency);
        $agencyname = $agency_name_row[0];

        @information_mail_admin($_POST['report_email'], $username, $agencyname, date('Y-m-d'),  $_POST['report_position'], $_POST['report_cnt_no'], $_POST['report_notes'], $inputFileName,$UploadFileName_temp[0],$agency_id);
    }

}
function information_mail_admin($email, $user_name, $agency, $time, $position, $cnt_no,$regarding_notes, $inputfile_withpath,$uploadfilename,$agency_id) {

    $img_path = "http://www." . $_SERVER["SERVER_NAME"] . "/assets/images/logo-gasps.png";
    $progroup_img_path = "http://www." . $_SERVER["SERVER_NAME"] . "/assets/images/Powered_by_ProGroup.png";
    $to   = 'mbouligny@progroup.us';
    // $to   = 'victor.tolbert@gmail.com';
    

    $from = $email;
    $subject = $agency." has upload an IP Report ";

    $message = '<html><body>';
    $message .= '<table width="100%" border="0"  cellpadding="10">';
    $message .= "<tr><td colspan=2 style='border: 1px solid #98002e; background-color: #ffffff; border-radius: 3px'><a href='http://ga-sps.org'><img src='".$img_path."' style='width:250px;' alt='Georgia Strategic Prevention System'/></a></td></tr>";
    $message .= "<tr><td colspan=2><p>ECCO Report has been submitted by  <b>" . $agency . "</b></p>";

    if($uploadfilename){
        $message .= "<p>The following report were uploaded :</p><ul style='margin:0;padding:0'>";

            $message .=  '<li style="margin:0 0 0 20px;padding:0"><a href="'.$inputfile_withpath.'">' . $uploadfilename . '</a></li>';
        $message .= "</ul>";
    }
    $message .= "</td></tr><tr><td colspan='2' font='color:#999999;'><table border='1' cellspacing='0' cellpadding='5'>";

    $message .= "<tr><th align='left' style='text-align: left;border-left: solid 1px #e9e9e9; background: #ffffff' bgcolor='ffffff'>Agency</th><td>" . $agency . "</td><tr>";
    $message .= "<tr><th align='left' style='text-align: left;border-left: solid 1px #e9e9e9; background: #ffffff' bgcolor='ffffff'>Time Submitted</th><td>" .  date('d M Y',strtotime($time)) . "</td><tr>";
    $message .= "<tr><th align='left' style='text-align: left'>Uploader</th><td>" . $user_name . "</td><tr>";
    $message .= "<tr><th align='left' style='text-align: left'>Position</th><td>" . $position . "</td><tr>";
    $message .= "<tr><th align='left' style='text-align: left'>Email</th><td>" . $email . "</td><tr>";
    $message .= "<tr><th align='left' style='text-align: left'>Contact Number</th><td>" . $cnt_no . "</td><tr>";
    $message .= "<tr><th align='left' style='text-align: left'>Regarding Notes</th><td>" . $regarding_notes . "</td><tr>";

    $message .= "</table></td></tr>";
    $message .= "<tr><td colspan=2 style='background:#000000'><img width='200px' height='56px' alt='Powered by the Prospectus Group' src='" . $progroup_img_path. "' style='width:200px;height::56px;background: #000000;'/></td></tr>";
    $message .= "</table>";
    $message .= "</body></html>";
    set_include_path(get_include_path() . PATH_SEPARATOR . 'ecco/');
    require 'mail/class.phpmailer.php';
    $mail = new PHPMailer(true); //New instance, with exceptions enabled
    $body  = $message;
    $mail->IsSMTP();                               // tell the class to use SMTP
    $mail->SMTPAuth   = true;                      // enable SMTP authentication
    $mail->Port       = 25;                        // set the SMTP server port
    $mail->Host       = "ssl://smtp.gmail.com";    // SMTP server
    $mail->Username   = "vtestid11@gmail.com";     // SMTP server username
    $mail->Password   = "vivid123";                // SMTP server password
    $mail->IsSendmail();                           // tell the class to use Sendmail
    $mail->AddReplyTo("mbouligny@progroup.us","Marcus");
    $mail->From       = "mbouligny@progroup.us";
    $mail->FromName   = "Marcus";

    $bcc_sql=mysql_query("SELECT email,name FROM TTA_Forms T inner join login_users U on U.username=T.assignedUser WHERE agency_id=".$agency_id."  group by assignedUser ");
    while($row_e = mysql_fetch_array($bcc_sql)) {
        $mail->AddBCC($row_e['email'], $row_e['name']);
    }
    $mail->AddAddress($to);
    $mail->Subject    = $subject;
    $mail->WordWrap   = 80; // set word wrap
    $mail->MsgHTML($body);
    $mail->IsHTML(true); // send as HTML
    $mail->Send();
}

$_SESSION['AttachmentUpload'] = array();
#-------Report insert-----------
?>
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="page-header">
                <h1><?php echo $page->title()->html() ?></h1>
            </div>
            <?php echo $page->text()->kirbytext() ?>
            <!-- Your Custom Code -->
<style>
.well{ margin:30px 0 0 0 ; }
.help-form{ margin:30px 0;  }
.form-group{ margin-bottom: 25px; }
.form-group label{ font-weight:500; }
.form-group .form-control{ border-radius:0px; }
.side-by-side .chosen-container.chosen-container-multi {width:663px !important;}
.chosen-container-multi{ width: 100%!important; }
.chosen-choices .search-field, .chosen-choices .search-field input{ display: block; width: 100%; }
.qq-upload-button{ width: 130px!important; }
.radio_group_help{font-size:16px;margin:20px 0 40px 18px}.radio_group_help .radio-inline{margin:0 60px 0 0;font-weight:700;color:#98002e}@-webkit-keyframes click-wave{0%{width:40px;height:40px;opacity:.35;position:relative}100%{width:200px;height:200px;margin-left:-80px;margin-top:-80px;opacity:0}}@-moz-keyframes click-wave{0%{width:40px;height:40px;opacity:.35;position:relative}100%{width:200px;height:200px;margin-left:-80px;margin-top:-80px;opacity:0}}@-o-keyframes click-wave{0%{width:40px;height:40px;opacity:.35;position:relative}100%{width:200px;height:200px;margin-left:-80px;margin-top:-80px;opacity:0}}@keyframes click-wave{0%{width:30px;height:30px;opacity:.35;position:relative}100%{width:200px;height:200px;margin-left:-80px;margin-top:-80px;opacity:0}}.option-input,.option-input:checked::before{width:30px;height:30px;display:inline-block}.option-input{-webkit-appearance:none;-moz-appearance:none;-ms-appearance:none;-o-appearance:none;appearance:none;top:13.33px;-webkit-transition:all .1s ease-out 0;-moz-transition:all .1s ease-out 0;transition:all .1s ease-out 0;background:#FFF;border:1px solid #bababa;color:#fff;cursor:pointer;outline:0;position:relative;margin-right:.5rem;z-index:1000}.option-input:hover{background:#9faab7;border:1px solid #9faab7}.option-input:focus{border:none}.option-input:checked{background:#98002e;border:1px solid #98002e}.option-input:checked::before{position:absolute;content:'\2714';font-size:18px;text-align:center;line-height:32px}.option-input:checked::after{-webkit-animation:click-wave .65s;-moz-animation:click-wave .65s;animation:click-wave .65s;background:#98002e;content:'';display:block;position:relative;z-index:100}.option-input.radio,.option-input.radio::after{border-radius:4px}input.option-input.radio{margin-left:-38px;margin-top:-18px}


</style>

            <!-- START PAGE CONTENT -->
            <div class="page-content-transparent">
                <div class="well">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>ECCO Intake and Report Upload</h3>
                            <!-- START HELP FORM -->
                            <div class="help-form m-b-50">
                                <div id="form-personal" >
                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php $today = date("m/d/Y"); ?>
                                                <label>Date</label>
                                                <input type="text" class="form-control" placeholder="Pick a date" id="start-date" name="date_time" readonly value="<?php echo $today ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php
                                                    $amNY = new DateTime('America/New_York');
                                                    $estTime = $amNY->format('h:i:A');
                                                ?>
                                                <label>Time [EST]</label>
                                                <input type="text" class="form-control" placeholder="Pick a time" id="timepicker" readonly value="<?php echo $estTime ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="radio_group_help">
                                                  <label class="radio-inline">
                                                    <input type="radio" checked class="option-input radio" name="choose_tta_upload"  value="_TTA" />
                                                    Request TTA
                                                  </label>
                                                  <label class="radio-inline">
                                                    <input type="radio" class="option-input radio" name="choose_tta_upload" value="_Upload" />
                                                    Upload Report
                                                  </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div id="helpRequest_TTA" class="formConentArea" style="display: block;">
                                            <form id="form-personal"  role="form" autocomplete="off" method="post" action="/ecco/insert_help.php" onsubmit="success_msg_request()">
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Your Agency</label>
                                                <?php
                                                    $sql = 'SELECT DISTINCT(name), id FROM agency ORDER BY name ASC';
                                                    $result_mail = mysql_query($sql) or die(mysql_error());
                                                    $num_rows = mysql_num_rows($result_mail);
                                                ?>
                                                <select class="form-control" data-init-plugin="select2" id="agency" name="agency" required>
                                                    <!-- <option value="GSU CITF">GSU CITF</option> -->
                                                    <option value="">Select Agency </option>
                                                    <?php while($row = mysql_fetch_array($result_mail)) : ?>
                                                        <option value="<?php echo $row['id']; ?>" <?php if($row['name'] == "GSU CITF") { echo "selected"; } ?>>
                                                            <?php echo $row['name'] ?>
                                                        </option>
                                                    <?php endwhile ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input type="text" class="form-control" id="fname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Last name</label>
                                                <input type="text" class="form-control" id="lname" name="lname" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Your Position</label>
                                                <input type="text" class="form-control" id="position" name="position" placeholder="Type Here" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="e.g. mail@domain.com" required id="email" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control"  placeholder="e.g (324) 234-3243" required id="cnt_no" name="cnt_no">
                                            </div>
                                        </div>
                                    </div>

                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>What is the nature of your query?</label>
                                                            <textarea class="form-control" name="query" id="query" placeholder="Write your query here" aria-invalid="false"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Resources <small class="hint-text">(Select resources related to your request)</small></label>
                                                            <select data-placeholder="Select your Resources" name="document[]" style="width:100%;" multiple class="chosen-select" tabindex="8" >
                                                            <?php $results = $pages->children(); ?>
                                                            <?php foreach ($results as $result) : ?>
                                                                <?php foreach ($result->files()->sortBy('modified', 'desc') as $file) : ?>
                                                                <option value="<?php echo $file->url() ?>">
                                                                    <?php echo $file->title()->titlecase()->or($file->page()->title()->titlecase()) ?>
                                                                    (
                                                                    <?php if (str::contains($file->extension(), 'doc')) : ?>
                                                                        Word
                                                                    <?php endif ?>
                                                                    <?php if ($file->extension() == 'pdf') : ?>
                                                                        PDF
                                                                    <?php endif ?>
                                                                    <?php if (str::contains($file->extension(), 'xls')) : ?>
                                                                        Excel
                                                                    <?php endif ?>
                                                                    <?php if (str::contains($file->extension(), 'ppt')) : ?>
                                                                        Powerpoint
                                                                    <?php endif ?>
                                                                    <?php if ($file->type() == 'image') : ?>
                                                                        Image
                                                                    <?php endif ?>
                                                                    <?php if ($file->type() == 'video') : ?>
                                                                        Video
                                                                    <?php endif ?>
                                                                    )
                                                                </option>
                                                                <?php endforeach ?>
                                                            <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Regarding</label>
                                                            <select class="form-control" data-init-plugin="select2" name="regarding" id="regarding">
                                                                <option value="">Select</option>
                                                                <option value="Implementation">Implementation</option>
                                                                <option value="Capacity">Capacity</option>
                                                                <option value="Evaluation">Evaluation</option>
                                                                <option value="Technology">Technology</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Regarding Notes</label>
                                                            <textarea class="form-control" name="regarding_notes" id="regarding_notes" placeholder="Write your Regarding Notes here" aria-invalid="false"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Have a document for us to review?</label>
                                                            <div id="fine-uploader-manual-trigger"></div>
                                                        <script type="text/template" id="qq-template-manual-trigger">
                                                            <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
                                                                <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                                                                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
                                                                </div>
                                                                <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                                                                    <span class="qq-upload-drop-area-text-selector"></span>
                                                                </div>
                                                                <div class="buttons">
                                                                    <div class="qq-upload-button-selector qq-upload-button">
                                                                        <div>Select files</div>
                                                                    </div>
                                                                </div>
                                                                <span class="qq-drop-processing-selector qq-drop-processing">
                                                                    <span>Processing dropped files...</span>
                                                                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                                                                </span>
                                                                <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                                                                    <li>
                                                                        <div class="qq-progress-bar-container-selector">
                                                                            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                                                                        </div>
                                                                        <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                                                                        <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                                                                        <span class="qq-upload-file-selector qq-upload-file"></span>
                                                                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                                                                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                                                                        <span class="qq-upload-size-selector qq-upload-size"></span>
                                                                        <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                                                                        <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                                                                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                                                                        <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                                                                    </li>
                                                                </ul>

                                                                <dialog class="qq-alert-dialog-selector">
                                                                    <div class="qq-dialog-message-selector"></div>
                                                                    <div class="qq-dialog-buttons">
                                                                        <button type="button" class="qq-cancel-button-selector">Close</button>
                                                                    </div>
                                                                </dialog>

                                                                <dialog class="qq-confirm-dialog-selector">
                                                                    <div class="qq-dialog-message-selector"></div>
                                                                    <div class="qq-dialog-buttons">
                                                                        <button type="button" class="qq-cancel-button-selector">No</button>
                                                                        <button type="button" class="qq-ok-button-selector">Yes</button>
                                                                    </div>
                                                                </dialog>

                                                                <dialog class="qq-prompt-dialog-selector">
                                                                    <div class="qq-dialog-message-selector"></div>
                                                                    <input type="text">
                                                                    <div class="qq-dialog-buttons">
                                                                        <button type="button" class="qq-cancel-button-selector">Cancel</button>
                                                                        <button type="button" class="qq-ok-button-selector">Ok</button>
                                                                    </div>
                                                                </dialog>
                                                            </div>
                                                        </script>
                                                        </div>

                                                        <div class="clearfix m-b-30"></div>
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                        <button class="btn btn-link" type="reset" onclick="refresh();">Reset</button>
                                                        <input type="hidden" value="<?php echo $image_csrf; ?>" name="image_csrf" />

                                                        <!--END UPLOAD CODE-->
                                                    </div>



                                                </div>
                               </form>
                                </div><!-- End: Request TTA -->

                                <div id="helpRequest_Upload" class="formConentArea" style="display: none;">
                                <form id="form-personal"  role="form" autocomplete="off" method="post" action="" onsubmit="success_msg()">
                                   <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Your Agency </label> <label style="padding-left: 200px;"> <a href="http://ecco.ga-sps.org/reportdashboard.php" target="_blank" > See admin's comment </a> </label>
                                                <?php
                                                    $sql = 'SELECT DISTINCT(name), id FROM agency ORDER BY name ASC';
                                                    $result_mail = mysql_query($sql) or die(mysql_error());
                                                    $num_rows = mysql_num_rows($result_mail);
                                                ?>
                                                <select class="form-control" data-init-plugin="select2" id="agency" name="report_agency" required>
                                                    <!-- <option value="GSU CITF">GSU CITF</option> -->
                                                    <option value="">Select Agency</option>
                                                    <?php while($row = mysql_fetch_array($result_mail)) : ?>
                                                        <option value="<?php echo $row['id']; ?>" <?php if($row['name'] == "GSU CITF") { echo "selected"; } ?>>
                                                            <?php echo $row['name'] ?>
                                                        </option>
                                                    <?php endwhile ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input type="text" class="form-control" id="fname" name="report_fname">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Last name</label>
                                                <input type="text" class="form-control" id="lname" name="report_lname">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Your Position</label>
                                                <input type="text" class="form-control" id="position" name="report_position" placeholder="Type Here">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="report_email" placeholder="e.g. mail@domain.com" id="email" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control"  placeholder="e.g (324) 234-3243" id="cnt_no" name="report_cnt_no">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Report Notes</label>
                                                <textarea class="form-control" name="report_notes" id="report_notes" placeholder="Write your Report Notes here" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                   <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Upload Your Report Here</label>
                                                <div id="fine-uploader-manual-trigger-2"></div>
                                            <script type="text/template" id="qq-template-manual-trigger-2">
                                                <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop report here">
                                                    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                                                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
                                                    </div>
                                                    <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                                                        <span class="qq-upload-drop-area-text-selector"></span>
                                                    </div>
                                                    <div class="buttons">
                                                        <div class="qq-upload-button-selector qq-upload-button">
                                                            <div>Select Report</div>
                                                        </div>
                                                    </div>
                                                    <span class="qq-drop-processing-selector qq-drop-processing">
                                                        <span>Processing dropped files...</span>
                                                        <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                                                    </span>
                                                    <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                                                        <li>
                                                            <div class="qq-progress-bar-container-selector">
                                                                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                                                            </div>
                                                            <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                                                            <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                                                            <span class="qq-upload-file-selector qq-upload-file"></span>
                                                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                                                            <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                                                            <span class="qq-upload-size-selector qq-upload-size"></span>
                                                            <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                                                            <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                                                            <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                                                            <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                                                        </li>
                                                    </ul>

                                                    <dialog class="qq-alert-dialog-selector">
                                                        <div class="qq-dialog-message-selector"></div>
                                                        <div class="qq-dialog-buttons">
                                                            <button type="button" class="qq-cancel-button-selector">Close</button>
                                                        </div>
                                                    </dialog>

                                                    <dialog class="qq-confirm-dialog-selector">
                                                        <div class="qq-dialog-message-selector"></div>
                                                        <div class="qq-dialog-buttons">
                                                            <button type="button" class="qq-cancel-button-selector">No</button>
                                                            <button type="button" class="qq-ok-button-selector">Yes</button>
                                                        </div>
                                                    </dialog>

                                                    <dialog class="qq-prompt-dialog-selector">
                                                        <div class="qq-dialog-message-selector"></div>
                                                        <input type="text">
                                                        <div class="qq-dialog-buttons">
                                                            <button type="button" class="qq-cancel-button-selector">Cancel</button>
                                                            <button type="button" class="qq-ok-button-selector">Ok</button>
                                                        </div>
                                                    </dialog>
                                                </div>
                                            </script>
                                            </div>

                                            <!--END UPLOAD CODE-->
                                        </div>
                                    </div>

                                                <div class="clearfix m-b-30"></div>
                                                <input type="hidden" name="tta_reports" value="1" />
                                                <button class="btn btn-primary" type="submit">Upload</button>
                                                <button class="btn btn-link" type="reset" onclick="refresh();">Reset</button>
                                                <input type="hidden" value="<?php echo $image_csrf; ?>" name="image_csrf" />

                                            </div><!-- End: Uplaod  -->
                                        </div>
                                    </form>
                                    </div>




                                </div>
                            </div>
                            <!-- END HELP FORM -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT -->

            <!-- End Your Custom Code -->
        </div>
        <div class="col-md-3 col-md-pull-9">
            <?php snippet('sidebar') ?>
        </div>
    </div>
</div>
<?php echo js('https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js') ?>
<?php echo js('/assets/js/chosen.jquery.js') ?>
<?php echo js('/assets/js/prism.js') ?>


<script>
$(document).ready(function() {
    $("input[name$='choose_tta_upload']").click(function() {
        var test = $(this).val();

        $("div.formConentArea").hide();
        $("#helpRequest" + test).show();
    });
});
</script>

<script type="text/javascript">
var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>

<?php //echo css('/assets/uploader/css/dropzone.css') ?>
<?php echo css('/assets/uploader/css/fine-uploader-new.min.css') ?>
<?php echo js('/assets/uploader/all.fine-uploader.min.js') ?>
<?php //echo js('/assets/uploader/upload-gallery.js') ?>
<script>
    var manualUploader = new qq.FineUploader({
        element: document.getElementById('fine-uploader-manual-trigger'),
        template: 'qq-template-manual-trigger',
        request: {
            endpoint: "/assets/uploader/php-traditional-server/endpoint.php"
        },
        deleteFile: {
            enabled: true,
            endpoint: "/assets/uploader/php-traditional-server/endpoint.php"
        },
        chunking: {
            enabled: true,
            concurrent: {
                enabled: true
            },
            success: {
                endpoint: "/assets/uploader/php-traditional-server/endpoint.php?done"
            }
        },
        resume: {
            enabled: true
        },
        retry: {
            enableAuto: true,
            showButton: true
        },
        autoUpload: true,
        debug: true
    });

    qq(document.getElementById("trigger-upload")).attach("click", function() {
        manualUploader.uploadStoredFiles();
    });



</script>
<script>
    var manualUploader = new qq.FineUploader({
        element: document.getElementById('fine-uploader-manual-trigger-2'),
        template: 'qq-template-manual-trigger-2',
        request: {
            endpoint: "/assets/uploader/php-traditional-server/endpoint.php"
        },
        deleteFile: {
            enabled: true,
            endpoint: "/assets/uploader/php-traditional-server/endpoint.php"
        },
        chunking: {
            enabled: true,
            concurrent: {
                enabled: true
            },
            success: {
                endpoint: "/assets/uploader/php-traditional-server/endpoint.php?done"
            }
        },
        resume: {
            enabled: true
        },
        retry: {
            enableAuto: true,
            showButton: true
        },
        validation: {
            allowedExtensions: ['csv', 'xls', 'xlsx'],
            itemLimit: 1
        },
        autoUpload: true,
        debug: true
    });

    qq(document.getElementById("trigger-upload")).attach("click", function() {
        manualUploader.uploadStoredFiles();
    });



</script>



<?php snippet('footer') ?>
