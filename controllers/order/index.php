<?php
  $PAGE_VAR["js"][] = "order";

  if($_SESSION['status'] != true && $_SESSION['isAdmin'] != true){
  header("Location: ".WEB_META_BASE_LANG."login/");
  }

?>

<div class="container-xl">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Order list</h3>
    </div>
    <div class="table-responsive my-3">
      <table id="dtb_order" class="table table-vcenter text-nowrap w-100">
        <thead>
          <tr>
            <th>STATUS</th>
            <th>BUYER</th>
            <th>INVOICE</th>
            <th>PRICE</th>
            <th>reference</th>
            <th>ORDER DATE</th>
            <th>PRODUCT LIST</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal_product_list" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form id="frm_type">
                <div class="modal-status bg-yellow"></div>
                <div class="modal-header">
                    <h5 id="text_order" class="modal-title text-yellow"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dtb_product_list" class="table card-table table-vcenter text-nowrap w-100">
                                    <thead>
                                        <tr>
                                          <th>IMAGES</th>
                                          <th>PRODUCT NAME</th>
                                          <th>PRODUCT TYPE</th>
                                          <th>PRODUCT PRICE</th>
                                          <th>QTY</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th colspan="3" rowspan="1"></th>
                                          <th class="text-center" rowspan="1" colspan="1">0 ( 0 Total)</th>
                                          <th class="text-center" rowspan="1" colspan="1">0 ( 0 Total)</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                    <input type="text" id="order_product_id" name="order_product_id" hidden>
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

<div id="modal_image"></div>