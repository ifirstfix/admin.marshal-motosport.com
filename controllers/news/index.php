<?php

$PAGE_VAR["js"][] = "news";

if($_SESSION['status'] != true || ($_SESSION['isAdmin'] != true && $_SESSION['group'] != '2')){
  header("Location: ".WEB_META_BASE_LANG."login/");
}

?>
<style>
    .ql-toolbar.ql-snow {
      background: white !important;
    }
    .ql-editor.ql-blank::before {
        color: white !important;
    }
    .truncate {
        max-width:200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } 
    .daterangepicker {
      background-color: #232e3c !important;
      border: 1px solid #f59f00 !important;
    }
    .daterangepicker .calendar-table {
      background-color: #232e3c !important;
    }
    .daterangepicker td.active, .daterangepicker td.active:hover {
        background-color: #f59f00 !important;
    }
    .daterangepicker td.available:hover, .daterangepicker th.available:hover {
        background-color: #f59f00 !important;
    }
    .daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
      background-color: transparent !important;
    }
</style>

<div class="container-xl">
  <div class="card">
    <div class="card-header">
          <h3 class="card-title">News</h3>
          <div class="col-auto ms-auto d-print-none">
              <a href="#" class="btn btn-yellow d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal_add">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
                  Add News
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
      <table id="dtb_news" class="table table-vcenter text-nowrap w-100">
        <thead>
          <tr>
            <th>Image</th>
            <th>Title th</th>
            <th>Title en</th>
            <th>Video</th>
            <th>Active</th>
            <th>PUBLICDATETIME</th>
            <th>Tools</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal_add" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="frm_add_news">
                  <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                      <label class="form-label">Public Datetime</label>
                      <input type="text" id="news_public" name="news_public" class="form-control"  placeholder="Please select">
                    </div> 
                    <div class="col-12 mb-3">
                      <div class="card card-sm">
                        <a class="d-block" target="_blank">
                          <img id="show_news_img" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 20rem;object-fit: cover;">
                        </a>
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <input id="add_news_img" name="add_news_img" type="file" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="add_title_th" name="add_title_th" class="form-control" placeholder="Enter user name">
                          <label for="add_title_th">Title TH</label>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="add_title_en" name="add_title_en" class="form-control" placeholder="Enter user name">
                          <label for="add_title_en">Title EN</label>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="add_news_detail_th">Detail TH</label>
                      <div id="add_news_detail_th" name="add_news_detail_th" class="quill" style="height: auto;"></div>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="add_news_detail_en">Detail EN</label>
                      <div id="add_news_detail_en" name="add_news_detail_en" class="quill" style="height: auto;"></div>
                    </div>
                    <div class="col-md-6 col-12">
                        <iframe id="news_iframe_src" allow="autoplay" src="https://www.youtube.com/embed/" width="100%"></iframe>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">YOUTUBE URL</label>
                                    <div class="input-group input-group-flat">
                                        <span class="input-group-text">
                                            https://www.youtube.com/watch?v=
                                        </span>
                                        <input id="new_youtube_url" name="new_youtube_url" type="text" class="form-control ps-0" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column mb-3">
                                    <label class="form-selectgroup-item flex-fill">
                                    <input type="checkbox" name="auto_play" class="form-selectgroup-input">
                                    <div class="form-selectgroup-label d-flex align-items-center p-2">
                                        <div class="me-2">
                                            <span class="form-selectgroup-check"></span>
                                        </div>
                                        <div id="edit_text_status" class="form-selectgroup-label-content d-flex align-items-center">
                                            <div class="font-weight-medium">Autoplay</div>
                                        </div>
                                    </div>
                                    </label>
                                </div>
                            </div>
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
                        Create News
                    </button>
                    </form>
                </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal_edit" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Edit News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="from_edit_news">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                          <label class="form-label">Public Datetime</label>
                          <input type="text" id="edit_news_public" name="edit_news_public" class="form-control"  placeholder="Please select">
                        </div> 
                        <div class="col-12 mb-3">
                          <div class="card card-sm">
                            <a class="d-block" target="_blank">
                              <img id="edit_show_news_img" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 20rem;object-fit: cover;">
                            </a>
                            <div class="card-body">
                              <div class="d-flex align-items-center">
                                <input id="edit_news_img" name="edit_news_img" type="file" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 mb-3">
                          <div class="form-floating">
                              <input type="text" id="edit_title_th" name="edit_title_th" class="form-control" placeholder="Enter user name">
                              <label for="edit_title_th">Title TH</label>
                          </div>
                        </div>
                        <div class="col-12 mb-3">
                          <div class="form-floating">
                              <input type="text" id="edit_title_en" name="edit_title_en" class="form-control" placeholder="Enter user name">
                              <label for="edit_title_en">Title EN</label>
                          </div>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="edit_news_detail_th">Detail TH</label>
                          <div id="edit_news_detail_th" name="edit_news_detail_th" class="quill" style="height: auto;"></div>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="edit_news_detail_en">Detail EN</label>
                          <div id="edit_news_detail_en" name="edit_news_detail_en" class="quill" style="height: auto;"></div>
                        </div>
                        <div class="col-md-6 col-12">
                            <iframe id="edit_news_iframe_src" allow="autoplay" src="https://www.youtube.com/embed/" width="100%"></iframe>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">YOUTUBE URL</label>
                                        <div class="input-group input-group-flat">
                                            <span class="input-group-text">
                                                https://www.youtube.com/watch?v=
                                            </span>
                                            <input id="edit_new_youtube_url" name="edit_new_youtube_url" type="text" class="form-control ps-0" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column mb-3">
                                        <label class="form-selectgroup-item flex-fill">
                                        <input type="checkbox" name="auto_play" class="form-selectgroup-input">
                                        <div class="form-selectgroup-label d-flex align-items-center p-2">
                                            <div class="me-2">
                                                <span class="form-selectgroup-check"></span>
                                            </div>
                                            <div name="edit_autoplay" class="form-selectgroup-label-content d-flex align-items-center">
                                                <div class="font-weight-medium">Autoplay</div>
                                            </div>
                                        </div>
                                        </label>
                                    </div>
                                </div>
                                <input id="news_id" name="news_id" hidden>
                            </div>
                        </div>
                      </div>
                    </div>
                <div class="modal-footer">
                    <button class="btn btn btn-white" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-yellow ms-auto">
                        Update gallery
                    </button>
                    </form>
                </div>
        </div>
    </div>
</div>

<div id="modal_gallery_image"></div>
<div id="modal_remove"></div>