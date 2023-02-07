<?php

$PAGE_VAR["js"][] = "gallery";

if($_SESSION['status'] != true && $_SESSION['isAdmin'] != true){
  header("Location: ".WEB_META_BASE_LANG."login/");
}

?>

<div class="container-xl">

  <div class="card">
    <div class="card-header">
          <h3 class="card-title">Service Gallery</h3>
          <div class="col-auto ms-auto d-print-none">
              <a href="#" class="btn btn-yellow d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal_add">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
                  Add Gallery
              </a>
              <a href="#" class="btn btn-yellow d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal_add">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
              </a>
          </div>
      </div>
    <div class="table-responsive my-3">
      <table id="dtb_gallery" class="table table-vcenter text-nowrap w-100">
        <thead>
          <tr>
            <th>Image</th>
            <th>Image name</th>
            <th>Image alt</th>
            <th>Image active</th>
            <th>Createdatetime</th>
            <th>Tools</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal_add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            <form id="frm_add_gallery">
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">New gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <div class="card card-sm">
                        <a class="d-block" target="_blank">
                          <img id="show_gallery_img" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 20rem;object-fit: cover;">
                        </a>
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <input id="add_gallery_img" name="add_gallery_img" type="file" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="add_gallery_name" name="add_gallery_name" class="form-control" placeholder="Enter user name">
                          <label for="add_gallery_name">Image name</label>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="add_gallery_alt" name="add_gallery_alt" class="form-control" placeholder="Enter user name">
                          <label for="add_gallery_alt">Image alt</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-white" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-yellow ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Create new gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            <form id="from_edit_gallery">
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Edit gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <div class="card card-sm">
                        <a class="d-block" target="_blank">
                          <img id="show_edit_gallery_img" class="card-img-top" style="height: 20rem;object-fit: cover;">
                        </a>
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <input id="edit_gallery_img" name="edit_gallery_img" type="file" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="edit_gallery_name" name="edit_gallery_name" class="form-control" placeholder="Enter user name">
                          <label for="edit_gallery_name">Image name</label>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="edit_gallery_alt" name="edit_gallery_alt" class="form-control" placeholder="Enter user name">
                          <label for="edit_gallery_alt">Image alt</label>
                      </div>
                    </div>
                    <input id="edit_g_id" name="edit_g_id" type="hidden">
                  </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-white" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-yellow ms-auto">
                        Update gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

  
<div id="modal_gallery_image"></div>
<div id="modal_removeGallery"></div>