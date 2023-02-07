<?php

	$PAGE_VAR["js"][] = "about";
	// $PAGE_VAR["js"][] = "template/libs/apexcharts/dist/apexcharts.min";

	if($_SESSION['status'] != true && $_SESSION['isAdmin'] != true){
	 header("Location: ".WEB_META_BASE_LANG."login/");
	}

?>

<div class="container-xl">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">About</h3>
			</div>
			<div class="card-body">
				<div class="row row-0">
					<div class="col-md-8 col-12">
						<iframe id="iframe_src" width="100%" height="500px" allow='autoplay'></iframe>
					</div>
					<div class="col-md-4 col-12">
						<div class="card-body">
							<h3 class="card-title">Update about</h3>
							<form id="frm_about">
								<div class="row">
									<div class="col-12">
										<div class="mb-3">
											<label class="form-label">YOUTUBE URL</label>
											<div class="input-group input-group-flat">
												<span class="input-group-text">
													https://www.youtube.com/watch?v=
												</span>
												<input id="youtube_url" name="youtube_url" type="text" class="form-control ps-0" value="w-RzNzsaZvs" autocomplete="off">
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
									<div class="col-md-6 col-12">
										<button type="submit" class="btn btn-yellow w-100">
											Update
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>



