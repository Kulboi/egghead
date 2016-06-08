<?php
require_once 'dbHelper.php';
$db = new dbHelper();

  $datetime = date('Y-m-d H:i:s'); 

  $date = date('Y-m-d'); 

  $base_server = "http://localhost/project-Folder" ; //absolute Path to project Root folder 

  // db connection
      $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
        try {
            $connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            $response["status"] = "error";
            $response["message"] = 'Connection failed: ' . $e->getMessage();
            $response["data"] = null;
            exit;
        }




// Function to creat Slug field form a given string 

function CreateUnderscoreSlug($string) {

    $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '_'
    );

    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);

    // -- Returns the slug field 
    return strtolower(strtr($string, $table));


}




// function to check the entity for Images so as to insert into the right image directory (Required by ImageHandler)

function CheckEntity($entity){
    if ($entity=="whatever") {
        return("whatever-img");
    }
    elseif ($entity=="staff") {
        return("staff-img");
    }
}

//function to handle images

function imageHandler($filename,$tmpfilename,$entity)
{     
    
       $filename_ext = pathinfo($filename, PATHINFO_EXTENSION);

       if($filename_ext=="jpg" or $filename_ext=="png" or $filename_ext =="jpeg"  or $filename_ext =="JPG"  or $filename_ext =="JPEG" or $filename_ext == "gif")
       {
           $newfilename = time().".".$filename_ext;
           move_uploaded_file($tmpfilename,CheckEntity($entity)."/".$newfilename) ;
           
               return $newfilename;
           }
           else
           {
               //echo "Operation not completed";
                 return false;
           }
           
       }





//  function to login Clients 
  function LoginClients($connection,$email,$password){

    $data =  array();
    $password =  encrypt( $password ) ;
    
  
  $sql = "SELECT * FROM clients WHERE cli_email = ? ";
  
  $query = $connection ->prepare($sql) ;

  $query->execute(array("$email"));

  $num =  $query->rowCount();
  
  if($num >0) {
  $result = $query->setFetchMode(PDO::FETCH_ASSOC);
    

// echo $_SESSION['email'];
    while ($row = $query->fetch() ) {
     
      $fname = $row['cli_fname'] ;
      $lname = $row['cli_lname'] ;
      $db_pass = $row['cli_pass'] ;
      $db_email = $row['cli_email'];
      $address = $row['cli_address'];
      $slug = $row['cli_slug'];
      $phone = $row['cli_phone'];
      $id = $row['cli_id'];

      $name = $fname ." ".$lname ;

  
      // $dpt = $row['name'] ;

    
    if($db_email==$email){
      if($db_pass==$password){
  
      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['email'] = $email;
      $_SESSION['phone'] = $phone;
      $_SESSION['id'] = $id;
      $_SESSION['slug'] = $slug;
      $_SESSION['address'] = $address;
      $_SESSION['name'] = $name ;
      
        
      // $_SESSION['department'] = $dpt;
  
      
          $expire = time()+60*60*60;

      setcookie('nigerian-companies', $_SESSION['name'], $expire);

      $data['msg'] = "Login Successful" ;
      $data['status'] = "true" ;
      $data['slug'] = "$slug" ;
      $data['erre'] = '' ;
        // echo "Login Successful";
      
      
      }else{  
      $data['msg'] = "Unsuccessful" ;
      $data['status'] = "false" ;
      $data['erre'] = 'Your password is incorrect!' ;
        // echo "Your password is incorrect!";
        
      }
    
    }else{  
      $data['msg'] = "Unsuccessful" ;
      $data['status'] = "false" ;
      $data['erre'] = 'Your Email is incorrect!' ;
      // echo "Your Email is incorrect!";
      
    }
  }
  }else{  
      $data['msg'] = "Unsuccessful" ;
      $data['status'] = "false" ;
      $data['erre'] = 'This Email is not registered!' ;
    
    // echo "This Email is not registered!";
      
  } 

  return $data ; 
}






