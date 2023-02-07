<?php

	$PAGE_VAR["js"][] = "banner";
	// $PAGE_VAR["js"][] = "template/libs/apexcharts/dist/apexcharts.min";
	if($_SESSION['status'] != true && $_SESSION['isAdmin'] != true){
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
</style>

<div class="container-xl">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Banner</h3>
			<div class="col-auto ms-auto d-print-none">
				<a href="#" id="btn_banner" class="btn btn-yellow d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal_add">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<line x1="12" y1="5" x2="12" y2="19" />
						<line x1="5" y1="12" x2="19" y2="12" />
					</svg>
					Add Banner
				</a>
				<a href="#" id="btn_banner" class="btn btn-yellow d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal_add">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<line x1="12" y1="5" x2="12" y2="19" />
						<line x1="5" y1="12" x2="19" y2="12" />
					</svg>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div id="show_banner" class="row row-cards" style="max-height: 53rem;overflow-y: auto;"></div>
		</div>

	</div>


	<!-- <div class="page">
		<div class="content">
			<div class="page-header d-print-none">
				<div class="row align-items-center">
					<div class="col">
						<h2 class="page-title">
							Banner
						</h2>
					</div>
					<div class="col-auto ms-auto d-print-none">
						<div class="d-flex">
							<button id="btn_banner" class="btn btn-primary">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
								Add banner
							</button>
						</div>
					</div>
				</div>
			</div>
			<div id="show_banner" class="row row-cards" style="max-height: 53rem;overflow-y: auto;"></div>
		</div>
	</div> -->
</div>

<div class="modal modal-blur fade" id="modal_add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">New banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
				<form id="add_banner">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <div class="card card-sm">
                        <a class="d-block" target="_blank">
                          <img id="banner_img" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 20rem;object-fit: cover;">
                        </a>
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <input id="add_banner_img" name="add_banner_img" type="file" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="add_banner_name" name="add_banner_name" class="form-control" placeholder="Enter user name">
                          <label for="add_banner_name">Image name</label>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="add_banner_alt" name="add_banner_alt" class="form-control" placeholder="Enter user name">
                          <label for="add_banner_alt">Image alt</label>
                      </div>
                    </div>
					<div class="col-12 mb-3">
						<label for="add_banner_detail_th">Detail TH</label>
						<div id="add_banner_detail_th" name="add_banner_detail_th" class="quill" style="height: auto;"></div>
					</div>
					<div class="col-12">
						<label for="add_banner_detail_en">Detail EN</label>
						<div id="add_banner_detail_en" name="add_banner_detail_en" class="quill" style="height: auto;"></div>
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
					</form>
                </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Edit banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
				<form id="edit_banner">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <div class="card card-sm">
                        <a class="d-block" target="_blank">
                          <img id="edit_show_banner_img" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 20rem;object-fit: cover;">
                        </a>
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <input id="edit_banner_img" name="edit_banner_img" type="file" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="edit_banner_name" name="edit_banner_name" class="form-control" placeholder="Enter user name">
                          <label for="edit_banner_name">Image name</label>
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="form-floating">
                          <input type="text" id="edit_banner_alt" name="edit_banner_alt" class="form-control" placeholder="Enter user name">
                          <label for="edit_banner_alt">Image alt</label>
                      </div>
                    </div>
					<div class="col-12 mb-3">
						<label for="edit_banner_detail_th">Detail TH</label>
						<div id="edit_banner_detail_th" name="edit_banner_detail_th" class="quill" style="height: auto;"></div>
					</div>
					<div class="col-12">
						<label for="edit_banner_detail_en">Detail EN</label>
						<div id="edit_banner_detail_en" name="edit_banner_detail_en" class="quill" style="height: auto;"></div>
					</div>

					<input type="text" id="edit_banner_id" name="edit_banner_id" hidden>
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

<div id="modal_removeBanner"></div>

