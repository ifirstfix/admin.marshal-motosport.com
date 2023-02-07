<?php
  $PAGE_VAR["js"][] = "member";

  if($_SESSION['status'] != true && $_SESSION['isAdmin'] != true){
  header("Location: ".WEB_META_BASE_LANG."login/");
  }

?>

<div class="container-xl">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Member registered</h3>
    </div>
    <div class="table-responsive my-3">
      <table id="datatable_register" class="table table-vcenter text-nowrap w-100">
        <thead>
          <tr>
            <th>MEMBER TYPE</th>
            <th>NAME</th>
            <th>SURNAME</th>
            <th>EMAIL</th>
            <th>FACEBOOK</th>
            <th>GOOGLE</th>
            <th>REGISTERED</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<div id="modal_image"></div>
<div id="modal_status"></div>
<div id="modal_shirt"></div>
