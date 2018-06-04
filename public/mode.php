<?php  
    

clss Database {
  private static $instance;
  private function __construct()
  {

  }
  private function _clone()
  {

  }
  public static function getInstance(){
    if(!(self::$instance instanceof self)){
      self::instance = new self();
    }
    return $instance;
  }
  $a = Database::getInstance();
  $b = Database::getInstance();
}    
/** 
* Singleton of Database 
*/  
class Database  
{  
  // We need a static private variable to store a Database instance.  
  privatestatic $instance;  
    
  // Mark as private to prevent it from being instanced.  
  private function__construct()  
  {  
    // Do nothing.  
  }  
    
  private function__clone()   
  {  
    // Do nothing.  
  }  
    
  public static function getInstance()   
  {  
    if (!(self::$instance instanceof self)) {  
      self::$instance = new self();  
    }  
    
    return self::$instance;  
  }  
}  
    
$a =Database::getInstance();  
$b =Database::getInstance();  
    
// true  
var_dump($a === $b);