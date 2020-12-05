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
     * Contains student list in class
     */
    private $students = array();

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

    private $marks_cat = array();
    
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
    private function displayAttendanceSelect($name = '', $value = ''){

      if (empty ($value)) 
        $required = 'required';
      else 
        $required = '';


      echo '
      <select 
        onChange="this.className=this.options[this.selectedIndex].className" 
        form = "set_attendance" 
        name = "attendance['.$name.'][]" 
        class="form-control form-control-sm edit-attendance shadow-none" '.$required.'>

        <option 
              class = "'.$this->att_color.' form-control form-control-sm edit-attendance" 
              value = "" selected hidden>'.$value.'
        </option>  
        
        
        <option 
          class = "bg-success form-control form-control-sm edit-attendance shadow-none" 
          value = "present">
        present
        </option>
      
        <option 
          class = "bg-danger form-control form-control-sm edit-attendance shadow-none" 
          value = "absent" >
        absent
        </option>
      
        <option 
          class = "bg-primary form-control form-control-sm edit-attendance shadow-none" 
          value = "execused">
        execused
        </option>
      
        <option 
          class = "bg-secondary form-control form-control-sm edit-attendance shadow-none" 
          value = "late">
        late
        </option>
          
      </select> 
      ';
    }
    private function displayAddEventModal(){

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

    private function inputForm($form, $type, $class, $name, $value, $required = '') {

      echo '<input 
        form = "'.$form.'" 
        type = "'.$type.'" 
        class = "'.$class.'" 
        name = "'.$name.'" 
        value = "'.$value.'"
        '.$required.'
        >';

    }

    private function inputSelect($function, $form, $class, $name, $selected = '', $required = '') {

      echo '<select form = "'.$form.'" class = "'.$class.'" name = "'.$name.'">';

        $this->$function($selected);

      echo '</select>';
    }
    private function button($form, $type, $class, $value, $modal = '') {

      echo '<button 
        form = "'.$form.'" 
        type = "'.$type.'"
        class = "'.$class.'"
        '.$modal.'
        >
        '.$value.'
        </button>';
    }

    private function displayEditPersonModal($id, $hidden_value, $input, $row, $selected_value = '', $func_select = '') {

      echo ' 
        <form id = "person'.$id.'" action = "'.$_SERVER['REQUEST_URI'].'" method = "post">
          <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="'.$id.'Label">Edit</h5>';
                  $this->button('', "button", "close", '<span aria-hidden="true">&times;</span>' , 'data-dismiss="modal" aria-label="Close"');
          echo' </div>
                <div class="modal-body">';
                  $this->inputForm('person'.$id, "hidden", "", "action", "set_person");   
                if (empty ($selected_value)) {            
                  $this->inputForm('person'.$id, "text", "form-control border-0 shadow-none m-2", "person[]", $input, 'required'); 
                }else {
                  $this->inputSelect($func_select,'person'.$id, "form-control border-0 shadow-none", "person[]", $selected_value, 'required');
                }
                  
                  $this->inputForm('person'.$id, "hidden", "", "person[]", $hidden_value); 
                  $this->inputForm('person'.$id, "hidden", "", "person[]", $row);     
          echo' </div>
                <div class="modal-footer">';
                  $this->button('person'.$id, "button", "btn btn-secondary rounded-0", "Close" , 'data-dismiss="modal"');
                  $this->button('person'.$id, "submit", "btn btn-success rounded-0", "Save");              
          echo '</div>
              </div>
            </div>
          </div>
        </form>';
      
    }
    private function displayMarksSelect($form = '', $name = '', $value = '', $class = '') {

      if (empty ($class)) {
        
        $class = '';
        $required = 'required';

      }else {

          $class = 'form-control-sm edit-marks shadow-none p-0 font-07';
          $required = '';
      }

      echo '
          <select 
            onChange="this.className=this.options[this.selectedIndex].className" 
            form = "'.$form.'" 
            name = "marks['.$name.'][]" 
            class="form-control '.$class.'" '.$required.'>
        
            <option 
              class = "'.$this->mark_color.' form-control '.$class.'"" 
              value = "" selected hidden>'.$value.'
            </option>';

          for ($i = 1; $i <= 6; $i++) {
            $this->setMarkColor($i);

              echo '
                <option 
                  class = "'.$this->mark_color.' form-control '.$class.'"
                  value = "'.$i.'">'.$i.'
                </option>
                ';
        }
          
      echo '</select> ';
    }

    private function displayWeightSelect($selected = ''){
 
      
      if (empty ($selected) )
          echo 
            '<option value = "" hidden selected></option>';
  
      for ($i = 1; $i <= 5; $i++) {
        echo '<option value = "'.$i.'">'.$i.' </option>';  
      }
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
      if (!empty ($marks)) {
       echo '<td class = "py-2">';
            foreach ($marks as $mark) {

              $this->setMarkColor($mark['mark']);            
              $sum[] = $mark['mark'] * $mark['weight'];            
              $sum_weight[] = $mark['weight'];                          
            echo '<a 
                  data-toggle="tooltip" 
                  data-html="true" 
                  title="
                    Teacher: '.$mark['teacher'].'<br>
                    Description: '.$mark['description'].'<br>
                    Weight: '.$mark['weight'].'<br>
                    Date: '.$mark['date'].'<br>
                    Category: '.$mark['cat'].'<br>      
                    " class="badge p-0 '.$this->mark_color.'">'; 
                      
                    $this->displayMarksSelect('set_marks', $mark['id'], $mark['mark'], 'color');
                      
                '</a>';
          echo '<input 
                  name = "marks['.$mark['id'].'][]" 
                  type = "hidden" value = "'.$mark['id'].'" 
                  form = "set_marks" ">';            
            } // end foreach
      } //end if
      
     
      

      echo '
            </td>
            <td class = "py-2">';   
      if (!empty($sum))
          echo '<a class="badge text-white '.$this->mark_color.'">'.number_format(array_sum($sum)/array_sum($sum_weight), 2, '.', '').'</a>';
      echo
          '</td>
          <td class = "py-2">';    
      
      if (!empty($sum))
        echo '<a class="badge bg-dark text-white">'.round(array_sum($sum)/array_sum($sum_weight)).'</a>';
      
      echo
          '</td>';
        
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

    private function displayHeader($val_1 = '', $val_2 = '', $val_3 = '') {
   
      echo '<div class = "header"><h2 class="display-4">'.$val_1.'</h2></div>';
      echo '<ul>';
     
      if (!empty ($val_2)) 
        echo '<li>'.$val_2.'</li>';
      if (!empty ($val_3)) 
        echo '<li>'.$val_3.'</li>';
      
      echo '</ul>';

    }

    private function displayRemoveButton($value, $name, $action_value, $name_removed = ''){
      echo '<form action = "'.$_SERVER['REQUEST_URI'].'" method = "post">
            <input type = "hidden" name = "'.$name.'" value = "'.$value.'">
            <input type = "hidden" name = "action" value = "'.$action_value.'">
            <input type = "hidden" name = "class_removed" value = "'.$name_removed.'">
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
        
        $subjects = $this->database->getSubjects();
    
      }else {
    
        $subjects[]['name'] = $subject;
    
        }

        $marks_1sem = $this->database->getMarks($student_id, '1', $school_year);
    
        $marks_2sem = $this->database->getMarks($student_id, '2', $school_year);
    
          foreach ($marks_1sem as $mark) {
            foreach ($subjects as $subject) {
              if ($mark['subject'] == $subject['name']) {       
                $this->sem_1[$subject['name']][] = $mark;
              }
            }
          }
    
        if (!empty ($marks_2sem)) {
          foreach ($marks_2sem as $mark) {
            foreach ($subjects as $subject) {
              if ($mark['subject'] == $subject['name']) {       
                $this->sem_2[$subject['name']][] = $mark;
              }
            }
          }
        }

          $this->subjects = $subjects;
    }
  
    private function renderClassMarks($class, $subject) {

      $school_year = $this->database->getCurrentYear();

      $this->curr_sem = $this->database->getCurrentSem($school_year);

      $students = $this->students;

      $marks_sem = $this->database->getClassMarks($class, $subject, $this->curr_sem, $school_year);


      foreach ($marks_sem as $mark) {
        foreach ($students as $student) {
          if ($mark['student'] == $student['student']) {       
            $this->sem[$student['student']][] = $mark;
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
    private function displayMarksCatSelect($selected = ''){

      if (empty ($this->marks_cat))
        $this->marks_cat = $this->database->getMarksCat();
  
      if (empty ($selected) )
          echo 
            '<option value = "" hidden selected></option>';
  
      foreach ($this->marks_cat as $cat)
        echo 
        '<option value = "'. $cat['id'] .'" >'         
             . $cat['name'] .                       
        '</option>';
    }
    private function displayGenderSelect($selected = ''){

      $gender = array(
          'male',
          'female',
          'other'
      );

      if (empty ($this->marks_cat))
        $this->marks_cat = $this->database->getMarksCat();
  
      if (empty ($selected) )
          echo 
            '<option value = "" hidden selected></option>';
  
      foreach ($gender as $g) {
        
        if ($g !== $selected) {
          echo '<option value = "'. $g .'" >'. $g .'</option>';
        }else {
          
          echo '<option value = "'. $g .'" selected>'. $g .'</option>';
        }
      }   
    }
    private function displayStudentsClassSelect($class, $selected = '') {

      if (empty ($this->students))
        $this->students = $this->database->getStudentsInClass($class);

      
        if (empty ($selected) )
          echo 
            '<option value = "" hidden selected></option>';
  
        foreach ($this->students as $student) {
            echo 
              '<option value = "'. $student['student_id'] .'">'       
              .   $student['student'] .                   
              '</option>';
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
public function addMark($class, $subject, $teacher = '') {
  $today = date("Y-m-d");   

  echo 
  '<button aria-controls="mark" class="list-group-item list-group-item-action mt-1 mx-0 header" data-toggle="collapse" data-target="#mark" aria-expanded="false">
        Add mark
  </button>

    <div id="mark" class="row collapse">
      <div class = "col m-1 m-md-3 modul rounded shadow-sm p-3">
        <div class="form-row">
          <div class="col-md-2">
            <label for="student">Student</label>
            <select id = "student" name = "marks[0][]" form = "add_marks" class="form-control" required>';
              $this->displayStudentsClassSelect($class);
  echo 
            '</select>
          </div>
          <div class="col-md-2">
            <label for="teacher">Teacher</label>
            <select id = "teacher" name = "marks[0][]" form = "add_marks" class="form-control" required>';
              $this->displayPersonsSelect('teacher');
  echo 
            '</select>
          </div> 

          <input name = "marks[0][]" type = "hidden" form = "add_marks" value = "'. $subject .'">

          <div class="col-md-1">
            <label for="mark">Mark</label>';
              $this->displayMarksSelect('add_marks', '0');
  echo 

          '</div>
          
          <div class="col-md-1">
            <label for="cat">Category</label>
            <select id = "cat" name = "marks[0][]" form = "add_marks" class="form-control" required>';
              $this->displayMarksCatSelect();
  echo 
          '</select>
          </div>

          <div class="col-md-1">
            <label for="weight">Weight</label>
            <select id = "weight" name = "marks[0][]" form = "add_marks" class="form-control" required>';
              $this->displayWeightSelect();
  echo 
            '</select>
          </div>

          <div class="col-md-3">
            <label for="description">Description</label>
            <input name = "marks[0][]" class="form-control" form = "add_marks" type = "text" required>
          </div>
        
          <input name = "marks[0][]"  form = "add_marks" type = "hidden" value = "'. $today .'">

          <div class="col-md-1 align-self-end">
            <button form = "add_marks" class="btn btn-success rounded-0 mt-2 float-right float-md-left" type="submit">Add</button>
          </div>
        </div>
      </div>
    </div>
    ';
}

public function addNote($class, $subject, $teacher = '') {
  $today = date("Y-m-d");   

  echo 

    '<button aria-controls="note" class="list-group-item list-group-item-action mt-1 header" data-toggle="collapse" data-target="#note" aria-expanded="false">
        Add note
    </button>

    <div id="note" class="row collapse">
      <div class = "col m-1 m-md-3 modul rounded shadow-sm p-3">
        <div class="form-row">
          <div class="col-md-2">
            <label for="student">Student</label>
            <select id = "student" name = "note[]" form = "add_note" class="form-control" required>';
              $this->displayStudentsClassSelect($class);
  echo 
            '</select>
          </div>
          <div class="col-md-2">
            <label for="teacher">Teacher</label>
            <select id = "teacher" name = "note[]" form = "add_note" class="form-control" required>';
              $this->displayPersonsSelect('teacher');
  echo 
            '</select>
          </div> 

          <div class="col-md-3">
            <label for="description">Description</label>
            <input name = "note[]" class="form-control" form = "add_note" type = "text" required>
          </div>
        
          <input name = "note[]"  form = "add_note" type = "hidden" value = "'. $today .'">

          <div class="col-md-1 align-self-end">
            <button form = "add_note" class="btn btn-success rounded-0 mt-2 float-right float-md-left" type="submit">Add</button>
          </div>
        </div>
      </div>
    </div>
    ';



}

public function displayClassMarks($class, $subject) {

  $class_name = $this->database->getClassDetails($class);

  $subject_name = $this->database->getSubjectName($subject);

  $this->renderClassMarks($class, $subject);

  $sem = $this->curr_sem.' semester';

  $this->displayHeader($subject_name[0]['name'], $class_name[0]['name'], $sem);

  if (!empty ($this->students) ) {
    echo '
      <table id = "classMarks" class="table table-sm">
        <thead class = "thead-light">
          <th>#</th><th>Student</th><th>Marks</th><th>GPA</th><th>sem</th>
        </thead>
      <tbody>';
      
    $i = 1;    
        foreach($this->students as $student) {
          echo '    
            <tr>
              <td class = "nr">' . $i . '</td>
              <td class = "w-25">' . $student['student'] . '</td>';
              if (!empty ($this->sem[$student['student']]))
                  $this->displayMarks($this->sem[$student['student']]); 

              else
                  echo '<td class = "py-2">-</td>';        
            '</tr>';
          $i++;
          }   
    echo '
          <tr>
            <td class = "text-center" colspan = "100%">
              <button form = "finish_lesson" class="btn btn-success rounded-0 mt-2" type="submit">Finish lesson</button>
            </td>
          </tr>
    </tbody>
    </table>';
    echo '<button form = "set_marks" class="btn btn-success rounded-0 m-2 float-right" type="submit">save</button>';
    }else {

      echo 'This class is empty or you choosed wrong lesson. Check timetable';
      echo  '<a href = "lesson.php" class="btn btn-outline-secondary d-block rounded-0 mt-2">Back</a>';

    } 
}


public function checkAttendance($class, $subject, $lesson_time) {

  $students = $this->database->getStudentsInClass($class);
  $today = date("Y-m-d");   
  
  $class_name = $this->database->getClassDetails($class);

  $subject_name = $this->database->getSubjectName($subject);
  
  $this->displayHeader($today, $subject_name[0]['name'], $class_name[0]['name']);

  if ( !empty($students) && !empty ($lesson_time) ) {
    echo '
    <table id = "classAttendance" class="table table-sm">
    <thead class = "thead-light">
      <th>#</th><th>Student</th><th class = "text-right pr-4" >Attendance</th>
    </thead>
    <tbody>';
      $i = 1;
        foreach($students as $student) {
          echo '
          <input name = "attendance['.$i.'][]" type = "hidden" value = "' . $student['student_id'] . '" 
          form = "set_attendance" ">
          <input name = "attendance['.$i.'][]" type = "hidden" value = "'. $subject. '" 
          form = "set_attendance" ">
          <input name = "lesson[]" type = "hidden" value = "'.$class.'" 
          form = "set_attendance" ">
          <input name = "lesson[]" type = "hidden" value = "'. $subject. '" 
          form = "set_attendance" ">

            <tr>
              <td class = "nr">' . $i . '</td>
                <td>' . $student['student'] . '</td>
                <td class = "p-1 text-right"">
                <a class="badge p-0 bg-warning">';                  
                $this->displayAttendanceSelect($i);                 
      echo'     </a>    
                </td>
          <input name = "attendance['.$i.'][]" type = "hidden" value = "'.$lesson_time.'" 
          form = "set_attendance">
          <input name = "attendance['.$i.'][]" type = "hidden" value = "'.$today.'" 
          form = "set_attendance">';
          echo '</tr>';
          $i++;
          }   
    echo '
            <tr>
                <td class = "text-center" colspan = "100%">
                <a href = "lesson.php" class="btn btn-outline-secondary rounded-0 mt-2">Back</a>
                <button form = "set_attendance" class="btn btn-success rounded-0 mt-2" type="submit">Next</button>
                </td>
            </tr>
    </tbody>
    </table>';
    }else {
      echo 'This class is empty or you choosed wrong lesson. Check timetable';
      echo  '<a href = "lesson.php" class="btn btn-outline-secondary d-block rounded-0 mt-2">Back</a>';

    } 
}

public function startLesson(){

  echo '
        <label for = "class">Choose class</label>
        <select id = "class" name = "lesson[]" form = "start_lesson" class="form-control" required>';
        $this->displayClassesSelect();
  echo '
        </select>
        <label for = "subject">Choose subject</label>  
        <select id = "subject" name = "lesson[]" form = "start_lesson" class="form-control" required>';
        $this->displaySubjectsSelect();
  echo '
        </select>
        <button form = "start_lesson" class = "btn btn-success rounded-0 mt-3 w-100">Start!</button>';



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
  
  $this->displayAddEventModal();
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


          
  foreach ($this->role_status as $role_status){
    if ($role_status['name'] !== $selected){
      echo 
        '<option value = '. $role_status['id'] .'>'         
        . $role_status['name'] .                       
        '</option>';

    }else{
        '<option value = '. $role_status['id'] .' selected>'         
        . $role_status['name'] .                       
        '</option>';

      }

  }
      
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
            
            if (!empty ($this->sem_1[$subject['name']])) {

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
            
            if (!empty ($this->sem_2[$subject['name']])) {
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


public function displayClasses() {

  $school_year = $this->database->getCurrentYear();

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

public function displayPersonDetails($person_id) {

  $this->displayEditPersonModal('editName', $this->person['id'], $this->person['name'], 'name');
  $this->displayEditPersonModal('editSurname', $this->person['id'], $this->person['surname'], 'surname');
  $this->displayEditPersonModal('editRoleStatus', $this->person['id'], $this->person['role_status_id'], 'role_status_id', $this->person['role_status_name'], 'displayRoleStatusSelect');
  
        echo '<table class="table table-sm">';
        echo '<tr> 
                 
                <th class = "p-2 not-allowed">ID</th>               
                <td class = "p-2 not-allowed">' . $this->person['id'] . '</td>';
        echo' </tr>
              <tr>
            
                <th class = "p-2">Birth date</th> 
                <td><button data-toggle="modal" data-target="#editBirth" type = "button" class = "table-button" >' . $this->person['birth_date'] . '</button></td>';
                $this->displayEditPersonModal('editBirth', $this->person['id'], $this->person['birth_date'], 'birth_date');
        echo' </tr>
             
                <th class = "p-2">Gender</th> 
                <td><button data-toggle="modal" data-target="#editGender" type = "button" class = "table-button" >' . $this->person['gender'] . '</button></td>';
                $this->displayEditPersonModal('editGender', $this->person['id'], $this->person['gender'], 'gender', $this->person['gender'], 'displayGenderSelect');
        echo' </tr>
             
                <th class = "p-2">Telephone</th> 
                <td><button <button data-toggle="modal" data-target="#editTel" type = "button" class = "table-button" >' . $this->person['tel'] . '</button></td>';
                $this->displayEditPersonModal('editTel', $this->person['id'], $this->person['tel'], 'tel');
        echo' </tr>
              <tr>
             
                <th class = "p-2">E-mail</th>   
                <td><button data-toggle="modal" data-target="#editEmail" type = "button" class = "table-button" >' . $this->person['e_mail'] . '</button></td>';
                $this->displayEditPersonModal('editEmail', $this->person['id'], $this->person['e_mail'], 'e_mail');
        echo' </tr>          
              <tr>
              
                <th class = "p-2">City</th> 
                <td><button data-toggle="modal" data-target="#editCity" type = "button" class = "table-button" >' . $this->person['city'] . '</button></td>';
                $this->displayEditPersonModal('editCity', $this->person['id'], $this->person['city'], 'city');
        echo' </tr>
              <tr>
            
                <th class = "p-2">Post code</th>     
                <td><button data-toggle="modal" data-target="#editCode" type = "button" class = "table-button" >' . $this->person['code'] . '</button></td>';
                $this->displayEditPersonModal('editCode', $this->person['id'], $this->person['code'], 'code');
        echo' </tr>
              <tr>
           
                <th class = "p-2">Street</th> 
                <td><button data-toggle="modal" data-target="#editStreet" type = "button" class = "table-button" >' . $this->person['street'] . '</button></td>';
                $this->displayEditPersonModal('editStreet', $this->person['id'], $this->person['street'], 'street');
        echo' </tr>          
              <tr>
            
                <th class = "p-2">House nr</th>
                <td><button data-toggle="modal" data-target="#editHouse" type = "button" class = "table-button" >' . $this->person['house_nr'] . '</button></td>';
                $this->displayEditPersonModal('editHouse', $this->person['id'], $this->person['house_nr'], 'house_nr');
        echo' </tr>';
      echo '</table>';

}
 

public function displayPersonName($id) {
  
    
    $this->person = $this->database->getPersonDetails($id);

    echo '
        <button data-toggle="modal" data-target="#editName" type = "button" class = "btn btn-link mb-1 p-0" >' 
          . $this->person['name'] . ' </button>
        <button data-toggle="modal" data-target="#editSurname" type = "button" class = "btn btn-link mb-1 p-0 " >'
          . $this->person['surname'] . '
        </button>';

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