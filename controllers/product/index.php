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

<div class="container-fluid">
  <div class="card">
    <div class="card-header">
          <h3 class="card-title">Product</h3>
          <div class="col-auto ms-auto d-print-none">
              <button class="btn btn-white" id="btn_product_type">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                    <path d="M10 14l10 -10"></path>
                    <path d="M15 4l5 0l0 5"></path>
                </svg>
                  Category
              </button>
              <button class="btn btn-white" id="btn_product_brand">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                    <path d="M10 14l10 -10"></path>
                    <path d="M15 4l5 0l0 5"></path>
                </svg>
                  Brand
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
            <th>PRODUCT Code</th>
            <th>IMAGES</th>
            <th>TAG</th>
            <th>PRODUCT NAME</th>
            <th>PRODUCT TYPE</th>
            <th>PRODUCT BRAND</th>
            <th>PRODUCT PRICE</th>
            <th>PRODUCT SALE</th>
            <th>PRODUCT WEGIHT</th>
            <th>PRODUCT ACTIVE</th>
            <!-- <th>Createdatetime</th> -->
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
                    <div class="col-md-7 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="card card-sm mb-2">
                                    <a class="d-block" target="_blank">
                                        <img id="show_product_img_1" name="add_show_product_img" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                    </a>
                                    <div class="card-body" style="padding: 5px 0 0 0;">
                                        <div class="d-flex align-items-center">
                                            <input name="add_product_img[]" data-img="1" type="file" accept="image/*" class="form-control">
                                        </div>
                                    </div>
                                    <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="show_product_img_2" name="add_show_product_img" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="add_product_img[]" data-img="2" type="file" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                    </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="show_product_img_3" name="add_show_product_img" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="add_product_img[]" data-img="3" type="file" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                    </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="show_product_img_4" name="add_show_product_img" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="add_product_img[]" data-img="4" type="file" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                    </div>
                            </div>
                        </div>
                        <!-- <div class="row">
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
                        </div> -->
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="add_product_no" name="add_product_no" class="form-control" placeholder="Enter Product Code">
                                <label for="add_product_no">Product Code.</label>
                            </div>
                        </div>
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
                                <select class="form-select" id="add_product_brand" name="add_product_brand">
                                    <option value="" selected disabled>Select product brand</option>
                                </select>
                                <label for="add_product_brand">Select</label>
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
                            <div class="form-floating d-none add_price_sale">
                                <input type="tel" id="add_product_price_sale" name="add_product_price_sale" class="form-control" placeholder="Enter price name">
                                <label for="add_product_price_sale">Product price sale</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-12 mb-3">
                                <div class="form-floating">
                                    <input type="tel" id="add_product_weight" name="add_product_weight" class="form-control" placeholder="Enter weight name">
                                    <label for="add_product_weight">Product weight</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="add_product_weight_type" name="add_product_weight_type">
                                        <option value="1" selected>kg</option>
                                    </select>
                                    <label for="add_product_weight_type">Weight type</label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="tel" id="add_product_stock" name="add_product_stock" class="form-control" placeholder="Enter stock">
                                <label for="add_product_stock">Product stock</label>
                            </div>
                        </div> -->
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

                    <div class="col-md-7 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="card card-sm mb-2">
                                    <a class="d-block" target="_blank">
                                        <img id="edit_show_product_img_1" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                    </a>
                                    <div class="card-body" style="padding: 5px 0 0 0;">
                                        <div class="d-flex align-items-center">
                                            <input name="edit_product_img[]" data-img="1" type="file" accept="image/*" class="form-control">
                                        </div>
                                    </div>
                                    <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="edit_show_product_img_2" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="edit_product_img[]" data-img="2" type="file" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                    </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="edit_show_product_img_3" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="edit_product_img[]" data-img="3" type="file" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                    </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-sm">
                                        <a class="d-block" target="_blank">
                                            <img id="edit_show_product_img_4" src='<?=WEB_META_BASE_URL?>images/default_product.jpg' class="card-img-top" style="object-fit: cover;height: 305px;">
                                        </a>
                                        <div class="card-body" style="padding: 5px 0 0 0;">
                                            <div class="d-flex align-items-center">
                                                <input name="edit_product_img[]" data-img="4" type="file" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <span class="badge bg-red-lt">** File size limit 3 Mb</span>
                                    </div>
                            </div>
                        </div>
                        <!-- <div class="card card-sm mb-2">
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
                        </div> -->
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="edit_product_no" name="edit_product_no" class="form-control" placeholder="Enter Product Code">
                                <label for="edit_product_no">Product Code.</label>
                            </div>
                        </div>
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
                            <div class="form-floating edit_price_sale d-none">
                                <input type="tel" id="edit_product_price_sale" name="edit_product_price_sale" class="form-control" placeholder="Enter price name">
                                <label for="edit_product_price_sale">Product price sale</label>
                            </div>
                        </div>
                        <!-- <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="tel" id="edit_product_stock" name="edit_product_stock" class="form-control" placeholder="Enter stock">
                                    <label for="edit_product_stock">Product stock</label>
                                </div>
                            </div> -->
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

<div id="modal_add_type"></div>
<div id="modal_add_brand"></div>
<div id="modal_product_image"></div>
<div id="modal_remove"></div>
<div id="modal_remove_type"></div>