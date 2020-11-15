<?php 

class Displayer{

    private $database;

    /**
     * Holds colors mark weight
     */
    private $mark_color = array();

    private $att_color = array();

    private $person = array();

    private $marks = array();

    private $class = array();


    function __construct($database) {

        $this->database = $database;

    }

    private function setAttColor($att){
      if ($att == 'absent') 
        $this->att_color = 'bg-danger';
      if ($att == 'execused') 
        $this->att_color = 'bg-primary';
      if ($att == 'unexecused') 
        $this->att_color = 'bg-warning';
      if ($att == 'late') 
        $this->att_color = 'bg-secondary';  
      if ($att == 'present') 
        $this->att_color = 'bg-success';
      
      return $this->att_color;

    }
    private function setMarkColor($mark = '', $att = ''){
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
      
      if ($att == 'present') 
        $this->mark_color = 'bg-succes';
      
      return $this->mark_color;

    }
    private function displayDetails($id, $note_details){

      echo '<div class="modal fade" id="'. $id . '" tabindex="-1" role="dialog" aria-labelledby="'. $id . '" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="'. $id . '">'.$note_details['teacher'].' '.$note_details['date'].':</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          '.$note_details['description'].'
          </div>
          <div class="modal-footer">
            <button type="button" class="button" data-dismiss="modal">Close</button>
          </div>
        </div>
        </div>
      </div>';


    }
    private function displayMarks() {

      echo '<td>';
        if (is_array($this->marks))
            foreach ($this->marks as $mark) {
                  $this->setMarkColor($mark['mark']);
                  $sum[] = $mark['mark'] * $mark['weight'];
                  $sum_weight[] = $mark['weight'];
                 echo '<a data-toggle="tooltip" data-html="true" title="
                      Teacher: '.$mark['teacher'].'<br>
                      Description: '.$mark['description'].'<br>
                      Weight: '.$mark['weight'].'<br>
                      Date: '.$mark['date'].'<br>
                      Category: '.$mark['cat'].'<br>      
                      " class="badge '.$this->mark_color.'">' .$mark['mark']. '</a>';
              
                    }else echo '-';
        echo '</td>';
        echo '<td>'; 
        
          if (!empty($sum))
            echo '<a class="badge '.$this->mark_color.'">'.number_format(array_sum($sum)/array_sum($sum_weight), 2, '.', '').'</a>';
          
        echo '</td>';
        echo '<td>'; 
        
        if (!empty($sum))
          echo '<a class="badge bg-dark text-white">'.round(array_sum($sum)/array_sum($sum_weight)).'</a>';
        
      echo '</td>';
    
    
      
    }
    private function displayDayAttendance($student_id, $date) {
  
      echo '<tr><td>'.$date.'</td><td>';
      foreach ($this->attendance as $att){
        $this->setAttColor($att['type']);
          echo '
          <a class="badge '.$this->att_color.'" data-toggle="tooltip" data-html="true" title="
          Type: '.$att['type'].'<br>
          Lesson time: '.$att['time'].'<br>
          Subject: '.$att['name'].'<br>">&nbsp;&nbsp;</a>';
          }
      echo '</td></tr>';
    }
    private function displayClassHeader($id) {
    
      $this->class = $this->database->getClassDetails($id);
        echo '<div class = "header"><h2 class="display-4">Class: '.$this->class[0]['name'].'</h2></div>';
        echo '<ul>';
        echo '<li>Profile: '.$this->class[0]['profile'].'</li>';
        echo '<li>Teacher: '.$this->class[0]['teacher'].'</li>';
        echo '<li>School year: '.$this->class[0]['years'].'</li>';
        echo '</ul>';

    }
    private function displayRemoveButton($value, $name, $action_value, $name_removed = ''){
      echo '<form action = "'.$_SERVER['REQUEST_URI'].'" method = "post">
            <input type = "hidden" name = "'.$name.'" value = "'.$value.'">
            <input type = "hidden" name = "action" value = "'.$action_value.'">
            <input type = "hidden" name = "old_value" value = "'.$name_removed.'">
            <td><button class="btn btn-danger rounded-0 pt-0 pb-0 float-right" type="submit">remove</button></td>
          </form>';

    }
    
public function displayErrors(){
  
  if (!empty ($this->database->getErrors() ) ){

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<h4 class="alert-heading">Error</h4>';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';    
      foreach ($this->database->getErrors() as $error)
          echo '<hr>' . $error;            
    echo '<br></div>';
  }
}


public function displaySuccess(){
  if (!empty ($this->database->getSuccess() ) ){

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo '<h4 class="alert-heading">Success</h4>';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';    
      foreach ($this->database->getSuccess() as $success)
          echo '<hr>' . $success;            
    echo '<br></div>';
  }     
     
}


public function displayProfilesSelect() {

  foreach ($this->database->getProfiles() as $profile)
      echo 
      '<option value = '. $profile['id'] .'>'         
           . $profile['name'] .                       
      '</option>';


}

public function displayPersonsSelect($role_status) {

  foreach ($this->database->getPersons($role_status) as $person)
      echo 
      '<option value = ' . $person['id'] .'>'         
           . $person['name'] .' '.  $person['surname'].                    
      '</option>';
    

}

public function displayYearsSelect() {

            foreach ($this->database->getYears() as $year)
                echo 
                '<option value = '. $year['years'] .'>'         
                     . $year['years'] .                       
                '</option>';
    
    
}


public function displayRoleStatusSelect() {

  foreach ($this->database->getRoleStatus() as $role_status)
      echo 
      '<option value = '. $role_status['id'] .'>'         
           . $role_status['name'] .                       
      '</option>';


}
  
public function searchPersonButton($role_status) {

  echo '<table id = "search_person" class = "table table-sm">';
  echo '<tbody>';
  foreach ($this->database->getPersons($role_status) as $person){
    echo '<tr>
            <form action = "'.$_SERVER['REQUEST_URI'].'" method = "post">
            <td>' . $person['name'] . ' ' . $person['surname'] . ' ' . $person['id'] . '
            <input type = "hidden" name = "student_id" value = "'.$person['id'].'">
            <input type = "hidden" name = "action" value = "add_to_class">
            <button class="btn btn-success rounded-0 pt-0 pb-0 float-right" type="submit">add</button></td>
            </form>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';

}

public function displayPersons($role_status) {

      echo '<table class="table table-sm">';
      echo '<thead class = "thead-light"><th>name</th><th>surname</th><th>birth date</th><th>ID</th></thead>';
      echo '<tbody>';
      foreach ($this->database->getPersons($role_status) as $person){
        echo '<tr>
                <form action = "details_'.$role_status.'.php" method = "post">
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
  

public function displayNotes($student_id, $school_year) {

 
  echo '<table class="table table-sm mt-3">';
  echo '<thead class = "thead-light"><th>#</th><th>teacher</th><th>content</th><th>date</th></thead>';
  echo '<tbody>';
  foreach ($this->database->getNotes($student_id, $school_year) as $note){
      echo '
            <tr> 
                <th scope="row">Note</th>   
                <td><button data-toggle="modal" data-target="#'. 'note' . $note['id'] .'" class="table-button">'.  $note['teacher'].'</button></td> 
                <td><button data-toggle="modal" data-target="#'. 'note' . $note['id'] .'" class="table-button"><p class = "truncate">' . $note['description'] . '</p></button></td>
                <td><button data-toggle="modal" data-target="#'. 'note' . $note['id'] .'" class="table-button">' . $note['date'] . '</button></td>
            </tr>';

      $this->displayDetails('note' . $note['id'], $note);
      }

  echo '</tbody>';
  echo '</table>';

}


public function displayStudentMarks($student_id, $school_year) {
  

  echo '<div class = "row">
        <div class = "col-6">
        <table class="table">   
        <thead><th>subject</th><th>first semester</th><th>gpa</th><th>#</th></thead>     
        <tbody>';   
    
            foreach ($this->database->getSubjects() as $subject){

              $this->marks = $this->database->getMarks($subject['name'], $student_id, '1', $school_year);

              echo '<tr><th scope="row">'.$subject['name'].'</th>';
            

              $this->displayMarks();

              echo '</tr>';
            }
  echo '</tbody>
        </table>
        </div>';
  echo '<div class = "col-6">
        <table class="table">
        <thead><th>second semester</th><th>gpa</th><th>#</th><th>final</th></thead>  
        <tbody>';
        
        foreach ($this->database->getSubjects() as $subject){
        
          echo '<tr>';

          $this->marks = $this->database->getMarks($subject['name'], $student_id, '2', $school_year);
        

          $this->displayMarks();

          echo '</tr>';
        }
  
  echo '</tbody>
        </table>
        </div>
        </div>';
}


public function displayAttendance($student_id, $school_year){

  echo '<table class="table" id = "attendanceTable">';
  echo '<thead><th>date</th><th>attendance</th></thead>';
  echo '<tbody>';
    foreach($this->database->getAttDays($student_id, $school_year) as $date){
      $this->attendance = $this->database->getAttendance($student_id, $date['date']);
      $this->displayDayAttendance($student_id, $date['date']);
    }
  echo '</tbody>';
  echo '</table>';

}


public function displayClassDetails($class_id, $school_year = ''){
    
    $students = $this->database->getStudentsInClass($class_id);
    
    $this->displayClassHeader($class_id);

    if (!empty($students)) {
      echo '<table class="table table-sm">';
      echo '
      <thead class = "thead-light"><th>#</th><th>Student</th>
      <th><button class = "btn btn-outline-secondary pt-0 pb-0 rounded-0 float-right" id = "showRemove" >Edit</button></th>
      </thead>';
      echo '<tbody>';
        $i = 1;
          foreach($students as $class) {
            echo '
                  <tr>
                    <form action = "details_student.php" method = "post">
                      <td class = "nr"><button type = "submit" class="table-button">' . $i . '</button></td>
                      <td><button type = "submit" class="table-button">' . $class['student'] . '</button></td>
                      <input type = "hidden" name = "id" value = "'.$class['student_id'].'">
                    </form>';
                  $this->displayRemoveButton($class['student_id'], 'student_id', 'remove_from_class');
            echo '</tr>';
              $i++;
              }
      echo '</tbody>';
      echo '</table>';
      } else echo 'No students';
}


public function displayClasses($school_year){

  echo '<table class="table table-sm">';
  echo '
    <thead class = "thead-light"><th>#</th><th>Teacher</th><th>Profile</th>
    <th><button class = "btn btn-outline-secondary pt-0 pb-0 rounded-0 float-right" id = "showRemove" >Edit</button></th>
    </thead>';
  echo '<tbody>';
    foreach($this->database->getClasses($school_year) as $class){
      echo '
            <tr>
              <form action = "details_class.php?class_id='.$class['id'].'" method = "post">
                <td class = "nr"><button type = "submit" class="table-button">' . $class['name'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $class['teacher'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $class['profile'] . '</button></td>
              </form>';
            $this->displayRemoveButton($class['id'], 'class', 'delete_class', $class['name']);
      echo '</tr>';
    }
  echo '</tbody>';
  echo '</table>';

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


public function displayContentAsButton($source, $as, $index, $id, $action_value){
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
                ' . $as[$index] .'
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
                        <input type = "text" class="form-control" name = "value" placeholder = "'. $as[$index] . '" required>
                          <input type = "hidden" name = "action" value = "' . $action_value . '">
                          <input name = "old_value" type = "hidden" value = "' . $as[$index] . '">
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