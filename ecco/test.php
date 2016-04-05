<?php include_once('config.php'); ob_start();  ?>
<?php

     $get_email = [];
     $sql="SELECT user_id,username,user_level,email FROM login_users";

    $result_mail = mysql_query($sql) or die(mysql_error());
    $num_rows = mysql_num_rows($result_mail);

    while($row=mysql_fetch_array($result_mail)) {

            $user_level = $row['user_level'];
            $list = unserialize($user_level);
            //$get_email[] =$row['email'];
            if($list[0]==1 || $list[0]==2) {
                $get_email[] =$row['email'];
            }

    }

     $email_bcc = implode(",",$get_email);


     $key =rand(999, 9999);
     $contract_num = mt_rand( 10000000, 99999999);
     $contract_num = "TTAREQ-".$contract_num;

     $SQL ="INSERT INTO help
      (fname,lname,date_time,enq_time,position,agency,region,emailid,cnt_no,queries,active_key,contract_num)
       VALUES(
       '".$_POST['fname']."',
       '".$_POST['lname']."',
       '".date('Y-m-d',strtotime($_POST['date_time']))."',
       '".$_POST['enq_time']."',
       '".$_POST['position']."',
       '".$_POST['agency']."',
       '".$_POST['region']."',
       '".$_POST['email']."',
       '".$_POST['cnt_no']."',
       '".$_POST['query']."',
       '".$key."',
       '".$contract_num."'
       )";

        $user_name = $_POST['fname']." ".$_POST['lname'];
        $result = mysql_query($SQL);

        $sql="SELECT * FROM agency where id ='".$_POST['agency']."'";
        $result_agency = mysql_query($sql) or die(mysql_error());
        while($row_agency=mysql_fetch_array($result_agency))
        {
            $agency_name = $row_agency['name'];
            $agency_address = $row_agency['street'].",".$row_agency['city'].",".$row_agency['state'].",".$row_agency['zip'];
            $Manage_name = $row_agency['manager_name'];
            $agency_cntno = $row_agency['phone'];
          }

          //$current_date = date('Y-m-d H:m:s');
           date_default_timezone_set('America/New_York');
           $current_date = date('Y-m-d h:i:s A');
          /* date_default_timezone_set("America/Los_Angeles");
          $current_date = date('Y-m-d H:m:s'); */
          $insert_tta ="INSERT INTO TTA_Forms
                      (agency_id,contract_num,status,AgencyName,ManagerName,AgencyContactNumber,AgencyAddress,TTA_inquiry_notes,TTA_Contact_Phone,user_name,TTA_Email,created_date,regarding,updated_date,TTA_Referral,regarding_notes)
                      values(
                      '".$_POST['agency']."',
                      '".$contract_num."',
                      'pending',
                      '".$agency_name."',
                      '".$Manage_name."',
                      '".$agency_cntno."',
                      '".$agency_address."',
                      '".$_POST['query']."',
                      '".$_POST['cnt_no']."',
                      '".$user_name."',
                      '".$_POST['email']."',
                      '".$current_date."',
                      '".$_POST['regarding']."',
                      '".$current_date."',
                      '".$user_name."',
                      '".$_POST['regarding_notes']."'
                      )";
        $result_tta = mysql_query($insert_tta);


        if($result==1) {
            confimation_mail_user($_POST['email'],$user_name,$agency_name,$_POST['date_time'],$_POST['position'],$_POST['region'],$_POST['cnt_no'],$_POST['query'],$_POST['regarding'],$_POST['regarding_notes']);
            information_mail_admin($_POST['email'],$user_name,$agency_name,$_POST['agency'],$_POST['date_time'],$_POST['position'],$_POST['region'],$_POST['cnt_no'],$_POST['query'],$_POST['regarding'],$_POST['regarding_notes'],$email_bcc);
        }

function confimation_mail_user($email,$user_name,$agency,$time,$position,$region,$cnt_no,$query,$regarding,$regarding_notes) {

    require 'mail/class.phpmailer.php';

    try {
        $mail = new PHPMailer(true); //New instance, with exceptions enabled

        $message = '<html><body>';
        $message .= '<table width="100%"; border="0"  cellpadding="10">';
        $message .= "<tr><td colspan=2>Marcus,<br /><br />An Ecco has been submitted by  ".$agency."</td></tr>";
        $message .= "<tr><td colspan=2 font='colr:#999999;'>Ecco Intake</td></tr>";
        $message .= "<tr><td colspan=2 font='colr:#999999;'>--------------------------------------</td></tr>";
        $message .= "<tr><td colspan=2 font='colr:#999999;'><h3>Your Selected Resources</h3><ul>";

        $pattern = '/(.*\/)(.*)/';
        $replacement = '$2';


        foreach($_POST['document'] as $document) {

            $message .=  '<li><a href="' . $document . '">' . preg_replace($pattern, $replacement, urldecode($document)) . '</a></li>';
        }

        $message .= "</ul></td></tr>";
        $message .= "<tr><td colspan=2 font='colr:#999999;'>Agency: ".$agency."<br/>Time Submitted:".date ('d M Y',strtotime($time))."<br />Requester:".$user_name."<br />Your Position:".$position."<br />Address:".$email."<br />Contact Number:".$cnt_no."<br />Nature of Query:".$query."<br />Regarding:  ".$regarding."</td></tr>";
        $message .= "<tr><td colspan=2 font='colr:#999999;'>Thanks for using Ecco!</td></tr>";
        $message .= "<tr><td colspan=2><img src='".$img_path."' style='width:200px;'/></td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";
        $body  =$message;
        $mail->IsSMTP();                           // tell the class to use SMTP
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Port       = 25;                    // set the SMTP server port
        $mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
        $mail->Username   = "vtestid11@gmail.com";     // SMTP server username
        $mail->Password   = "vivid123";            // SMTP server password

        $mail->IsSendmail();  // tell the class to use Sendmail
        $mail->AddReplyTo("victor.tolbert@gmail.com","Victor");
        $mail->From       = "victor.tolbert@gmail.com";
        $mail->FromName   = "Victor";

        $to = $email;

        $mail->AddAddress($to);

        // for($i=0;$i<=3;$i++) {
        //     $sql_doc="SELECT * FROM documents where id ='".$_POST['document'][$i]."'";
        //     $result_document = mysql_query($sql_doc) or die(mysql_error());
        //     while($row_document=mysql_fetch_array($result_document))
        //     {
        //       $mail->addAttachment('../'.$row_document['document_name']);
        //     }
        // }

        foreach($_POST['document'] as $document) {
            // var_dump($document);
            // $mail->addAttachment($document);

            // $mail->addStringAttachment(file_get_contents($document), urldecode($document));

        }

        $mail->Subject  = "An ECCO has been submitted";

        #$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->WordWrap   = 80; // set word wrap

        $mail->MsgHTML($body);

        $mail->IsHTML(true); // send as HTML

        $mail->Send();
        #echo '<pre>'; print_r($mail);
        #echo 'Message has been sent.';
    } catch (phpmailerException $e) {
        echo $e->errorMessage();
    }
}

function information_mail_admin($email,$user_name,$agency,$time,$requester,$position,$region,$cnt_no,$query,$regarding,$regarding_notes,$email_bcc) {
    $img_path = "http://www.".$_SERVER["SERVER_NAME"]."/"."image/email.png";
   /** user mail start here */
    // $to   = 'mbouligny@progroup.us';
    $to   = 'victor.tolbert@gmail.com';
    // $bcc = $email_bcc;
    $from = $email;
    $subject ="An ECCO has been submitted";

    $headers = "From: " . strip_tags($from) . "\r\n";
    // $headers .= "CC: ceoden@ingowhiz.com\r\n";
    // $headers .= 'BCC: '. $bcc . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = '<html><body>';
    $message .= '<table width="100%"; border="0"  cellpadding="10">';
    $message .= "<tr><td colspan=2>Marcus,<br /><br />An Ecco has been submitted by  ".$agency."</td></tr>";
    $message .= "<tr><td colspan=2 font='colr:#999999;'>Ecco Intake</td></tr>";
    $message .= "<tr><td colspan=2 font='colr:#999999;'>--------------------------------------</td></tr>";
    $message .= "<tr><td colspan=2 font='colr:#999999;'>Agency: ".$agency."<br/>Time Submitted:  ".date ('d M Y',strtotime($time))."<br />Requester:  ".$user_name."<br />Your Position:  ".$position."<br />Address:  ".$email."<br />Contact Number:  ".$cnt_no."<br />Nature of Query:  ".$query."<br />Regarding:  ".$regarding."<br />Regarding Notes:  ".$regarding_notes."</td></tr>";
    $message .= "<tr><td colspan=2 font='colr:#999999;'>Thanks for using Ecco!</td></tr>";
    $message .= "<tr><td colspan=2><img src='".$img_path."' style='width:200px;'/></td></tr>";
    $message .= "</table>";
    $message .= "</body></html>";
    #echo '<pre>'; print_r($message);
    mail($to, $subject, $message, $headers);

 }

?>

<script type="text/javascript">
window.location.href = '/help';
</script>
