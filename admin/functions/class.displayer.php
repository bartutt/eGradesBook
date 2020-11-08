<?php 

class Displayer{

    private $database;

    /**
     * Holds colors mark weight
     */
    private $mark_color = array();

    private $person = array();

    private $marks = array();


    function __construct($database) {

        $this->database = $database;

    }

    
    private function setColor($mark){
      if ($mark == 1) 
        $this->mark_color = 'bg-danger';
      
      if ($mark == 2) 
        $this->mark_color = 'bg-secondary';
      
        if ($mark == 3) 
        $this->mark_color = 'bg-warning';
      
        if ($mark == 4) 
        $this->mark_color = 'bg-info';

        if ($mark == 5) 
        $this->mark_color = 'bg-success';

        if ($mark == 6) 
        $this->mark_color = 'bg-primary';

      
      
      return $this->mark_color;

    }

    private function getContentByYear($date, $date2){

      $this->$date2 = explode('/', $date2);

      $this->$date = explode('-', $date);

        if( ($this->$date[0] == $this->$date2[0]) || ($this->$date[0] == $this->$date2[1]) )
          return true;
        else 
          return false;

    }



public function displayErrors(){
  
  if (!empty ($this->database->getErrors() ) ){
    echo '<div class = "container">';
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<h4 class="alert-heading">Error</h4>';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';    
      foreach ($this->database->getErrors() as $error)
          echo '<hr>' . $error;            
    echo '<br></div></div>';
  }
}


public function displaySuccess(){
  if (!empty ($this->database->getSuccess() ) ){

    echo '<div class = "container">';
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo '<h4 class="alert-heading">Success</h4>';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';    
      foreach ($this->database->getSuccess() as $success)
          echo '<hr>' . $success;            
    echo '<br></div></div>';
  }     
     
}

  
public function displayYearsSelect() {

            foreach ($this->database->getYears() as $year)
                echo 
                '<option value = ' . $year .'>'         
                     . $year .                       
                '</option>';
    
    
}


public function displayRoleStatusSelect() {

  foreach ($this->database->getRoleStatus() as $role_status)
      echo 
      '<option value = '. $role_status['id'] .'>'         
           . $role_status['role_status'] .                       
      '</option>';


}
  
  
public function displayPersons($role_status) {

      echo '<table class="table table-sm">';
      echo '<thead class = "thead-light"><th>name</th><th>surname</th><th>birth date</th><th>ID</th></thead>';
      echo '<tbody>';
      foreach ($this->database->getPersons($role_status) as $person){
        echo '<tr>
                <form action = "details_student.php" method = "post">
                <td><button type = "submit" class="table-button">' . $person['name'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $person['surname'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $person['birth_date'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $person['id'] . '</button></td>
                <input type = "hidden" name = "id" value = "'.$person['id'].'">
                </form>';


        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
  
}
  

public function displayNotes($student_id, $year) {

 
  echo '<table class="table table-sm">';
  echo '<thead><th>#</th><th>teacher</th><th>content</th><th>date</th></thead>';
  echo '<tbody>';
  foreach ($this->database->getNotes($student_id) as $note)
    if ($this->getContentByYear($note['date'], $year) === true ){
      echo '
            <form action = "" method = "post">
            <tr> 
                <th scope="row">Note</th>   
                <td><button type = "submit" class="table-button">'.  $note['teacher'].'</button></td> 
                <td><button type = "submit" class="table-button">' . $note['description'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $note['date'] . '</button></td>
            </tr>      
            </form>';
      echo '</tr>';
  }
  
  echo '</tbody>';
  echo '</table>';

}



public function displayStudentMarks($student_id, $school_year) {
  

  echo '<div class = "row">
        <div class = "col-6">
        <table class="table">   
        <thead><th>subject</th><th>first semester</th><th>#</th></thead>     
        <tbody>';   
    
            foreach ($this->database->getSubjects() as $subject){
              
              $this->marks = $this->database->getMarks($subject, $student_id, '1', $school_year);

              echo '<tr><th scope="row">'.$subject.'</th>';
              
              $this->displayMarks();

              echo '</tr>';
            }
        

  echo '</tbody>
        </table>
        </div>';
  echo '<div class = "col-6">
        <table class="table">
        <thead><th>second semester</th><th>#</th><th>final</th></thead>  
        <tbody>';
        
        foreach ($this->database->getSubjects() as $subject){
        
          echo '<tr>';

          $this->marks = $this->database->getMarks($subject, $student_id, '2', $school_year);
        
          $this->displayMarks();

          echo '</tr>';
        }
  
  echo '</tbody>
        </table>
        </div>
        </div>';
}





public function displayMarks() {

  
  echo '<td>';
    if (is_array($this->marks))
        foreach ($this->marks as $mark) {
              $this->setColor($mark['mark']);

             echo '<a data-toggle="tooltip" data-html="true" title="
                  Teacher: '.$mark['teacher'].'<br>
                  Description: '.$mark['description'].'<br>
                  Weight: '.$mark['weight'].'<br>
                  Date: '.$mark['date'].'<br>
                  Category: '.$mark['cat'].'<br>      
                  " class="badge '.$this->mark_color.'">' .$mark['mark']. '</a>';
     
                }else echo '-';
    echo '</td>';
    echo '<td></td>';

  
}



public function displayPersonDetails($id) {
      
      echo '<table class="table">';
        echo '<tr> 
                <th scope="row">id</th>     
                <td>' . $this->person['id'] . '</td>
              </tr>
              <tr>
                <th scope="row">birth date</th> 
                <td>' . $this->person['birth_date'] . '</td>
              </tr>
              <th scope="row">gender</th> 
                <td>' . $this->person['gender'] . '</td>
              <tr>
                <th scope="row">tel</th> 
                <td>' . $this->person['tel'] . '</td>
              </tr >
              <tr>
                <th scope="row">e-mail</th>   
                <td>' . $this->person['e_mail'] . '</td>
              </tr >           
              <tr>
                <th scope="row">city</th> 
                <td>' . $this->person['city'] . '</td>
              </tr >
              <tr>
                <th scope="row">post code</th>     
                <td>' . $this->person['code'] . '</td>
              </tr >
              <tr>
                <th scope="row">street</th> 
                <td>' . $this->person['street'] . '</td>
              </tr >            
              <tr>
                <th scope="row">house</th>
                <td>' . $this->person['house_nr'] . '</td>
              </tr >';
      echo '</table>';
        

}
 

public function displayPersonName($id) {
    
    $this->person = $this->database->getPersonDetails($id);

    return $this->person['name'] . ' '. $this->person['surname'];

}
  


public function displayContentAsButton($source, $as, $id, $action_value){
    $i = 1;
    echo '<table class="table table-sm">';
    echo '<tbody>';
    
    foreach ($this->database->$source() as $as){ 
      echo '
        <form action = "settings.php" method = "post">
            <div class="col-12">
            <tr>
              <td>
              <button class="table-button" data-toggle="modal" data-target="#'. $id. $i .'" >
                ' . $as .'
              </button>
              </td>
            </tr>
              <div class="modal fade" id="'. $id . $i . '" tabindex="-1" role="dialog" aria-labelledby="'. $id . $i . '" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                        
                    <div class="modal-header">
                      <h5 class="modal-title" id="'. $id . $i . '">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">          
                      <div class="form-group">
                        <input type = "text" class="form-control" name = "value" placeholder = "'. $as . '" required>
                          <input type = "hidden" name = "action" value = "' . $action_value . '">
                          <input name = "old_value" type = "hidden" value = "' . $as . '">
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="button" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="button">Save changes</button>
                    </div>
                      
                  </div>
                </div>
              </div>            
            </div>
        </form>';
      $i++;
      }
      echo '</tbody>';
      echo '</table>';
    }




  

  }// end of class
?>