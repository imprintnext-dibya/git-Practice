 <?php  
   header('Content-Type: application/json');
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: POST,PUT,DELETE');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Origin, Access-Control-Allow-Methods, Authorization');
   $data = json_decode(file_get_contents("php://input"), true);
   $action  = $_GET['action'];
   // adding the functions file
   include('allFunction.php');
   include('function.php');
   switch($action){
    case "insert":
      echo insertEmployeeDetails($data);
      break;
    case "display":
     echo displayEmpData($data);
      break;
    case "update":
     echo updateData($data);
      break;
    case "delete":
     echo deleteEmployee($data);
      break;
    case "loginupdate":
     echo updateLogin($data);
      break;
    case "login":
     echo validateLogin($data);
      break;
    case "search":
     echo searchData($data);
      break;
    case "typeinsert":
     echo userType($data);
      break;
    case "module":
     echo moduleData($data);
      break;
    case "relation":
     echo userModule($data);
      break;
    case "usertype":
     echo displayUserType($data);
      break;
    case "displayid":
     echo displayById($data);
      break;
    case "leave":
     echo leaveApply($data);
      break;
    case "status":
     echo leaveStatus($data);
      break;
    case "document":
     echo documentInsert($data);
      break;
    case "docrequest":
     echo requestUpdate($data);
      break;
    case "docstatus":
     echo showStatus($data);
      break;
    case "fileupload":
     echo setHolidayCalander($data);
      break;
    case "getholiday":
     echo getHolidayCalander();
      break;
    case "setdoc":
     echo setCommonDocument($data);
      break;
    case "getdoc":
     echo getCommonDocuments();
      break;
    case "deletedoc":
     echo deleteCommonDocuments($data);
      break;
    case "displayleave":
     echo  displayLeaveData($data);
      break;
    case "updateleave":
     echo updateLeaveData($data);
      break;
    case "sendemail":
     echo attacheDocument($data);
      break;
     default:
      echo "No function is executed";
}
?>