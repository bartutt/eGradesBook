<?php 

class Displayer{

    private $database;

    function __construct($database) {

        $this->database = $database;

    }
 
     
  public function displayErrors(){
     if (!empty ($this->database->getErrors() ) )
      foreach ($this->database->getErrors() as $error) {
            echo '
            <div class = "container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Error</h4><hr>' . $error .
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            </div>';
        }          
    
    }

  public function displaySuccess(){
      if (!empty ($this->database->getSuccess() ) )
       foreach ($this->database->getSuccess() as $success) {
             echo '
             <div class = "container">
             <div class="alert alert-success alert-dismissible fade show" role="alert">
             <h4 class="alert-heading">Success!</h4><hr>' . $success .
                 '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             </div>';
         }          
     
    }
    
  public function displayYearsSelect() {

            foreach ($this->database->getYears() as $year)
                echo 
                '<option value = ' . $year .'>'         
                     . $year .                       
                '</option>';
    
    
    }
  public function displayStudents() {

      echo '<table class="table table-striped">';
      echo '<thead class = "thead-light"><th>name</th><th>surname</th><th>birth date</th><th>ID</th></thead>';
      echo '<tbody>';
      foreach ($this->database->getStudents() as $student){
        echo '<tr>
                <td>' . $student['name'] . '</td>
                <td>' . $student['surname'] . '</td>
                <td>' . $student['birth_date'] . '</td>
                <td>' . $student['id'] . '</td>';


        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
        


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