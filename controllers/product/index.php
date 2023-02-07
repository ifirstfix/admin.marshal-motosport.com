<?php
    $PAGE_VAR["js"][] = "product";
    if($_SESSION['status'] != true || ($_SESSION['isAdmin'] != true && $_SESSION['group'] != '3')){
        header("Location: ".WEB_META_BASE_LANG."login/");
    }
?>
<style>
    .truncate {
        max-width:100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } 
    .truncate-200 {
        max-width:200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } 
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
          <h3 class="card-title">Product</h3>
          <div class="col-auto ms-auto d-print-none">
            <button class="btn btn-white" id="btn_product_type">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
                  Product Type
              </button>
              <a href="#" class="btn btn-yellow" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal_add">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                  </svg>
                  Add Product
              </a>
          </div>
      </div>
    <div class="table-responsive my-3">
      <table id="dtb_product" class="table table-vcenter text-nowrap w-100">
        <thead>
          <tr>
            <th>ORDER</th>
            <th>IMAGES</th>
            <th>TAG</th>
            <th>PRODUCT NAME</th>
            <th>PRODUCT TYPE</th>
            <th>PRODUCT PRICE</th>
            <th>PRODUCT SALE</th>
            <th>PRODUCT ACTIVE</th>
            <th>Createdatetime</th>
            <th>Tools</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal_add" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">New product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="frm_add_product">
                  <div class="row">
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <div class="card card-sm mb-2">
                                    <a class="d-block" target="_blank">
                                        <img id="show_product_img_1" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 17rem;object-fit: cover;">
                                    </a>
                                    <div class="card-body" style="padding: 5px 0 0 0;">
                                        <div class="d-flex align-items-center">
                                            <input name="add_product_img[]" data-img="1" type="file" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <div class="card card-sm">
                                            <a class="d-block" target="_blank">
                                                <img id="show_product_img_2" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 190px;object-fit: cover;">
                                            </a>
                                            <div class="card-body" style="padding: 5px 0 0 0;">
                                                <div class="d-flex align-items-center">
                                                    <input name="add_product_img[]" data-img="2" type="file" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <div class="card card-sm">
                                            <a class="d-block" target="_blank">
                                                <img id="show_product_img_3" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 190px;object-fit: cover;">
                                            </a>
                                            <div class="card-body" style="padding: 5px 0 0 0;">
                                                <div class="d-flex align-items-center">
                                                    <input name="add_product_img[]" data-img="3" type="file" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <div class="card card-sm">
                                            <a class="d-block" target="_blank">
                                                <img id="show_product_img_4" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 190px;object-fit: cover;">
                                            </a>
                                            <div class="card-body" style="padding: 5px 0 0 0;">
                                                <div class="d-flex align-items-center">
                                                    <input name="add_product_img[]" data-img="4" type="file" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-12">
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="add_product_type" name="add_product_type">
                                            <option value="" selected disabled>Select product type</option>
                                            <?php
                                                foreach (product_type() as $key => $value) {
                                                    echo '<option value="' . $value['PRODUCT_TYPE_ID'] . '">' . $value['PRODUCT_TYPE_NAME_TH'] . ' (' . $value['PRODUCT_TYPE_NAME_EN'] . ') </option>';
                                                }
                                            ?>
                                        </select>
                                        <label for="add_product_type">Select</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="text" id="add_product_name_th" name="add_product_name_th" class="form-control" placeholder="Enter Product name">
                                        <label for="add_product_name_th">Product name TH</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="text" id="add_product_name_en" name="add_product_name_en" class="form-control" placeholder="Enter Product name">
                                        <label for="add_product_name_en">Product name EN</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div id="add_product_detail_th" name="add_product_detail_th" class="quill" style="height: auto;"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div id="add_product_detail_en" name="add_product_detail_en" class="quill" style="height: auto;"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="add_product_tag" name="add_product_tag">
                                            <option value="NEW" selected>NEW</option>
                                            <option value="PROMOTION">PROMOTION</option>
                                            <option value="HOT">HOT</option>
                                            <option value="SALE">SALE</option>
                                        </select>
                                        <label for="add_product_tag">Select</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" id="add_product_price" name="add_product_price" class="form-control" placeholder="Enter price name">
                                        <label for="add_product_price">Product price</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" id="add_product_price_sale" name="add_product_price_sale" class="form-control d-none" placeholder="Enter price name">
                                        <label for="add_product_price_sale">Product price sale</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" id="add_product_stock" name="add_product_stock" class="form-control" placeholder="Enter stock">
                                        <label for="add_product_stock">Product stock</label>
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
                        Create new product
                    </button>
                    </form>
                </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_edit" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            <div class="modal-header">
                <h5 class="modal-title text-yellow">Edit product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="frm_edit_product">
                <div class="row">
                    <div class="row">
                        <div class="col-md-7 col-12">
                            <div class="card card-sm mb-2">
                                <a class="d-block" target="_blank">
                                    <img id="edit_show_product_img_1" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 17rem;object-fit: cover;">
                                </a>
                                <div class="card-body" style="padding: 5px 0 0 0;">
                                    <div class="d-flex align-items-center">
                                        <input name="edit_product_img[]" data-img="1" type="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="edit_show_product_img_2" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 190px;object-fit: cover;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="edit_product_img[]" data-img="2" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="edit_show_product_img_3" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 190px;object-fit: cover;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="edit_product_img[]" data-img="3" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="edit_show_product_img_4" src='<?=WEB_META_BASE_URL?>images/no-image.jpg' class="card-img-top" style="height: 190px;object-fit: cover;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="edit_product_img[]" data-img="4" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="edit_product_type" name="edit_product_type">
                                        <option value="" selected disabled>Select product type</option>
                                        <?php
                                            foreach (product_type() as $key => $value) {
                                                echo '<option value="' . $value['PRODUCT_TYPE_ID'] . '">' . $value['PRODUCT_TYPE_NAME_TH'] . ' (' . $value['PRODUCT_TYPE_NAME_EN'] . ') </option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="edit_product_type">Select</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" id="edit_product_name_th" name="edit_product_name_th" class="form-control" placeholder="Enter Product name">
                                    <label for="edit_product_name_th">Product name TH</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" id="edit_product_name_en" name="edit_product_name_en" class="form-control" placeholder="Enter Product name">
                                    <label for="edit_product_name_en">Product name EN</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div id="edit_product_detail_th" name="edit_product_detail_th" class="quill" style="height: auto;"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <div id="edit_product_detail_en" name="edit_product_detail_en" class="quill" style="height: auto;"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="edit_product_tag" name="edit_product_tag">
                                        <option value="NEW" selected>NEW</option>
                                        <option value="PROMOTION">PROMOTION</option>
                                        <option value="HOT">HOT</option>
                                        <option value="SALE">SALE</option>
                                    </select>
                                    <label for="edit_product_tag">Select</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="tel" id="edit_product_price" name="edit_product_price" class="form-control" placeholder="Enter price name">
                                    <label for="edit_product_price">Product price</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="tel" id="edit_product_price_sale" name="edit_product_price_sale" class="form-control d-none" placeholder="Enter price name">
                                    <label for="edit_product_price_sale">Product price sale</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" id="edit_product_stock" name="edit_product_stock" class="form-control" placeholder="Enter stock">
                                        <label for="edit_product_stock">Product stock</label>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <input id="edit_product_id" name="edit_product_id" type="text" hidden>
            </div>
            <div class="modal-footer">
                <button class="btn btn btn-white" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-yellow ms-auto">
                    Update product
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_add_type" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form id="frm_type">
                <div class="modal-status bg-yellow"></div>
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Product type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-12 mb-3">
                            <label class="form-label">Product type TH</label>
                            <input type="text" id="product_type_th" name="product_type_th" class="form-control" placeholder="Enter Product type">
                        </div>
                        <div class="col-md-5 col-12 mb-3">
                            <label class="form-label">Product type EN</label>
                            <input type="text" id="product_type_en" name="product_type_en" class="form-control" placeholder="Enter Product type">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <div class="d-none d-sm-inline-block" style="margin-bottom: 3.1rem;"></div>
                            <button type="submit" id="submit_product_type" class="btn btn-yellow ms-auto">
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
                                <table id="tb_product_type" class="table card-table table-vcenter text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ORDER</th>
                                            <th>TYPE NAME TH</th>
                                            <th>TYPE NAME EN</th>
                                            <th>ACTIVE</th>
                                            <th>TOOLS</th>
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

<div id="modal_product_image"></div>
<div id="modal_remove"></div>
<div id="modal_remove_type"></div>