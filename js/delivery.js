$(function() {
    datatable();
    
    $("#frm_add_delivery").validate({
        rules: {
            add_delivery_name_th: {
              required: true
            },
            add_delivery_name_en : {
              required: true
            },
            add_delivery_type : {
              required: true
            }
        },
        errorPlacement: function(error, element) {
        },
        errorClass: "help-inline text-danger",
        highlight: function(element) {
             $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
             $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
         },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
         },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "add_delivery");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add', res.msg, "success")
                        dtb_delivery.ajax.reload();
                    } else {
                        alert_center('Process update', res.msg, "error")
                    }
                }
            });

        } 
    });

    $("#from_edit_delivery").validate({
        rules: {
            edit_delivery_name_th: {
                required: true
            },
            edit_delivery_name_en : {
                required: true
            },
            edit_delivery_type : {
                required: true
            },
            edit_delivery_price : {
                required: true,
                numberOnly: true
            }
        },
        errorPlacement: function(error, element) {
        },
        errorClass: "help-inline text-danger",
        highlight: function(element) {
             $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
             $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
         },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
  
         },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "edit_delivery");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                dataType: "json",
                beforeSend: function(){
                  $(':button[type="submit"]').prop('disabled', true);
                },
                complete: function(){
                  $(':button[type="submit"]').prop('disabled', false);
                },
                success: function(res) {
                  var status = res['status'];
                  var msg = res['msg'];
                  if (status == true) {
                      alert_center('Process update', msg, "success")
                      dtb_delivery.ajax.reload();
                      $('#modal_edit').modal('hide');
                  }else{
                      alert_center('Process update', msg, "error")
                  }
                }
            });

        } 
    });


    $("#modal_add").on("hidden.bs.modal", function () {
        $('#frm_add_delivery')[0].reset();
        $('#frm_add_delivery').find('.is-invalid').removeClass("is-invalid");
        $('#frm_add_delivery').find('.is-valid').removeClass("is-valid");
    });

    $("#modal_add_type").on("hidden.bs.modal", function () {
        $('#frm_delivery_type')[0].reset();
        $('#frm_delivery_type').find('.is-invalid').removeClass("is-invalid");
        $('#frm_delivery_type').find('.is-valid').removeClass("is-valid");
    });

    $('#btn_delivery_type').on('click', function(){
        // $('#modal_add_type').modal('show');
        var deliveryTypeHTML = `<div class="modal modal-blur fade" id="modal_add_type_gen" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
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
                                </div>`
        $('#modal_add_type').html(deliveryTypeHTML);
        $('#modal_add_type_gen').modal('show');    
        datatable_type();

        $("#frm_delivery_type").validate({
            rules: {
                delivery_type_th: {
                required: true
                },
                delivery_type_en : {
                required: true
                }
            },
            errorPlacement: function(error, element) {
            },
            errorClass: "help-inline text-danger",
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
                $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
                $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
            },
            submitHandler: function(form, e) {
                e.preventDefault();
                var data = new FormData($(form)[0]);
                data.append("cmd", "add_delivery_type");
                $.ajax({
                    type: "post",
                    url: BASE_LANG + "service/delivery.php",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(res){
                        if (res.status == true) {
                            $('#modal_add').modal('hide');
                            alert_center('Process add', res.msg, "success")
                            dtb_delivery_type.ajax.reload();
                        } else {
                            alert_center('Process add', res.msg, "error")
                        }
                    }
                });
    
            } 
        });
    });

    $('.weight_row_price').on('chang', function(e){
        console.log(e)
    });

});

function datatable(){
    dtb_delivery = $("#dtb_delivery").DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/delivery.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "delivery";
            }
        },
        type: "JSON",
        columns: [
            // { "data": "cus_id"},
            // { "data": "GALLERY_IMAGE", render: image},
            { "data": "DELIVERY_NAME_TH"},
            { "data": "DELIVERY_TYPE_ID", render: delivery_type },
            { "data": "DELIVERY_PRICE" },
            { "data": "DELIVERY_STATUS", render : status},
            { "data": "CREATEDATETIME", render: datetime},
            { "data": "DELIVERY_ID", render: tools}
        ],
        columnDefs: [
          { targets: [0, 1], className: "truncate", width: "30%" },
          { targets: [2,3,5], className: "text-center", width: "10%" },
          { targets: [4], className: "text-center", width: "20%" },
        //   { targets: [1, 2], width: "30%" }
        ]
    });


    $('#dtb_delivery tbody').on( 'click', '[name="remove"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove"]').attr('data-id');

        // MODAL REMOVE COURSE
        var remove_modalText  = 'Do you really want to remove this delivery?';
        var modalID           = 'modal_removeGEN';
        var btn_remove_id     = 'submit_delivery';
        modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_remove');

        $('#' + btn_remove_id).on('click', function(){
          $.ajax({
              type: "post",
              url: BASE_LANG + "service/delivery.php",
              data: {
                  "cmd": "remove",
                  "id": id
              },
              dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
              success: function(res) {
                  var status = res['status'];
                  var msg = res['msg'];
                  if (status == true) {
                      alert_center('Process remove', msg, "success")
                      dtb_delivery.ajax.reload();
                      $('#' + modalID).modal('hide');
                  }else{
                      alert_center('Process remove', msg, "error")
                  }
              }
          });
        });
    });

    $('#dtb_delivery tbody').on( 'click', '[name="active"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active"]').attr('data-id');
        var active  = (this.checked == true) ? 'on' : 'off';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "active",
                "id": id,
                "active": active
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update', msg, "success")
                    dtb_delivery.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#dtb_delivery tbody').on( 'click', '[name="update"]', function (e) { 
        $('#modal_edit').modal('show');
        var data = $(e.currentTarget).data();
        // console.log(data.id);
        // edit_show_weight_type
        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "edit_show_weight_type",
                "DELIVERY_ID": data.id
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                // var msg = res['msg'];
                if (status == true) {
                    
                    
                    for (i=0; i < 6; i++) { 
                        var data = res['data'][i];
                        $('#edit_weight_start_'+i).val(data.DELIVERY_WEIGHT_START);
                        $('#edit_weight_end_'+i).val(data.DELIVERY_WEIGHT_END);
                        $('#edit_weight_price_'+i).val(data.DELIVERY_WEIGHT_PRICT);
                        // $('#weight_row_'+i).val(data.DELIVERY_WEIGHT_PRICT);
                        $('#edit_weight_type_'+i+' option[value="' + data.WEIGHT_ID + '"]').attr('selected', true);
                    }
                    // alert_center('Process update', msg, "success")
                    // dtb_delivery.ajax.reload();
                }
            }
        });

        $('#edit_delivery_name_th').val(data.nameTh);
        $('#edit_delivery_name_en').val(data.nameEn);
        $('#edit_delivery_price').val(data.price);
        $('#edit_delivery_id').val(data.id);
        $('#edit_delivery_type option[value="' + data.type + '"]').attr('selected', true);
    });
}

function datatable_type(){
    if ( $.fn.DataTable.isDataTable('#tb-delivery-type') ) {
        $('#tb-delivery-type').DataTable().destroy();
    }
    dtb_delivery_type = $("#tb-delivery-type").DataTable({
        dom: '<"ms-3"B>rt<"d-flex justify-content-between"ip>',
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/delivery.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "delivery_type";
            }
        },
        type: "JSON",
        columns: [
            { "data": "DELIVERY_TYPE_NAME_TH"},
            { "data": "DELIVERY_TYPE_NAME_EN"},
            { "data": "DELIVERY_TYPE_STATUS", render : type_status },
            { "data": "DELIVERY_TYPE_ID", render: type_tools}
        ],
        columnDefs: [
            { targets: [0, 1], className: "truncate"},
            { targets: 2, className: "text-center", width: "10%"},
            { targets: 3, className: "text-center", width: "10%"},
        //   { targets: [1, 2], width: "30%" }
        ]
    });

    $('#tb-delivery-type tbody').on( 'click', '[name="active_type"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active_type"]').attr('data-id');
        var active  = (this.checked == true) ? 'on' : 'off';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "active_type",
                "id": id,
                "active": active
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update', msg, "success")
                    dtb_delivery_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#tb-delivery-type tbody').on( 'click', '[name="remove_type"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove_type"]').attr('data-id');

        // MODAL REMOVE COURSE
        // var remove_modalText  = 'Do you really want to remove this delivery?';
        // var modalID           = 'modal_remove_typeGEN';
        // var btn_remove_id     = 'submit-delivery-type';
        // modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_remove_type');

        // $('#' + btn_remove_id).on('click', function(){
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                data: {
                    "cmd": "remove_type",
                    "id": id
                },
                dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
                success: function(res) {
                    var status = res['status'];
                    var msg = res['msg'];
                    if (status == true) {
                        alert_center('Process remove', msg, "success")
                        dtb_delivery_type.ajax.reload();
                        // $('#' + modalID).modal('hide');
                    }else{
                        alert_center('Process remove', msg, "error")
                    }
                }
            });
        // });
    });

    $('#tb-delivery-type tbody').on( 'click', '[name="edit_type"]', function (e) {
        $(this).children('.fa-save, .fa-edit').toggleClass("fa-save fa-edit");
        $(this).attr('name','edit_save');
        var row = $(this).closest("tr");
        var tds = row.find("td").not(':last');
        
        $.each(tds, function(i, el) {
            var txt = $(this).text();
            if(i != 2){
                $(this).html("").append("<input class='form-control-tb form-control-tb-sm' id=\""+i+"\" style='width: 100%;' type='text' value=\""+txt+"\">");
            } 
        });

    });

    $('#tb-delivery-type tbody').on( 'click', '[name="edit_save"]', function (e) {
        $(this).attr('name','edit_type');
        var cars = new Array();
        var row_save = $(this).closest("tr");
        var id   = row_save.find('[name="edit_type"]').attr('data-id');
        var tds_save  = row_save.find('td').not(':last');
        $.each(tds_save, function(i, el) {
            if(i != 2){
                var type_val = $(this).find("input").val()
            }
            cars.push(type_val); 
        });

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "edit_type",
                "type_id" : id,
                "type_th": cars[0],
                "type_en": cars[1]
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update', msg, "success")
                    dtb_delivery_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });
    
}

function status(data, type, row, meta){
    var checked = (data == 'on') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['DELIVERY_ID'] + '" name="active" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function delivery_type(data, type, row, meta){
    return row['DELIVERY_TYPE_NAME_TH'] + ' (' + row['DELIVERY_TYPE_NAME_EN'] + ')';
}

function image(data, type, row, meta){
    var imagesUrl = BASE_URL + 'images/gallery/' + data;
    var images = '';
    images += '<div class="col-auto">';
    images += ' <img name="gallery_img" src="' + imagesUrl + '" ';
    images += ' data-img="'  + imagesUrl + '"';
    images += ' data-name="' + row['GALLERY_NAME'] + '"';
    images += ' data-alt="'  + row['GALLERY_ALT'] + '"';
    images += ' class="rounded cursor-pointer" width="100%" >'
    images += '</div>';

    return images;
}

function datetime(data, type, row, meta){
    return moment(data).format('YYYY-MM-DD HH:mm:ss');
}

function tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'       + data + '"';
        tools += ' data-name-th = "'  + row['DELIVERY_NAME_TH'] + '"';
        tools += ' data-name-en = "'  + row['DELIVERY_NAME_EN'] + '"';
        tools += ' data-type = "'     + row['DELIVERY_TYPE_ID'] + '"';
        tools += ' data-price = "'    + row['DELIVERY_PRICE'] + '"';
        tools += ' name="update" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button name="remove" data-id="' + data + '" class="btn btn-danger mx-1"><i class="far fa-trash-alt"></i></button>';
    return tools;
}

function type_status(data, type, row, meta){
    var checked = (data == 'on') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['DELIVERY_TYPE_ID'] + '" name="active_type" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function type_tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'     + data + '"';
        tools += ' name="edit_type" type="button" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button type="button" name="remove_type"  data-id="' + data + '" class="btn btn-danger mx-1">'
        tools += '<i class="far fa-trash-alt"></i></button>';
    return tools;
}