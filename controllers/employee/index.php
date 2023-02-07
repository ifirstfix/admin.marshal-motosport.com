<?php
$PAGE_VAR["js"][] = "employee";

if ($_SESSION['status'] != true && $_SESSION['isAdmin'] != true) {
    header("Location: " . WEB_META_BASE_LANG . "login/");
}
?>

<div class="container-xl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Employee List</h3>
            <div class="col-auto ms-auto d-print-none">
                <a href="#" class="btn btn-yellow d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal_add">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Add Employee
                </a>
                <a href="#" class="btn btn-yellow d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal_add" aria-label="Add Speaker">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="table-responsive my-3">
            <table id="datatable_employee" class="table table-vcenter text-nowrap w-100">
                <thead>
                    <tr>
                        <th>STATUS</th>
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>LANGUAGEUSER</th>
                        <th>GROUP</th>
                        <th>Tools</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal_remove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 9v2m0 4v.01" />
                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                </svg>
                <h3>Are you sure?</h3>
                <div class="text-muted">Do you really want to remove <b class="title"></b>? What you've done cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-white w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-danger w-100 btn-confirm-del" data-bs-dismiss="modal">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal_add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            <form id="frm_add_employee">
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">New employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" id="add_emp_username" name="add_emp_username" class="form-control" placeholder="Enter user name">
                        <label for="add_emp_username">User Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" id="add_emp_password" name="add_emp_password" class="form-control" placeholder="Password">
                        <label for="add_emp_username">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" id="add_emp_email" name="add_emp_email" class="form-control" placeholder="Enter e-mail">
                        <label for="add_emp_email">Email address</label>
                    </div>
                    <div class="mb-3">
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="add_emp_language" value="th" class="form-selectgroup-input" checked="">
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="flag flag-country-th flag-xs me-2"></span>
                                <strong>TH</strong> LANGUAGE
                              </div>
                            </div>
                          </label>
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="add_emp_language" value="us" class="form-selectgroup-input">
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="flag flag-country-us flag-xs me-2"></span>
                                <strong>US</strong> LANGUAGE
                              </div>
                            </div>
                          </label>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <select id="add_emp_group" name="add_emp_group" class="form-select">
                            <option value="" selected="" disabled="">Open this select group</option>
                            <option value="1">Admin</option>
                            <option value="2">Creator</option>
                            <option value="3">Product</option>
                        </select>
                        <label for="add_emp_group">GROUP</label>
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
                        Create new employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-status bg-yellow"></div>
            <form id="frm_edit_employee">
                <div class="modal-header">
                    <h5 class="modal-title text-yellow">Edit employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" id="edit_e_username" name="edit_e_username" class="form-control" placeholder="Enter user name">
                        <label for="edit_e_username">User Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" id="edit_e_password" name="edit_e_password" class="form-control" placeholder="Password">
                        <label for="edit_e_password">New Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" id="edit_e_email" name="edit_e_email" class="form-control" placeholder="Enter e-mail">
                        <label for="edit_e_email">Email address</label>
                    </div>
                    <div class="mb-3">
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="edit_e_language" value="th" class="form-selectgroup-input" >
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="flag flag-country-th flag-xs me-2"></span>
                                <strong>TH</strong> LANGUAGE
                              </div>
                            </div>
                          </label>
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="edit_e_language" value="us" class="form-selectgroup-input">
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="flag flag-country-us flag-xs me-2"></span>
                                <strong>US</strong> LANGUAGE
                              </div>
                            </div>
                          </label>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <select id="edit_e_group" name="edit_e_group" class="form-select">
                            <option value="" selected="" disabled="">Open this select group</option>
                            <option value="1">Admin</option>
                            <option value="2">Creator</option>
                            <option value="3">Product</option>
                        </select>
                        <label for="edit_e_group">GROUP</label>
                    </div>

                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                        <label class="form-selectgroup-item flex-fill">
                        <input type="checkbox" name="edit_e_status" class="form-selectgroup-input">
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div id="edit_text_status" class="form-selectgroup-label-content d-flex align-items-center">
                                <span class="avatar me-3 badge bg-success"></span>
                                <div>
                                    <div class="font-weight-medium">Enable</div>
                                </div>
                            </div>
                        </div>
                        </label>
                    </div>

                    <input id="edit_e_id" name="edit_e_id" type="hidden">
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-white" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-warning ms-auto">
                        Update employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>