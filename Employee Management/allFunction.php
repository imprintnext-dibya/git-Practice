<?php
/**
 *  display error message
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * connection file
 */
require_once 'config.php';
$obj = new EmployeeData();
define("BASE_URL", "https://dev.imprintnext.io/ems/assets/document/");
define("ASSET", $_SERVER['DOCUMENT_ROOT'].'/ems/assets/');
/**
 * POST:Save Employee Data
 * @param $data Employee name,code,Official mail,Department......
 * 
 * @author divya@imprintnext.com
 * @date 15 Nov 2021
 * @return true/false
 */
function insertEmployeeDetails($data){
     $typeId = trim($_POST['typeId']);
     $empName = trim(($_POST['ename']));
     $empCode = trim($_POST['ecode']);
     $officeMail = trim($_POST['offMail']);
     $department = $_POST['department'];
     $designation = $_POST['designation'];
     $joiningDate = $_POST['joinDate'];
     $dob = trim($_POST['dob']);
     $gender = trim($_POST['gender']);
     $country = $_POST['country'];
     $state = $_POST['state'];
     $city = $_POST['city'];
     $pincode = trim($_POST['pincode']);
     $currentAaddress = $_POST['caddress'];
     $permanentAddress = $_POST['paddress'];
     $qualification = $_POST['qualification'];
     $personalMail = trim($_POST['pmail']);
     $contact = trim($_POST['phone']);
     $parentContact = trim($_POST['pcontact']);
     $pancard = trim($_POST['pan']);
     $aadhar = trim($_POST['aadhar']);
     $drivingLicense = trim($_POST['dl']);
     $status = $_POST['status'];
     global $obj;
     $mysqli = $obj->connect();
     $upload_path = '/uploads/';
     $profileImage = basename($_FILES['image']['name']);
     $fileType = pathinfo($profileImage,PATHINFO_EXTENSION);
     $newFileName =time().".".$fileType ;
     $targetPath = ASSET.$upload_path . $newFileName ;
     $valStatus = (array) json_decode(validateInsertData($data));
     if($valStatus['status'] == 0){
          move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
          $sql = "INSERT INTO employee_details (type_id,emp_name,emp_code,office_email,department,designation,joining_date,gender,
                       dob,country,state,city,pincode,current_address,permanent_address,
                       qualification,personal_email,contact_no,guardian_contact_no,pancard_no,
                       aadhar_card,driving_license,profile_image,status)
                       VALUES('$typeId','$empName','$empCode','$officeMail','$department','$designation','$joiningDate', 
                       '$gender','$dob','$country','$state','$city','$pincode','$currentAaddress','$permanentAddress',
                       '$qualification','$personalMail','$contact','$parentContact','$pancard','$aadhar',
                       '$drivingLicense','$newFileName','$status')";
          $result = $mysqli->query($sql);
          $lastid =  $mysqli->insert_id;
          if($lastid){ 
          //  calling insert login data function 
          insertLoginData($data,$lastid);                   
               return json_encode(array('message' => 'employee Data Inserted.', 'status' => true));
          }else{
               return json_encode(array('message' => 'Failed.', 'status' => false));
          }
     }else{
          return json_encode(array('message' => $valStatus['message'], 'status' => false));
     }
     $mysqli->close();
}
/**
 * PUT: Save employee login information
 * @param $data Official mail,Password,User Role(admin/user)
 * 
 * @author divya@imprintnext.com
 * @date 15 Nov 2021
 * @return true/false
 */
function insertLoginData($data,$lastid){
     $userName  = $_POST['offMail'];
     $userPassword  = md5($_POST['password']);
     $userRole  = $_POST['urole'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "INSERT INTO login_page (emp_id,user_id,password,user_role)VALUES('$lastid','$userName', '$userPassword', '$userRole')";
     $mysqli->query($sql);
     $mysqli->close();
}
/**
 * PUT: update employee data
 * @param $data Employee Id,name,code,official mail,department......
 * 
 * @author divya@imprintnext.com
 * @date 15 Nov 2021
 * @return true/false
 */
function updateData($data){
      $empId = trim($_POST['emp_id']); 
      $typeId = trim($_POST['typeId']);
      $empName = trim($_POST['ename']);
      $empCode = trim($_POST['ecode']);
      $officeMail = $_POST['offMail'];
      $department = $_POST['department'];
      $designation = $_POST['designation'];
      $joiningDate = $_POST['joinDate'];
      $dob = $_POST['dob'];
      $gender = $_POST['gender'];
      $country = $_POST['country'];
      $state = $_POST['state'];
      $city = $_POST['city'];
      $pincode = trim($_POST['pincode']);
      $currentAaddress = $_POST['caddress'];
      $permanentAddress = $_POST['paddress'];
      $qualification = $_POST['qualification'];
      $personalMail = $_POST['pmail'];
      $contact = trim($_POST['phone']);
      $parentContact = trim($_POST['pcontact']);
      $pancard = trim($_POST['pan']);
      $aadhar = trim($_POST['aadhar']);
      $drivingLicense = trim($_POST['dl']);
      $status = $_POST['status'];
      global $obj;
      $mysqli = $obj->connect();
      $upload_path = '/uploads/';
      $profileImage = basename($_FILES['image']['name']);
      $fileType = pathinfo($profileImage,PATHINFO_EXTENSION);
      $newFileName =time().".".$fileType ;
      $targetPath = ASSET.$upload_path . $newFileName ;
      $temp_image = $_FILES["image"]["tmp_name"];
      if($temp_image != "" )
      {
          move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
          $sql = "UPDATE employee_details SET type_id='$typeId', emp_name = '$empName',  emp_code = '$empCode', office_email = '$officeMail' , department ='$department', designation = '$designation', joining_date = '$joiningDate', gender = '$gender',
                  dob = '$dob', country = '$country', state = '$state', city = '$city', pincode = '$pincode', current_address = '$currentAaddress', permanent_address = '$permanentAddress',
                  qualification = '$qualification', personal_email = '$personalMail', contact_no = '$contact', guardian_contact_no = '$parentContact', pancard_no = '$pancard',
                  aadhar_card = '$aadhar', driving_license = '$drivingLicense', profile_image = '$newFileName', status = '$status' WHERE emp_id= '$empId' " ;
         $mysqli ->query($sql);
         return json_encode(array('message' => 'Employee data Updated.', 'status' => true));
     }else{
          return json_encode(array('message' => 'Update failed.', 'status' => true));
     }
     $mysqli->close();
}
/**
 * POST:DELETE Employee Data
 * @param $data Employee id
 * 
 * @author divya@imprintnext.com
 * @date 15 Nov 2021
 * @return true/false
 */
function deleteEmployee($data){
     $empId = $_GET['eid'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "DELETE FROM employee_details WHERE emp_id = '$empId'";
     if($mysqli->query($sql)){
          deleteLoginData($data);
          // $status = unlink("$profileImage");
          return json_encode(array('message' => 'Employee data Deleted.','status' => true));

     }else{
          return json_encode(array('message' => 'Deletion failed !','status' => false));
     }
     
     $mysqli->close();
}
/**
 * GET:Delete Login credentials from database
 * @param $data Employee id
 * 
 * @author divya@imprintnext.com
 * @date 18 Nov 2021
 * @return true/false
 */
function deleteLoginData($data){
     $empId=$_GET['eid'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "DELETE FROM login_page WHERE emp_id='$empId'";
     $mysqli->query($sql);
     $mysqli->close();
}
/**
 * GET:Display Employee Data with their order(Ascending/Descending) with pagination
 * @param $data Order(ASC/DESC),number of data perpage,page number
 * 
 * @author divya@imprintnext.com
 * @date 18 Nov 2021
 * @return true/false
 */
function displayEmpData($data){
     $order = $_GET['order'];
     $perPage = $_GET['perPage'];
     $pageno = $_GET['pageno'];
     global $obj;
     $mysqli = $obj->connect();
     $res = "SELECT * FROM employee_details";
     $mysqli->query($res);
     if(!isset($_GET['page'])){
          $page = 1;
     }else{
          $page=$_GET['page'];
     }
     $firstPage = ($pageno * $perPage) - $perPage;
     $sql = "SELECT * FROM employee_details ORDER BY emp_name $order LIMIT ".$firstPage. ',' .$perPage;
     $result = $mysqli->query($sql);
     if($result->num_rows > 0){
          $output = $result->fetch_all(MYSQLI_ASSOC);
          return json_encode($output);
     }else{
          return json_encode(array('message' => 'No record Found.', 'status' => false));
     }
     $mysqli->close();
}
/**
 * PUT:Update Login information
 * @param $data Office email,password
 * 
 * @author divya@imprintnext.com
 * @date 18 Nov 2021
 * @return true/false
 */
function updateLogin($data){
     $userName = $_POST['offMail'];
     $userPassword = md5($_POST['password']);
     global $obj;
     $mysqli = $obj->connect();
     $sql = "UPDATE login_page SET password = '$userPassword' WHERE user_id = '$userName'";
     if($mysqli->query($sql)){
          return json_encode(array('message' => 'Login data updated', 'status' => true));
     }else{
          return json_encode(array('message' => 'updation failed!', 'status' => false));
     }
     $mysqli->close();
}
/**
 * POST:Validate Login Data(admin&user)
 * @param $request 
 * @param $response Login successful/failed 
 * 
 * @author divya@imprintnext.com
 * @date 16 Nov 2021
 * @return true/false
 */
function validateLogin($data){
     $userName = $_POST['offMail'];
     $userPassword = md5($_POST['password']);
     global $obj;
     $mysqli = $obj->connect();
     $sql = "SELECT * FROM login_page WHERE user_id = '$userName' AND password = '$userPassword'";
     $result = $mysqli->query($sql);
     $count = $result->num_rows;
     if($count == 0){
          return json_encode(array('message' => 'Login failed','status' => 0));
     }else{
          return json_encode(array('message' => 'Success','status' => 1));
     }
     $mysqli->close();
}
/**
 * POST:Check Wheather employee code and official mail is exist
 * @param $data Employee code,office mail
 * 
 * @author divya@imprintnext.com
 * @date 18 Nov 2021
 * @return true/false
 */
function validateInsertData($data){
     $empCode = $_POST['ecode'];
     $officeMail = $_POST['offMail'];
     global $obj;
     $mysqli = $obj->connect();
      $sql = "SELECT * FROM employee_details WHERE emp_code = '$empCode' OR office_email = '$officeMail'"; 
     $result = $mysqli->query($sql);
     if($result->num_rows > 0){
          return json_encode(array('message' => 'Email-id or code already exist.','status' => 1));
     }else{
          return json_encode(array('message' => 'Data Not available.','status' => 0));
     }
     $mysqli->close();
}
/**
 * POST:search employee data with specific input 
 * @param $data Value
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function searchData($data){
     $find = $data['val'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "SELECT * FROM employee_details WHERE emp_name LIKE '$find%' OR office_email LIKE '%$find%' ";
     $result = $mysqli->query($sql);
     if($result->num_rows > 0){
          $output = $result->fetch_all();
          return json_encode($output);
     }else{
          return json_encode(array('message' => 'No record Found.', 'status' => false));
     }
     $mysqli->close();
}
/**
 * POST:display specific employee data by employee id
 * @param $data Employee id
 * 
 * @author divya@imprintnext.com
 * @date 17 Nov 2021
 * @return true/false
 */
function displayById($data){
     $empId = $_GET['eid'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "SELECT * FROM `employee_details` INNER JOIN `user_type` on `user_type`.`type_id` = `employee_details`.`type_id`
             WHERE emp_id='$empId'";
     $result = $mysqli->query($sql);
      if($result->num_rows > 0){
          $output = $result->fetch_assoc();
          $type_id= $output['type_id'];
          $sqlModule = "SELECT * FROM `user_type` 
          JOIN `user_module_relation` on `user_type`.`type_id` = `user_module_relation`.`type_id` 
          JOIN `user_module` on `user_module`.`module_id` = `user_module_relation`.`module_id` 
          WHERE `user_type`.`type_id` = $type_id";
          $resultModule = $mysqli->query($sqlModule);
          $outputM = $resultModule->fetch_all(MYSQLI_ASSOC);
          $moduleData = array();
          if($resultModule->num_rows > 0){
          foreach($resultModule as $key => $value){
               $moduleData[$key]['id'] = $value['module_id'];
               $moduleData[$key]['name'] = $value['module_name'];
          }
          $output['modulelist'] = $moduleData ;
          return $jsonData = json_encode($output);
     }else{
         return 0; 
     }
}else{
     return  json_encode(array('message' => 'No record Found.', 'status' => false));
}
$mysqli->close();
}
/**
 * POST:Save employee type 
 * @param $data Employee's Role
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function userType($data){
     $userRole = trim($data['role']);
     global $obj;
     $mysqli = $obj->connect();
     $sql = "INSERT INTO user_type(user_role)VALUES('$userRole')";
     if($mysqli->query($sql)){
         return json_encode(array('message' => 'user type inserted','status' => 1));
     }else{
         return json_encode(array('message' => 'failed','status' => 0));
     }
     $mysqli->close();
}
/**
 * POST:Save Employee Modules
 * @param $data Module name 
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function moduleData($data){
  $moduleName = trim(addslashes($data['name']));
  global $obj;
  $mysqli = $obj->connect();
  $sql = "INSERT INTO user_module(module_name)VALUES('$moduleName')";
  if($mysqli->query($sql)){
     return json_encode(array('message' => 'module inserted','status' => 1));
 }else{
     return json_encode(array('message' => 'failed','status' => 0));
 }  
 $mysqli->close();
}
/**
 * POST:Save Employee Modules and Respective Employee type
 * @param $data Employee type id
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function userModule($data){
     // $moduleId = $data['moduleid'];
     $typeId = $data['typeid'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "INSERT INTO um_rel(type_id)VALUES('$typeId')";
     if($mysqli->query($sql)){
          return json_encode(array('status' => 1));
      }else{
          return json_encode(array('status' => 0));
      }  
      $mysqli->close();  
}
/**
 * POST:Save Employee Leave data
 * @param $data Employee Id,Leave apply date,from date,to date,total days,reason....
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function leaveApply($data){
     $empId = $data['eid'];
     $applyDate = $data['leaveapply'];
     $leaveFrom = $data['datefrom'];
     $leaveTo = $data['dateto'];
     $days = $data['days'];
     $leaveType = $data['type'];
     $reason = addslashes($data['reason']);
     $mailTo = $data['mailTo'];
     $contact = trim($data['contact']);
     $shift_time = $data['time'];
     $status = $data['status'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "INSERT INTO leave_record(emp_id,leave_apply_date,leave_from,leave_to,days,leave_type,reason,mail_to,contact_no,shift_time,status)
          VALUES('$empId','$applyDate','$leaveFrom','$leaveTo','$days','$leaveType','$reason','$mailTo','$contact','$shift_time','$status')";
      if($mysqli->query($sql)){
          return json_encode(array('message' => 'leave applied','status' => 1));
      }else{
          return json_encode(array('message' => 'failed','status' => 0));
      }
      $mysqli->close();
}
/**
 * POST:Save Employee Leave status(including only leave calculation information)
 * @param $data Employee Id,Allowed Leave number,Taken Leave (both for plan and casual)
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function leaveStatus($data)
{
     $empId = $data['eid'];
     $allowedPlanLeave = $data['allowPlan'];
     $allowedCasualLeave = $data['allowCasual'];
     $takenPlanLeave = $data['takenplan'];
     $takenCasualLeave = $data['takencasual'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "INSERT INTO leave_status(emp_id,allowed_plan_leave,allowed_casual_leave,taken_plan_leave,taken_casual_leave)
             VALUES('$empId',' $allowedPlanLeave','$allowedCasualLeave','$takenPlanLeave','$takenCasualLeave')";
     if($mysqli->query($sql)){
          return json_encode(array('message' => 'leave status stored', 'status' => 1));
     }else{
          return json_encode(array('message' => 'failed', 'status'=>'0'));
     }
     $mysqli->close();   
}
/**
 * POST:Save Employee document related information
 * @param $data Employee Id,Document name,Document path,Request date for that document....
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function documentInsert($data){
     $empId = $data['eid'];
     $documentName = trim(addslashes($data['docname']));
     $docType = $data['doctype'];
     $requestDate = $data['reqdate'];
     $docPostDate = $data['postdate'];
     $reqStatus =$data['reqstatus'];
     $status = $data['status'];
     $approvedDate = $data['approvedate'];
     global $obj;
     $mysqli = $obj->connect();
     $sql = "INSERT INTO document(emp_id,doc_name,doc_url,request_date,date_of_post,request,status,approved_date)
            VALUES('$empId','$documentName','$docType','$requestDate','$reqStatus','$status','$docPostDate','$approvedDate')";
     if($mysqli->query($sql)){
          return json_encode(array('message' => 'document inserted', 'status' => 1));
     }else{
          return json_encode(array('message' => 'false', 'status' => 0));
     }
     $mysqli->close();
}
/**
 * POST:Change Document status dynamically according to document request status
 * @param $data Emp id,document id
 * 
 * @author divya@imprintnext.com
 * @date 19 Nov 2021
 * @return true/false
 */
function requestUpdate($data){
     $empId=$data['eid'];
     $docId = $data['docid'];
     $reqStatus=$data['reqstatus'];
     global $obj;
     $mysqli = $obj->connect();
     if($reqStatus == 'Approved'){
         $sql = "UPDATE document SET request='$reqStatus', status='true' WHERE doc_id ='$docId' AND emp_id=$empId"; 
          if($mysqli->query($sql)){
               return json_encode(array('message'=>'Request Updated','status'=>'1'));   
          }else{
               return json_encode(array('message'=>'No request','status'=>'0'));
          }
         
     }else{
          $sql = "UPDATE document SET request='$reqStatus' WHERE doc_id ='$docId'";
          if($mysqli->query($sql)){
              $mailSql="SELECT * FROM document INNER JOIN employee_details ON document.doc_id= doc_id AND employee_details.emp_id = document.emp_id";
              $result=$mysqli->query($mailSql);
              if($result->num_rows > 0){
               $output = $result->fetch_assoc();
               $docName = $output['doc_name'];
               $empName = $output['emp_name'];
               $empCode = $output['emp_code'];
               $requestDate = $output['request_date'];
               $mail = $obj->mail();
               $mail_heading="Request For Document";       
               $mail->Body = "<h5>Document Name: </h5>".$docName."<br><h5>Employee Name: </h5>".$empName."<br><h5>Employee Code: </h5>".$empCode."<br><h5>Request Date: </h5>".$requestDate;
               $mail->Subject = $mail_heading; 
               $mail->addAddress("divya@imprintnext.com"); 
               if ($mail->send()) 
               echo "Email Sent Successful.";
               return json_encode(array('message'=>'Request Updated','status'=>'1'));
              }
        }
     $mysqli->close();
    }
}
/**
 * GET: Retrieve all document and employee information related to that document
 * @param $data Request status
 * 
 * @author divya@imprintnext.com
 * @date 22 Nov 2021
 * @return true/false
 */
function showStatus($data){
      $reqStatus = $_GET['reqstatus'];
     global $baseUrl;
     global $obj;
     $mysqli=$obj->connect();
     $sql="SELECT * FROM document 
           INNER JOIN employee_details on employee_details.emp_id = document.emp_id
           WHERE request='$reqStatus'"; 
     $result = $mysqli->query($sql);
     $output = array();
     if($result->num_rows > 0){
          foreach ($result as $key => $value){
            $output[$key]['docid'] = $value['doc_id'];
            $output[$key]['empid'] = $value['emp_id']; 
            $output[$key]['docname'] = $value['doc_name'];
            $output[$key]['docurl'] = BASE_URL.$value['doc_url'];
            $output[$key]['emp-name'] = $value['emp_name'];
            $output[$key]['emp-code'] = $value['emp_code'];
            $output[$key]['office mail'] = $value['office_email'];
            $output[$key]['department'] = $value['department'];
            $output[$key]['designation'] = $value['designation'];
            $output[$key]['joining_date'] = $value['joining_date'];
            $output[$key]['gender'] = $value['gender'];
            $output[$key]['dob'] = $value['dob'];
            $output[$key]['country'] = $value['country'];
            $output[$key]['state'] = $value['state'];
            $output[$key]['city'] = $value['city'];
            $output[$key]['pincode'] = $value['pincode'];
            $output[$key]['current address'] = $value['current_address'];
            $output[$key]['permanent address'] = $value['permanent_address'];
            $output[$key]['qualification'] = $value['qualification'];
            $output[$key]['personal email'] = $value['personal_email'];
            $output[$key]['contact-no'] = $value['contact_no'];
            $output[$key]['status'] = $value['status'];
            
     }
     return json_encode($output); 
     $mysqli->close();  
  }
}
?>