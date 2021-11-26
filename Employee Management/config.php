<?php
class EmployeeData{     
    //  Creating connection
    public function connect(){
        $this->servername = "localhost";
        $this->dbuser = "root";
        $this->dbpassword = "";
        $this->dbname = "employee_page";         
        $conn = new mysqli($this->servername,$this->dbuser,$this->dbpassword,$this->dbname);      
        return $conn;
    }
    public function mail(){
        require './mail/php_mailer/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        $mail->Username = 'amit.imprint81@gmail.com';
        $mail->Password = 'xtkpalzuuzzqlhvh';

        $mail->setFrom('amit.imprint81@gmail.com', 'ADMIN'); // Mail From & Mailer Name
        $mail->CharSet="windows-1251";
        $mail->CharSet="utf-8";
        $mail->IsHTML(true);
        return $mail;
    }
}
?>