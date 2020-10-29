<?php 
require_once './functions/class.database.php';

class Displayer{

    private $database;

    function __construct() {

        $this->database = new DataBase;

    }
 

    
    public function displayYearsSelect() {

        if (!empty ($this->database->years)){
            foreach ($this->database->years as $year)
                echo 
                '<option value = ' . $year .'>'         
                     . $year .                       
                '</option>';
        }else 
            $this->error[] = '0 results';
    
    }

 public function displayLessonTimes() {

        if (!empty ($this->database->lesson_times)){
            foreach ($this->database->lesson_times as $lesson)
                echo '
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td> ' . $lesson .'</td>
                            <td>

                            <button type="button" class="button" data-toggle="modal" data-target="#exampleModal">
                              edit
                            </button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New time</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    
                                <div class="form-group">
                                <input  type = "text" class="form-control" name = "year" form = "add" placeholder = "xx.xx-xx.xx" required>
                                </div>


                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="button" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="button">Save changes</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            
                            </td>                         
                        </tr>
                    </table>
                </div>';
        }else 
            $this->error[] = '0 results';
    
    }
}
?>