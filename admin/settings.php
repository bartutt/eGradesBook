<?php 
  session_start();
  require_once './functions/class.controller.php';
  require_once './functions/class.displayer.php';
  require_once './functions/class.database.php';

?>

<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include './div/head.html'?>

<body class="d-flex flex-column min-vh-100">
<?php include './div/admin_topnav.html'?>
<!-- main -->
<div class="container-fluid" >
  <div class = "row">  
    <!--first main col -->
    <?php include './div/leftbar.html'?>
    <!--end of first main col -->

    <!--second main col -->
    <div class = "col-lg-10 offset-lg-2 ">
      <div class = "row">
        <div class = "col m-3 modul rounded shadow-sm">
          <div class = "header">
            <h2 class="display-4">Settings</h2>
            <small class="text-muted">Here you can add new year, change lesson times, manage person status, marks categories or change current year.</small>
          </div>
              

<!-- CONTROLLER -->
<?php
  $database = new DataBase();
  $displayer = new Displayer ($database);
  $controller = new Controller ($database, $displayer);

  $controller->htmlForm('add_year');
  $controller->htmlForm('set_year');
  $controller->htmlForm('add_mark_cat');
  $controller->htmlForm('add_role_status');
  $controller->htmlForm('add_subject');
  $controller->htmlForm('add_profile');

  echo $controller->getForms();


  if (!empty ($_POST)){
    $controller->handleRequest ($_POST['action'], $_POST['old_value'], $_POST['value']);
    $displayer->displayErrors();
    $displayer->displaySuccess();
  }

?>
<!-- CONTROLLER -->
            <div class = "list-group m-4">
<!-- years settings -->
            <button aria-controls="years" style = "border-left: 4px solid rgb(216, 142, 4);" class="list-group-item list-group-item-action m-1" data-toggle="collapse" data-target="#years" aria-expanded="false">
              Year manage
            </button>
    
              <div id="years" class="collapse">  
                <div class="row m-3">
                  <div class="col-sm-6">
                    <p class="lead">Add new year</p>
                      <input type = "text" class="form-control" name = "value" form = "add_year" placeholder = "2020/2021" required>
                      <button class="button" form = "add_year" >add</button>
                  </div>
                  <div class="col-sm-6">
                    <p class="lead">Set current year</p>
                      <select class = "form-control" form = "set_year" name = "value" >
                        <?php $displayer->displayYearsSelect();?>
                      </select>
                      <button class="button" form = "set_year" >set</button>
                  </div>
                </div>
              </div>
<!-- years settings -->
<!-- lesson times settings -->
            <button aria-controls="lessons" style = "border-left: 4px solid rgb(245, 66, 53);" class="list-group-item list-group-item-action m-1" data-toggle="collapse" data-target="#lessons" aria-expanded="false">
              Lesson times
            </button>  
            <div id="lessons" class="collapse">
              <p class="lead">Current lesson times:</p>
                <div class="form-group m-3">
                  <?php $displayer->displayContentAsButton('getLessonTimes', '$lesson', 'time', 'lesson', 'set_lesson_time');?>
                </div>
            </div>
<!-- lesson times settings -->
<!-- marks settings -->
            <button aria-controls="marks" style = " border-left: 4px solid #4285F4" class="list-group-item list-group-item-action m-1" data-toggle="collapse" data-target="#marks" aria-expanded="false">
              Assessment
            </button>
              <div id="marks" class="collapse">
                <div class="row m-3">
                  <div class="col-sm-6">
                    <p class="lead">Edit existing categories</p>
                    <?php $displayer->displayContentAsButton('getMarksCat', '$marks', 'name', 'mark', 'set_mark_cat');?> 
                  </div>

                  <div class="col-sm-6">
                    <p class="lead">Add new category</p>
                    <input type = "text" class="form-control" name = "value" form = "add_mark_cat" placeholder = "category" required>
                    <button class="button" form = "add_mark_cat" >add</button>
                  </div>
                </div>
              </div>
 
<!-- marks settings -->
<!-- subjects settings -->
            <button aria-controls="subjects" style = " border-left: 4px solid yellow" class="list-group-item list-group-item-action m-1" data-toggle="collapse" data-target="#subjects" aria-expanded="false">
              Subjects
            </button>
              <div id="subjects" class="collapse">
                <div class="row m-3">
                  <div class="col-sm-6">
                    <p class="lead">List:</p>
                    <?php $displayer->displayContentAsButton('getSubjects', '$subjects', 'name', 'subject', 'set_subject');?> 
                  </div>

                  <div class="col-sm-6">
                    <p class="lead">Add new subject</p>
                    <input type = "text" class="form-control" name = "value" form = "add_subject" placeholder = "subject" required>
                    <button class="button" form = "add_subject" >add</button>
                  </div>
                </div>
              </div>
 
<!-- subjects settings -->
<!-- profiles settings -->
            <button aria-controls="profiles" style = " border-left: 4px solid purple" class="list-group-item list-group-item-action m-1" data-toggle="collapse" data-target="#profiles" aria-expanded="false">
              Profiles
            </button>
              <div id="profiles" class="collapse">
                <div class="row m-3">
                  <div class="col-sm-6">
                    <p class="lead">List:</p>
                    <?php $displayer->displayContentAsButton('getProfiles', '$profiles', 'name', 'profile', 'set_profile');?> 
                  </div>

                  <div class="col-sm-6">
                    <p class="lead">Add new profile</p>
                    <input type = "text" class="form-control" name = "value" form = "add_profile" placeholder = "profile" required>
                    <button class="button" form = "add_profile" >add</button>
                  </div>
                </div>
              </div>
 
<!-- profiles settings -->
<!-- person status settings -->
            <button aria-controls="status" style = " border-left: 4px solid grey" class="list-group-item list-group-item-action m-1" data-toggle="collapse" data-target="#status" aria-expanded="false">
              Person status
            </button>
    
            <div id="status" class="collapse">
              <div class="row m-3">
                <div class="col-sm-6">
                  <p class="lead">Available statuses/roles</p>
                  <?php $displayer->displayContentAsButton('getRoleStatus', '$status', 'name', 'status', 'set_role_status');?> 
                </div>

                <div class="col-sm-6">
                  <p class="lead">Add new category</p>
                  <input type = "text" class="form-control" name = "value" form = "add_role_status" placeholder = "category" required>
                  <button class="button" form = "add_role_status" >add</button>
                </div>
              </div>
            </div>
<!-- person status settings -->

          </div> <!--end of list-group -->
        </div>
      </div>
    </div>
    <!--end of second main col -->
  </div>
</div>
 <!--end main -->


<!-- Footer -->
<?php include './div/footer.html'?>
<!-- Footer -->
<script src = "js/collapse.js"></script>
</body>
</html>
