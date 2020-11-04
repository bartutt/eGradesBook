<?php 

class Displayer{

    private $database;

    function __construct($database) {

        $this->database = $database;

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
      '<option value = '. $role_status .'>'         
           . $role_status .                       
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
  
  
  
public function displayStudentDetails($id) {

      echo '<table class="table">';
      echo '<tbody>';
      $person = $this->database->getPersonDetails($id);
        echo '<tr> 
                <th scope="row">id</th>     
                <td>' . $person['id'] . '</td>
              </tr>
              <tr>
                <th scope="row">birth date</th> 
                <td>' . $person['birth_date'] . '</td>
              </tr>
              <th scope="row">gender</th> 
                <td>' . $person['gender'] . '</td>
              <tr>
                <th scope="row">tel</th> 
                <td>' . $person['tel'] . '</td>
              </tr >
              <tr>
                <th scope="row">e-mail</th>   
                <td>' . $person['e_mail'] . '</td>
              </tr >           
              <tr>
                <th scope="row">city</th> 
                <td>' . $person['city'] . '</td>
              </tr >
              <tr>
                <th scope="row">post code</th>     
                <td>' . $person['code'] . '</td>
              </tr >
              <tr>
                <th scope="row">street</th> 
                <td>' . $person['street'] . '</td>
              </tr >            
              <tr>
                <th scope="row">house</th>
                <td>' . $person['house_nr'] . '</td>
              </tr >';

      echo '</tbody>';
      echo '</table>';
        

}
 


public function displayStudentName($id) {
 
  $person = $this->database->getPersonDetails($id);
    echo $person['name'] . ' '. $person['surname'];

}
  

public function displayContentAsButton($source, $as, $id, $action_value){
    $i = 1;
    foreach ($this->database->$source() as $as){
        echo '
        <form action = "settings.php" method = "post">
            <div class="col-12">
              <button class="button" data-toggle="modal" data-target="#'. $id. $i .'" >
                ' . $as .'
              </button>

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
    }




  

  }// end of class
?>