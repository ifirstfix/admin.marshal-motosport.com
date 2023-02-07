<?php
    $PAGE_VAR["js"][] = "delivery";

    if($_SESSION['status'] != true && $_SESSION['isAdmin'] != true){
    header("Location: ".WEB_META_BASE_LANG."login/");
    }
?>
<style>
    .truncate {
        max-width:200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } 

    /* .tb-delivery tbody, thead tr { display: block; }

    .tb-delivery tbody {
        height: 100px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .tb-delivery tbody td, thead th {
        width: 33.33%;
    } */



</style>

<div class="container-xl">

  <div class="card">
    <div class="card-header">
          <h3 class="card-title">Delivery</h3>
          <div class="col-auto ms-auto d-print-none">
            <button class="btn btn-white" id="btn_delivery_type">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
                  Delivery Type
              </button>
              <a href="#" class="btn btn-yellow" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal_add">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
                  Add Delivery
              </a>
          </div>
      </div>
    <div class="table-responsive my-3">
      <table id="dtb_delivery" class="table table-vcenter text-nowrap w-100">
        <thead>
          <tr>
            <th>DELIVERY NAME</th>
            <th>DELIVERY TYPE</th>
            <th>DELIVERY PRICE</th>
            <th>DELIVERY ACTIVE</th>
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
            <form id="frm_add_delivery">
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">New delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="add_delivery_name_th" name="add_delivery_name_th" class="form-control" placeholder="Enter Delivery name">
                                <label for="add_delivery_name_th">Delivery name TH</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="add_delivery_name_en" name="add_delivery_name_en" class="form-control" placeholder="Enter Delivery name">
                                <label for="add_delivery_name_en">Delivery name EN</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="add_delivery_type" name="add_delivery_type">
                                    <option value="" selected disabled>Open this select menu</option>
                                    <?php
                                        foreach (delivery_type() as $key => $value) {
                                            echo '<option value="' . $value['DELIVERY_TYPE_ID'] . '">' . $value['DELIVERY_TYPE_NAME_TH'] . ' (' . $value['DELIVERY_TYPE_NAME_EN'] . ') </option>';
                                        }
                                    ?>
                                </select>
                                <label for="add_delivery_type">Select</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="tel" id="add_delivery_price" name="add_delivery_price" class="form-control" placeholder="Enter price name">
                                <label for="add_delivery_price">Delivery price</label>
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
                        Create new delivery
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
            <form id="from_edit_delivery">
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Edit delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="edit_delivery_name_th" name="edit_delivery_name_th" class="form-control" placeholder="Enter Delivery name">
                                <label for="edit_delivery_name_th">Delivery name TH</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="edit_delivery_name_en" name="edit_delivery_name_en" class="form-control" placeholder="Enter Delivery name">
                                <label for="edit_delivery_name_en">Delivery name EN</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="edit_delivery_type" name="edit_delivery_type">
                                    <option value="" selected disabled>Open this select menu</option>
                                    <?php
                                        foreach (delivery_type() as $key => $value) {
                                            echo '<option value="' . $value['DELIVERY_TYPE_ID'] . '">' . $value['DELIVERY_TYPE_NAME_TH'] . ' (' . $value['DELIVERY_TYPE_NAME_EN'] . ') </option>';
                                        }
                                    ?>
                                </select>
                                <label for="edit_delivery_type">Select</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="tel" id="edit_delivery_price" name="edit_delivery_price" class="form-control" placeholder="Enter price name">
                                <label for="edit_delivery_price">Delivery price</label>
                            </div>
                        </div>

                        <input id="edit_delivery_id" name="edit_delivery_id" type="text" hidden>
                  </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-white" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-yellow ms-auto">
                        Update Delivery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_add_type" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form id="frm_delivery_type">
                <div   div class="modal-status bg-yellow"></div>
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Delivery type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-12 mb-3">
                            <label class="form-label">Delivery type TH</label>
                            <input type="text" id="delivery_type_th" name="delivery_type_th" class="form-control" placeholder="Enter Delivery type">
                        </div>
                        <div class="col-md-5 col-12 mb-3">
                            <label class="form-label">Delivery type EN</label>
                            <input type="text" id="delivery_type_en" name="delivery_type_en" class="form-control" placeholder="Enter Delivery type">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <div class="d-none d-sm-inline-block" style="margin-bottom: 3.1rem;"></div>
                            <button type="submit" id="submit_delivery_type" class="btn btn-yellow ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Create new type 
                            </button>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tb-delivery-type" class="table card-table table-vcenter text-nowrap tb-delivery w-100">
                                    <thead>
                                        <tr>
                                            <th>TYPE NAME TH</th>
                                            <th>TYPE NAME EN</th>
                                            <th class="text-center">ACTIVE</th>
                                            <th class="text-center">TOOLS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb-tbody"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-white ms-auto" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

  
<div id="modal_gallery_image"></div>
<div id="modal_remove"></div>
<div id="modal_remove_type"></div>