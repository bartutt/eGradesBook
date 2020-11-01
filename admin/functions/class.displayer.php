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

  public function displayLessonTimesEdit() {
    $i = 1;
      foreach ($this->database->getLessonTimes() as $lesson){
          echo '
          <form action = "settings.php" method = "post">
              <div class="col-12">
                <button class="button" data-toggle="modal" data-target="#lesson'. $i .'">
                  ' . $lesson .'
                </button>

                <div class="modal fade" id="lesson' . $i . '" tabindex="-1" role="dialog" aria-labelledby="lesson' .$i . '" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                          
                      <div class="modal-header">
                        <h5 class="modal-title" id="lesson' . $i . '">New time</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>

                      <div class="modal-body">          
                        <div class="form-group">
                          <input type = "text" class="form-control" name = "value" placeholder = "' . $lesson . '" required>
                            <input type = "hidden" name = "action" value = "set_lesson_time">
                            <input name = "old_value" type = "hidden" value = "' . $lesson . '">
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
      }// end foreach loop
    } // end of method

  
  public function displayMarksCat() {
      $i = 1;
        foreach ($this->database->getMarksCat() as $marks_cat){
            echo '
            <form action = "settings.php" method = "post">
                <div class="col-12">
                  <button class="button" data-toggle="modal" data-target="#mark'. $i .'">
                    ' . $marks_cat .'
                  </button>
  
                  <div class="modal fade" id="mark' . $i . '" tabindex="-1" role="dialog" aria-labelledby="mark' .$i . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                            
                        <div class="modal-header">
                          <h5 class="modal-title" id="mark' . $i . '">Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
  
                        <div class="modal-body">          
                          <div class="form-group">
                            <input type = "text" class="form-control" name = "value" placeholder = "' . $marks_cat . '" required>
                              <input type = "hidden" name = "action" value = "set_mark_cat">
                              <input name = "old_value" type = "hidden" value = "' . $marks_cat . '">
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
        }// end foreach loop
      }//end of method
  
  
  
  
  }// end of class
?>