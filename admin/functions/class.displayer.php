<?php 

class Displayer{

    private $database;

    /**
     * Contains lessons hours
     */
    private $lesson_times = array();

    /**
     * Contains rendered day attendance
     */
    private $day_att = array();
    
    /**
     * Contains available profiles
     */
    private $profiles = array();
    
    /**
     * Contains classes for current school year
     */
    private $classes = array();

    /**
     * Contains available school years
     */
    private $years = array();

    /**
     * Contains available roles/statuses
     */
    private $role_status = array();

    /**
     * Contains colors mark weight
     */
    private $mark_color;

    private $att_color;

    private $event_color;

    private $person = array();

    private $marks = array();

    private $class = array();  
    
    /**
     * Contains rendered timetable content
     */
    private $lessons = array();
    private $teachers = array();

    /**
     * Week days
     */
    private $week_days = array(
      'Monday',
      'Tuesday',
      'Wednesday',
      'Thursday',
      'Friday'
    );

    private $months = array(
      '01' => 'January',
      '02' => 'February',
      '03' => 'March',
      '04' => 'April',
      '05' => 'May',
      '06' => 'June',
      '07' => 'July',
      '08' => 'August',
      '09' => 'September',
      '10' => 'October',
      '11' => 'November',
      '12' => 'December');

    function __construct($database) {

        $this->database = $database;

    }
    private function displayAttendanceSelect($name, $value){

      echo '
      <select 
        onChange="this.className=this.options[this.selectedIndex].className" 
        form = "set_attendance" 
        name = "attendance['.$name.'][]" 
        class="form-control form-control-sm edit-attendance shadow-none" >
        
        <option 
          class = "'.$this->att_color.' form-control form-control-sm edit-attendance" 
          value = "" selected hidden>'.$value.'
        </option>
      
        <option 
          class = "bg-success form-control form-control-sm edit-attendance" 
          value = "present">
        present
        </option>
      
        <option 
          class = "bg-danger form-control form-control-sm edit-attendance" 
          value = "absent" >
        absent
        </option>
      
        <option 
          class = "bg-primary form-control form-control-sm edit-attendance" 
          value = "execused">
        execused
        </option>
      
        <option 
          class = "bg-secondary form-control form-control-sm edit-attendance" 
          value = "late">
        late
        </option>
          
      </select> 
      ';
    }
    private function displayEditInformation(){

      echo ' 
      <div class="modal fade" id="addInformation" tabindex="-1" role="dialog" aria-labelledby="addInformationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addInformationLabel">Add information</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input form = "add_information" type = "text" class="form-control border-0 shadow-none m-2" name = "value[]" placeholder = "title" required>
              <input form = "add_information" type = "text" class="form-control border-0 shadow-none m-2" name = "value[]" placeholder = "content" required>
              <input form = "add_information" autocomplete="off"class="form-control border-0 shadow-none m-2" type="text" id="datepicker" name = "value[]" placeholder = "date" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Close</button>
              <button form = "add_information" type="submit" class="btn btn-success rounded-0">Save</button>
            </div>
          </div>
        </div>
      </div>';
    }
    private function displayMarksSelect($name = '', $value = ''){

      echo '
          <select 
            onChange="this.className=this.options[this.selectedIndex].className" 
            form = "set_marks" 
            name = "marks['.$name.'][]" 
            class="form-control form-control-sm edit-marks shadow-none p-0 font-07" >
        
            <option 
            class = "'.$this->mark_color.' form-control form-control-sm edit-marks" 
            value = "" selected hidden>'.$value.'
          </option>';

          for ($i = 1; $i <= 6; $i++) {
            $this->setMarkColor($i);

              echo '
                <option 
                class = "'.$this->mark_color.' form-control form-control-sm edit-marks shadow-none p-0 font-07"
                  value = "'.$i.'">'.$i.'
                </option>
                ';
        }
          
      echo '</select> ';
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
    private function setMarkColor($mark = ''){
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

    private function colorTimetable(){
  
      $color = array(
      'bg-green',
      'bg-red',
      'bg-cyan',
      'bg-orange',
      'bg-purple',
      'bg-sky-blue'
      );

      $bg_color = $color[rand ( 0 , count($color) -1)];
        return $bg_color;
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
    private function displayMarks($marks) {

      echo '<td class = "py-2">';
            foreach ($marks as $mark) {
                  $this->setMarkColor($mark['mark']);
                  
                  $sum[] = $mark['mark'] * $mark['weight'];
                  
                  $sum_weight[] = $mark['weight'];
                 
                  echo '
                    
                    <a 
                    data-toggle="tooltip" 
                    data-html="true" 
                    title="
                      Teacher: '.$mark['teacher'].'<br>
                      Description: '.$mark['description'].'<br>
                      Weight: '.$mark['weight'].'<br>
                      Date: '.$mark['date'].'<br>
                      Category: '.$mark['cat'].'<br>      
                      " class="badge p-0 '.$this->mark_color.'">'; 
                      
                      $this->displayMarksSelect($mark['id'], $mark['mark']);
                      
                    echo '</a>
                    <input 
                      name = "marks['.$mark['id'].'][]" 
                      type = "hidden" value = "'.$mark['id'].'" 
                      form = "set_marks" ">
                    ';             
                    } // end foreach
        
      echo '</td>';
      echo '<td class = "py-2">'; 
        
        if (!empty($sum))
          echo '<a class="badge text-white '.$this->mark_color.'">'.number_format(array_sum($sum)/array_sum($sum_weight), 2, '.', '').'</a>';

      echo '</td>';
      echo '<td class = "py-2">';    
        if (!empty($sum))
          echo '<a class="badge bg-dark text-white">'.round(array_sum($sum)/array_sum($sum_weight)).'</a>';

      echo '</td>';
    
    
      
    }
    private function displayDayAttendance($student_id, $dates, $day) {   

      echo '
      <tr class = "d-md-none" >
        <th colspan="100%" class = "d-md-none border-0 ">'.$day.'</th>
      </tr>
      ';
      echo '
      <tr>
        <th class = "d-none d-md-table-cell">'.$day.'</th>
      ';    
      
      $lesson_times = $this->database->getLessonTimes();
      $i = 0;
      foreach($lesson_times as $lesson) {
        
        if (!empty ($dates [$lesson['time']] ['type']) ) {
        
          $this->setAttColor($dates [$lesson['time']] ['type']);
          echo '
          <input 
            name = "attendance['.$day.$i.'][]" 
            type = "hidden" value = "'.$_GET['person_id'].'" 
            form = "set_attendance" ">
          
          <input 
            name = "attendance['.$day.$i.'][]" 
            type = "hidden" value = "'.$dates [$lesson['time']]['subject_id'].'" 
            form = "set_attendance" ">
            
            <td class = "p-1">
              <a 
              class="badge p-0 w-100 '.$this->att_color.'" 
              data-toggle="tooltip" data-html="true" 
              title="
                Type: '.$dates [$lesson['time']] ['type'].'<br>
                Lesson time: '.$dates [$lesson['time']] ['time'].'<br>
                Subject: '.$dates [$lesson['time']] ['name'].'<br>">';                  
              
                $this->displayAttendanceSelect($day.$i, $dates [$lesson['time']] ['type']);
                echo '
              </a>    
            </td>
  
          <input 
            name = "attendance['.$day.$i.'][]" type = "hidden" 
            value = "'.$dates[$lesson['time']]['time_id'].'" 
            form = "set_attendance" ">
          
          <input 
            name = "attendance['.$day.$i.'][]" type = "hidden" 
            value = "'.$dates[$lesson['time']]['date'].'" 
            form = "set_attendance" ">';  
        $i++;
        
        }else {
          echo '<td class = "p-1"></td>';
        }

      } // end foreach
    
      echo '</tr>';
    
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
            <td><button class="btn btn-danger rounded-0 pt-0 pb-0 float-right" type="submit"><i class="fas fa-trash-alt"></i></button></td>
          </form>';

    }
    private function displayTimetableFrame() {

      $this->lesson_times = $this->database->getLessonTimes();

      echo '<div class = "row">';
        echo '<div class = "col text-center">';
          echo '<h2 class="display-4">Timetable</h2>';
          echo '<button class = "btn btn-outline-danger rounded-0 float-left" id = "editField" >Edit</button>';     
          echo '<button class = "btn btn-success rounded-0 float-right" type = "submit" form = "set_timetable"  id = "editField" >Save</button>';
        echo '</div>';
      echo '</div>';

      echo '<div class = "row">';  
      echo '<div class = "col p-2 d-none d-md-block">';
        echo ' ';
      echo '</div>';
        foreach ($this->week_days as $day) {
          echo '<div class = "col p-2 d-none d-md-block">';
            echo '<span class = "day">'.$day.'</span>';
          echo '</div>';
        }
      echo '</div>';


      echo '<div class = "row">';
       echo '<div class = "col">';
        foreach($this->lesson_times as $time){
            echo '<div class = "row">';
              echo '<div class = "col time m-1 d-none d-md-block">';           
                echo $time['time'];
            echo '</div>';
          echo '</div>'; 
        }
      echo '</div>';
    }
    private function renderTimetableContent($class_id){

        $timtbl = $this->database->getTimetable($class_id);
    
            foreach($this->week_days as $day) {
                foreach($timtbl as $lesson) { 
                    if ($lesson['week_day'] == $day) {
                        $this->lessons[$day][$lesson['time']] = $lesson['subject'];
                        $this->teachers[$day][$lesson['time']] = $lesson['teacher'];         
                    }            
                }        
                $this->lessons[$day][] = '';
              }  
    }
    private function renderAttendance($attendance, $days){

      foreach($attendance as $att) {      
        foreach ($days as $date){
          if ($att['date'] == $date['date']) {
            $this->day_att[$att['date']][$att['time']] = $att;   
          }
        }
      }
    }

    private function renderMarks($student_id, $subject = '') {

      $school_year = $this->database->getCurrentYear();

      if (empty ($subject)) {
        
        $this->subjects = $this->database->getSubjects();
    
      } else {
    
        $this->subjects[]['name'] = $subject;
    
        }
    
        $marks_1sem = $this->database->getMarks($student_id, '1', $school_year);
    
        $marks_2sem = $this->database->getMarks($student_id, '2', $school_year);
    
          foreach ($marks_1sem as $mark) {
            foreach ($this->subjects as $subject) {
              if ($mark['subject'] == $subject['name']) {       
                $this->sem_1[$subject['name']][] = $mark;
              }
            }
          }
    
          foreach ($marks_2sem as $mark) {
            foreach ($this->subjects as $subject) {
              if ($mark['subject'] == $subject['name']) {       
                $this->sem_2[$subject['name']][] = $mark;
              }
            }
          }


    }
  
    private function colorEvents($event_title, $event_desc){


        $event_title = strtolower($event_title);

        $event_desc = strtolower($event_desc);
  

        if ( (preg_match("/exam|test/", $event_title)) || (( preg_match("/exam|test/", $event_desc)) ) ) {

          $this->event_color = 'border-danger';

        }else {
          
          $this->event_color = 'border-light';

        }

            
  

    }


  
public function displayMonthsSelect($selected = '') {

  if (empty ($selected))
    echo '<option selected>All</option>';
  
  foreach ($this->months as $number => $month) {
    if ($number !== $selected)
      echo '<option value = "-'.$number.'-">'.$month.'</option>';   
    else 
      echo '<option value = "-'.$number.'-" selected>'.$month.'</option>';
  }


}

public function displayEvents($class = '') {



  $events = $this->database->getEvents($class);
  if (!empty ($events)) {
    echo '
        <div class="card-header bg-success text-center text-white p-2 mb-2">
          Class: '.$events[0]['name'].' 
        </div> 
        ';
  }

  if (!empty ($events)) {
    foreach($events as $event) {
      $this->colorEvents($event['title'], $event['description']);
      echo '
          <div class="card mb-3 '.$this->event_color.' shadow-sm rounded-0">
            <div class="card-body">
              <form action = "'.$_SERVER['REQUEST_URI'].'" method = "post">
                <input type = "hidden" name = "value[]" value = "' .$event['id'].'">
                <input type = "hidden" name = "action" value = "delete_event">
                <button class="btn btn-danger rounded-0 event-remove" type="submit">
                  <i class="fas fa-times"></i>
                </button>
              </form>                                                     
              <h5 class="header">'.$event['title'].' - '.$event['date'].'</h5>           
              <p class="card-text">'.$event['description'].'</p>                  
            </div>
          </div>
          ';
    }
  } else echo 'No events';

}


public function createTimetable($class_id) {

   $this->displayTimetableFrame();

   $this->renderTimetableContent($class_id);
    
   $i = 0;
    foreach ($this->lessons as $day => $lesson) {    
        echo '<div class = "col-md-2">'; 
          echo '<span class="d-xs-block d-sm-block d-md-none day">'.$day.'</span>'; 
          
          foreach ($this->lesson_times as $hour) {         
            $color = $this->colorTimetable();
              echo '<div class = "row" >';
              if (!empty ($lesson[$hour['time']])) {
                echo '<div class = "col lesson py-2 px-0 text-white m-1 '.$color.'">';
                    echo '<p class="d-xs-block d-sm-block d-md-none">'.$hour['time'].'</p>';
                    echo '<p class="timetable">'.$lesson[$hour['time']].'</p>';
                    echo '<p class="timetable">'.$this->teachers[$day][$hour['time']].'</p>';
                echo '</div>';
              }else { 
                    echo '<div class = "col lesson py-2 px-0 m-1">';
                      echo '<p class="d-xs-block d-sm-block d-md-none">'.$hour['time'].'</p>';
                      echo '<p class="timetable">-</p>';
                      echo '<p class="timetable">-</p>';
                    echo '</div>';
                    }
                echo '<div class = "col py-2 px-1 m-1 hide text-white '.$color.'">';   
                    echo '<input name = "timetable['.$i.'][]" type = "hidden" value = "'.$class_id.'" form = "set_timetable">';
                    echo '<p class="d-xs-block d-sm-block d-md-none">'.$hour['time'].'</p>';
                    echo '<p class="timetable">';
                    echo '<select name = "timetable['.$i.'][]" class = "edit-field" form = "set_timetable">';
                      echo '<option value = "Null"></option>';                      
                          $this->displaySubjectsSelect($lesson[$hour['time']]);
                      echo '</select>';
                    echo '</p>';
                    echo '<p class="timetable">';
                    echo '<select name = "timetable['.$i.'][]" class = "edit-field" form = "set_timetable">';
                      echo '<option value = "Null" ></option>';                
                          $this->displayPersonsSelect('teacher', $this->teachers[$day][$hour['time']]);
                    echo '</select>';
                     echo '<input name = "timetable['.$i.'][]" type = "hidden" value = "'.$hour['id'].'" form = "set_timetable">';
                    echo '<input name = "timetable['.$i.'][]" type = "hidden" value = "'.$day.'" form = "set_timetable">';          
                    echo '</p>';
                  echo'</div>';
              echo'</div>'; 
              $i ++;         
            }  

          echo '</div>';
          } 
        echo '</div>';
}


public function displayErrors(){
  
  $errors = $this->database->getErrors();
  
  if (!empty ($errors) ){ 

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<h4 class="alert-heading">Error</h4>';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';    
      foreach ($errors as $error)
          echo '<hr>' . $error;            
    echo '<br></div>';
  }
}


public function displaySuccess(){
  
  $success = $this->database->getSuccess();
  
  if (!empty ($success ) ){

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo '<h4 class="alert-heading">Success</h4>';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';    
      foreach ($success as $suc)
          echo '<hr>' . $suc;            
    echo '<br></div>';
  }     
     
}

public function displayInformationBoard(){

  $school_year = $this->database->getCurrentYear();

  $informations = $this->database->getInformationBoard($school_year);

    echo '
      <table id = "informationBoard" class="table table-sm mt-3">
        <thead class = "thead-light">
          <th>Title</th>
          <th>Content</th>
          <th>date</th>
          <th class = "d-none d-md-table-cell">added</th>
          <th></th>
        </thead>
        <tbody>';
        foreach ($informations as $information){
            echo '
            <tr>   
                <td>      
                      '.  $information['title'] .'
                </td> 
                <td>
                      '. $information['content'] .'
                </td>
                <td>
                      '. $information['time_when'] .'
                </td>
                <td class = "d-none d-md-table-cell"> 
                '. $information['time_added'] . '
                </td>
                <td>
                <form action = "'.$_SERVER['REQUEST_URI'].'" method = "post">
                  <input name = "value[]" type = "hidden" value = "'. $information['id'] . '">
                  <input name = "action" type = "hidden" value = "delete_information">
                  <button class="btn btn-danger rounded-0 py-0 font-07" type="submit">
                    <i class="fas fa-times"></i>
                  </button>
                </form>
                </td>           
            </tr>';
      }
  echo '</tbody>';
  echo '</table>';
  
  $this->displayEditInformation();
}

public function displayProfilesSelect($selected = '') {

  if (empty ($this->profiles))
    $this->profiles = $this->database->getProfiles();


  if (empty ($selected) )
    echo 
      '<option value = "" hidden selected></option>';

  foreach ($this->profiles as $profile)
      echo 
      '<option value = '. $profile['id'] .'>'         
           . $profile['name'] .                       
      '</option>';


}

public function displayPersonsSelect($role_status, $selected = '') {

  if (empty ($this->$role_status))
      $this->$role_status = $this->database->getPersons($role_status);

  if (empty ($selected) )
    echo 
      '<option value = "" hidden selected></option>';

  foreach ($this->$role_status as $person) {
    if (($person['name'] .' '.  $person['surname'] !== $selected) && ($person['id'] != $selected)) {
      echo 
              '<option value = "'. $person['id'] .'" >'         
              . $person['name'] .' '.  $person['surname'].                    
              '</option>';
    }else {
        echo 
              '<option value = "'. $person['id'] .'" selected>'         
              .   $person['name'] .' '.  $person['surname'].                    
              '</option>';
    }
  }
}

public function displaySubjectsSelect($selected = '', $value = '') {
  
  
  if (empty ($this->subjects))
    $this->subjects = $this->database->getSubjects();
    
    if (empty ($selected) )
      echo 
        '<option value = "" hidden selected></option>';
  
    foreach ($this->subjects as $subject) {
      
      if (empty ($value))
        $val = $subject['id'];
      else 
        $val = $subject['name'];

        if ($subject['name'] !== $selected) {
            echo 
              '<option value = "'. $val .'" >'         
                . $subject['name'].                    
              '</option>';
        }else {
            echo 
              '<option value = "'. $val .'" selected>'         
                . $subject['name'].                    
              '</option>';
    }
  }
}

public function displayClassesSelect($selected = '') {

  $school_year = $this->database->getCurrentYear();

  if (empty ($this->classes))
    $this->classes = $this->database->getClasses($school_year);

  if (empty ($selected) )
        echo 
          '<option value = "" hidden selected></option>';

  foreach ($this->classes as $class) {
    if ($class['id'] != $selected) {
      echo 
            '<option value = ' . $class['id'] .'>'         
              .$class['name'].                    
            '</option>';
      }else {
        echo 
            '<option value = '.$class['id'].' selected>'         
              .$class['name'].                    
            '</option>';
      }
    }

}

public function displayYearsSelect($selected = '') {

  if (empty ($this->years))
    $this->years = $this->database->getYears();


  if (empty ($selected) ){
    echo 
      '<option value = "" hidden selected></option>';
  }
            
        foreach ($this->years as $year){
            
            if ($year['years'] !== $selected) {
                echo 
                  '<option value = '. $year['years'] .'>'         
                     . $year['years'] .                       
                  '</option>';
            }else {        
              echo 
                '<option value = '. $year['years'] .' selected>'         
                   . $year['years'] .                       
                '</option>';
            }         
        }
    
}

public function displayRoleStatusSelect($selected = '') {

  if (empty ($this->role_status))
    $this->role_status = $this->database->getRoleStatus();

  if (empty ($selected) )
        echo 
          '<option value = "" hidden selected></option>';

  foreach ($this->role_status as $role_status)
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
      echo '<div class="table-responsive">';
      echo '<table class="table table-sm">';
      echo '<thead class = "thead-light"><th>name</th><th>surname</th><th class="d-none d-lg-table-cell">birth date</th><th>ID</th></thead>';
      echo '<tbody>';
      foreach ($this->database->getPersons($role_status) as $person){
        echo '<tr>
                <form action = "details_'.$role_status.'.php" method = "get">
                <td><button type = "submit" class="table-button">' . $person['name'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $person['surname'] . '</button></td>
                <td class="d-none d-lg-table-cell"><button type = "submit" class="table-button">' . $person['birth_date'] . '</button></td>
                <td><button type = "submit" class="table-button">' . $person['id'] . '</button></td>
                <input type = "hidden" name = "person_id" value = "'.$person['id'].'">
                <input type = "hidden" name = "tab" value = "">
                </form>';


        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
      echo '</div>';
  
}
  

public function displayNotes($student_id) {

  $school_year = $this->database->getCurrentYear();

  $notes = $this->database->getNotes($student_id, $school_year);

      echo '
      <table class="table table-sm mt-3">
        <thead class = "thead-light">
          <th class = "nr d-none d-md-table-cell">#</th>
          <th>teacher</th>
          <th class = "d-none d-sm-table-cell">content</th>
          <th>date</th>
        </thead>
        <tbody>';
        foreach ($notes as $note){
            echo '
            <tr> 
                <th class = "nr d-none d-md-table-cell">Note</th>   
                <td>
                  <button data-toggle="modal" data-target="#'. 'note' . $note['id'] .'" class="table-button">
                      '.  $note['teacher'].'
                  </button>
                </td> 
                <td class = "d-none d-sm-table-cell">
                  <button data-toggle="modal" data-target="#'. 'note' . $note['id'] .'" class="table-button">
                    <p class = "truncate">' 
                    . $note['description'] .
                    '</p>
                  </button>
                  </td>
                <td>
                  <button data-toggle="modal" data-target="#'. 'note' . $note['id'] .'" class="table-button">' 
                  . $note['date'] . 
                  '</button>
                </td>
            </tr>';

      $this->displayDetails('note' . $note['id'], $note);
      }

  echo '</tbody>';
  echo '</table>';

}

public function displayTeacherSubjects($teacher_id) {

  echo '<ul class = "pt-2">';
  foreach ($this->database->getTeacherSubjects($teacher_id) as $subject){
      echo '<li>'.$subject['subject'].'</li>';
      }
  echo '</ul>';
}

public function displayTeacherClasses($teacher_id) {

  echo '<ul class = "pt-2">';
  foreach ($this->database->getTeacherClasses($teacher_id) as $class){
      echo '<li class = "p-"><a href = "details_class.php?class_id='.$class['id'].'">'.$class['name'].' '. $class['years'].'</a></li>';
      }
  echo '</ul>';
}


public function displaySupervisorStudent($supervisor_id) {

  echo '<ul class = "pt-2">';
    foreach ($this->database->getSupervisorStudent($supervisor_id) as $student){

    echo '<form action = "details_student.php" method = "get">    
          <input type = "hidden" name = "person_id" value = "'.$student['student_id'].'">
          <input type = "hidden" name = "tab" value = "">';   
    echo '<li><button class = "btn btn-link" type = "submit">'.$student['student'].'</button></li>';
    echo '</form>';
      }

  echo '</ul>';
  
}

public function displayStudentMarks($student_id, $subject = '') {
  
  $this->renderMarks($student_id, $subject);

  echo '<div class = "row">
        <div class = "col-md-6 mt-3">
        <table id = "marks-table-1" class="table table-sm">   
        <thead class = "thead thead-light"><th>subject</th><th>first semester</th><th>gpa</th><th>#</th></thead>     
        <tbody>';   

          foreach ($this->subjects as $subject) {

            echo '<tr>';       
            
            if (!empty ($this->sem_1[$subject['name']])){
              echo '<td>'.$subject['name'].'</td>'; 
              $this->displayMarks($this->sem_1[$subject['name']]);

            }else {
              echo '<td>'.$subject['name'].'</td>'; 
              echo '<td class = "py-2 pl-1">-</td>';  
              echo '<td class = "py-2 pl-1">-</td>';
              echo '<td class = "py-2 pl-1">-</td>';           
            }
            echo '</tr>';
          }


  echo '</tbody>
        </table>
        </div>';

        // second semester
  echo '<div class = "col-md-6 mt-3">
        <table id = "marks-table-2" class="table table-sm">
        <thead class = "thead thead-light"><th class = "d-table-cell d-md-none">subject</th><th>second semester</th><th>gpa</th><th>#</th><th>final</th></thead>  
        <tbody>'; 
             
          foreach ($this->subjects as $subject) {

            echo '<tr>';       
            
            if (!empty ($this->sem_2[$subject['name']])){
              echo '<td class = "d-table-cell d-md-none">'.$subject['name'].'</td>'; 
              $this->displayMarks($this->sem_2[$subject['name']]);

            }else {
              echo '<td class = "d-table-cell d-md-none">'.$subject['name'].'</td>'; 
              echo '<td class = "py-2 pl-1">-</td>';    
              echo '<td class = "py-2 pl-1">-</td>';  
              echo '<td class = "py-2 pl-1">-</td>';        
            }

              echo '</tr>';
          }
  
  echo '</tbody>
        </table>
        </div>
        </div>';
  
        //show save button if marks exist
  if (!empty ($this->sem_1))
    echo '<button form = "set_marks" class="btn btn-success rounded-0 m-2 float-right" type="submit">save</button>';
}


public function displayAttendance($student_id, $date_from = '', $date_to = '') {

  $lessons = $this->database->getLessonTimes();

  echo '<table class="table table-sm mt-2" id = "attendanceTable">';
  echo '<thead class = "thead thead-light">';
  echo '<th class = "d-none d-md-table-cell">Date</th>';
    foreach ($lessons as $lesson)
      echo '<th class = "d-none d-md-table-cell">'.$lesson['time'].'</th>';
  echo '</thead>';
  echo '<tbody>';

  if ((!empty ($date_from) && (!empty($date_to)))) {
      
    $attendance = $this->database->getAttPeriod($student_id, '', $date_from, $date_to);

    $dates = $this->database->getAttendanceDays($student_id, '', $date_from, $date_to);
    
    $this->renderAttendance($attendance, $dates);

    foreach ($dates as $date)
      $this->displayDayAttendance($student_id, $this->day_att[$date['date']], $date['date']);
      
  }else {
    
      $school_year = $this->database->getCurrentYear();

      $attendance = $this->database->getAttPeriod($student_id, $school_year);
      
      $dates = $this->database->getAttendanceDays($student_id, $school_year);
      
      $this->renderAttendance($attendance, $dates);
      
      foreach ($dates as $date)
        $this->displayDayAttendance($student_id, $this->day_att[$date['date']], $date['date']);
    }

    
  
  echo '</tbody>';
  echo '</table>';

  if (empty ($attendance)) 
    echo 'Empty';
  else
      echo '<button form = "set_attendance" class="btn btn-success rounded-0 m-2 float-right" type="submit">save</button>';

}


public function displayClassDetails($class_id, $school_year = ''){
    
    $students = $this->database->getStudentsInClass($class_id);
    
    $this->displayClassHeader($class_id);

    if (!empty($students)) {
      echo '<table class="table table-sm">';
      echo '
      <thead class = "thead-light"><th>#</th><th>Student</th>
      <th><button class = "btn btn-outline-danger pt-0 pb-0 rounded-0 float-right" id = "showRemove" >Edit</button></th>
      </thead>';
      echo '<tbody>';
        $i = 1;
          foreach($students as $class) {
            echo '
                  <tr>
                    <form action = "details_student.php" method = "get">
                      <td class = "nr"><button type = "submit" class="table-button">' . $i . '</button></td>
                      <td><button type = "submit" class="table-button">' . $class['student'] . '</button></td>
                      <input type = "hidden" name = "person_id" value = "'.$class['student_id'].'">
                      <input type = "hidden" name = "tab" value = "">
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
    <thead class = "thead-light"><th class = "nr">#</th><th>Teacher</th><th>Profile</th>
    <th><button class = "btn btn-outline-danger pt-0 pb-0 rounded-0 float-right" id = "showRemove" >Edit</button></th>
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
      
      echo '<table id = "person-details" class="table table-sm">';
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