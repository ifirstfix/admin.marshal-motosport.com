$(function() {
    var edit_toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'align': [] }],
        [{ 'color': [] }, { 'background': [] }],   
        ['clean']
    ];

    var edit_quill_th = new Quill('#edit_product_detail_th', {
        theme: 'snow',
        placeholder: 'Detail TH...',
        modules: {
            toolbar: edit_toolbarOptions
        }
    });

    var edit_quill_en = new Quill('#edit_product_detail_en', {
        theme: 'snow',
        placeholder: 'Detail EN...',
        modules: {
            toolbar: edit_toolbarOptions
        }
    });

    datatable(edit_quill_th, edit_quill_en);

    var toolbarOptions = [
		[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
		['bold', 'italic', 'underline', 'strike'],
		[{ 'align': [] }],
		[{ 'color': [] }, { 'background': [] }],   
		['clean']
	];

	var quill_th = new Quill('#add_product_detail_th', {
		theme: 'snow',
		placeholder: 'Detail TH...',
		modules: {
			toolbar: toolbarOptions
		}
	});

    var quill_en = new Quill('#add_product_detail_en', {
		theme: 'snow',
		placeholder: 'Detail EN...',
		modules: {
			toolbar: toolbarOptions
		}
	});

    $("[name='add_product_img[]']").on('change', function(){
        var file = this.files[0];
        var reader = new FileReader();
        var img_id = $(this).data('img');
        reader.onloadend = function () {
            $('img#show_product_img_' + img_id).attr('src', reader.result);
        }
        if (file) {
            reader.readAsDataURL(file);
        } else {
            return false;
        }
    });

    $("#frm_add_product").validate({
        ignore: ".quill *",
        rules: {
            add_product_type: {
              required: true
            },
            add_product_name_th : {
              required: true
            },
            add_product_name_en : {
              required: true
            },
            add_product_price : {
                required: true,
                numberOnly: true
            },
            add_product_stock : {
                required: true,
                number: true
            },
            add_product_price_sale : {
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

            data.append("cmd", "add_product");
            data.append("add_product_detail_th", quill_th.root.innerHTML);
            data.append("add_product_detail_en", quill_en.root.innerHTML);
            data.append("add_product_price_sale", $('#add_product_price_sale').val());
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/product.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add', res.msg, "success")
                        dtb_product.ajax.reload();
                    } else {
                        alert_center('Process update', res.msg, "error")
                    }
                }
            });
        } 
    });

    $("#frm_edit_product").validate({
        ignore: ".quill *",
        rules: {
            edit_product_type: {
                required: true
            },
            edit_product_name_th : {
                required: true
            },
            edit_product_name_en : {
                required: true
            },
            edit_product_price : {
                required: true,
                numberOnly: true
            },
            edit_product_stock : {
                required: true,
                number: true
            },
            edit_product_price_sale : {
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
            data.append("cmd", "edit_product");
            data.append("edit_product_detail_th", edit_quill_th.root.innerHTML);
            data.append("edit_product_detail_en", edit_quill_en.root.innerHTML);
            // data.append("edit_product_price_sale", $('#edit_product_price_sale').val());
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/product.php",
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
                      dtb_product.ajax.reload();
                      $('#modal_edit').modal('hide');
                  }else{
                      alert_center('Process update', msg, "error")
                  }
                }
            });

        } 
    });

    $("#frm_type").validate({
        ignore: ".type-order",
        rules: {
            product_type_th: {
                required: true
            },
            product_type_en : {
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
            data.append("cmd", "add_product_type");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/product.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add', res.msg, "success")
                        tb_product_type.ajax.reload();
                    } else {
                        alert_center('Process add', res.msg, "error")
                    }
                }
            });

        } 
    });

    $("#modal_add").on("hidden.bs.modal", function () {
        $('#frm_add_product')[0].reset();
        $('#frm_add_product').find('.is-invalid').removeClass("is-invalid");
        $('#frm_add_product').find('.is-valid').removeClass("is-valid");
    });

    $("#modal_add_type").on("hidden.bs.modal", function () {
        $('#frm_type')[0].reset();
        $('#frm_type').find('.is-invalid').removeClass("is-invalid");
        $('#frm_type').find('.is-valid').removeClass("is-valid");
    });

    $("#modal_edit").on("hidden.bs.modal", function () {
        $("[name='edit_product_img[]']").val(null);
        $('#frm_edit_product').find('.is-invalid').removeClass("is-invalid");
        $('#frm_edit_product').find('.is-valid').removeClass("is-valid");
    });

    $('#btn_product_type').on('click', function(){
        $('#modal_add_type').modal('show');
        datatable_type();
    });

    $('#add_product_tag').on('change', function(){
        if(this.value == 'SALE'){
            $('#add_product_price_sale').removeClass('d-none');
        }else{
            $('#add_product_price_sale').addClass('d-none');
        }
    });
    $('#edit_product_tag').on('change', function(){
        if(this.value == 'SALE'){
            $('#edit_product_price_sale').removeClass('d-none');
        }else{
            $('#edit_product_price_sale').addClass('d-none');
        }
    });
});

function datatable(edit_quill_th, edit_quill_en){
    dtb_product = $("#dtb_product").DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/product.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "product";
            }
        },
        type: "JSON",
        columns: [
            { "data": "PRODUCT_ROWS", render: product_order},
            { "data": "PRODUCT_IMG", render: image},
            { "data": "PRODUCT_TAG", render: product_tag},
            { "data": "PRODUCT_NAME_TH"},
            { "data": "PRODUCT_TYPE_ID", render: product_type },
            { "data": "PRODUCT_PRICE" },
            { "data": "PRODUCT_PRICE_SALE" },
            { "data": "PRODUCT_STATUS", render : product_status},
            { "data": "CREATEDATETIME", render: datetime},
            { "data": "PRODUCT_ID", render: tools}
        ],
        columnDefs: [
            { targets: [0], className: "text-center", width: "10%" },
            { targets: [1], className: "text-center", width: "5%" },
            { targets: [2], className: "text-center", width: "5%" },
            { targets: [3, 4], className: "truncate-200", width: "20%" },
            { targets: [5,6,7,8, 9], className: "text-center", width: "10%" },
        ]
    });


    $('#dtb_product tbody').on( 'click', '[name="remove"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove"]').attr('data-id');

        // MODAL REMOVE COURSE
        var remove_modalText  = 'Do you really want to remove this product?';
        var modalID           = 'modal_removeGEN';
        var btn_remove_id     = 'submit_product';
        modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_remove');

        $('#' + btn_remove_id).on('click', function(){
          $.ajax({
              type: "post",
              url: BASE_LANG + "service/product.php",
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
                      dtb_product.ajax.reload();
                      $('#' + modalID).modal('hide');
                  }else{
                      alert_center('Process remove', msg, "error")
                  }
              }
          });
        });
    });

    $('#dtb_product tbody').on( 'click', '[name="active"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active"]').attr('data-id');
        var active  = (this.checked == true) ? 'on' : 'off';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/product.php",
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
                    dtb_product.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#dtb_product tbody').on( 'click', '[name="update"]', function (e) { 
        $('#modal_edit').modal('show');
        var data = $(e.currentTarget).data();
        $('#edit_product_name_th').val(data.nameTh);
        $('#edit_product_name_en').val(data.nameEn);
        $('#edit_product_price').val(data.price);
        $('#edit_product_id').val(data.id);
        $('#edit_product_type option[value="' + data.type + '"]').attr('selected', true);
        $('#edit_product_tag option[value="' + data.tag + '"]').attr('selected', true);
        $('#edit_product_stock').val(data.stock);
        $('#edit_product_price_sale').val(data.sale);

        $.each(JSON.parse(decode_quote(data.img)), function(k, v){
            $('#edit_show_product_img_' + (k + 1)).attr("src", BASE_URL + 'images/product/' + v['file_name']);
        })

        $("[name='edit_product_img[]']").on('change', function(){
            var file = this.files[0];
            var reader = new FileReader();
            var img_id = $(this).data('img');
            reader.onloadend = function () {
                $('img#edit_show_product_img_' + img_id).attr('src', reader.result);
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                return false;
            }
        });

        edit_quill_th.root.innerHTML = decode_quote(data.detailTh).replaceAll('div', 'p');
		edit_quill_en.root.innerHTML = decode_quote(data.detailEn).replaceAll('div', 'p');
    });

    $('#dtb_product tbody').on( 'click', '[name="product_img"]', function (e) {
        var row = $(this).closest("tr"); 
        var image_arr = JSON.parse(decode_quote(row.find('[name="product_img"]').attr('data-img')));
        var modal_imgHTML = '';
        modal_imgHTML += '<div class="modal modal-blur fade" id="modal_product_imageGEN">';
        modal_imgHTML += '<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">';
        modal_imgHTML += '<div class="modal-content">';
        modal_imgHTML += '<div class="modal-status bg-yellow"></div>';
        modal_imgHTML += '<div class="modal-header">';
        modal_imgHTML += '<h5 class="modal-title text-yellow">Product images</h5>';
        modal_imgHTML += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '<div class="modal-body">';
        modal_imgHTML += '<div class="row">';

        if(image_arr.length > 0){
            $.each(image_arr, function(k, v){
                var imagesProduct = BASE_URL + 'images/product/' + v['file_name'];
                if(k == 0){
                    modal_imgHTML += '<div class="col-12 mb-3">';
                    modal_imgHTML += '<img src="' + imagesProduct + '" class="w-100" style="max-height: 400px;object-fit: cover;">';
                    modal_imgHTML += '</div>';
                }else{
                    modal_imgHTML += '<div class="col-md-4 col-12">';
                    modal_imgHTML += '<img src="' + imagesProduct + '" class="w-100">';
                    modal_imgHTML += '</div>';
                }
            })
        }else{
                    modal_imgHTML += '<div class="col-12 mb-3">';
                    modal_imgHTML += '<img src="' + BASE_URL + 'images/no-image.jpg" class="w-100" style="max-height: 400px;object-fit: cover;">';
                    modal_imgHTML += '</div>';
        }
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '<div class="modal-footer">'
        modal_imgHTML += '<button class="btn btn btn-white" data-bs-dismiss="modal">Cancel</button>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        $('#modal_product_image').html(modal_imgHTML);
        $('#modal_product_imageGEN').modal('show');
    });

    $('#dtb_product tbody').on( 'change', '[name="product_order_row"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="product_order_row"]').attr('data-id');
        var order_value_old   = row.find('[name="product_order_row"]').attr('data-order');
        var order_value_new   = row.find('[name="product_order_row"]').val();

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/product.php",
            data: {
                "cmd": "update_product_order",
                "id": id,
                "order_value_old": order_value_old,
                "order_value_new": order_value_new
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
                    dtb_product.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

}

function datatable_type(){
    if ( $.fn.DataTable.isDataTable('#tb_product_type') ) {
        $('#tb_product_type').DataTable().destroy();
    }
    tb_product_type = $("#tb_product_type").DataTable({
        dom: '<"ms-3"B>rt<"d-flex justify-content-between"ip>',
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/product.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "product_type";
            }
        },
        type: "JSON",
        columns: [
            { "data": "PRODUCT_TYPE_ROWS", render : type_order},
            { "data": "PRODUCT_TYPE_NAME_TH"},
            { "data": "PRODUCT_TYPE_NAME_EN"},
            { "data": "PRODUCT_STATUS", render : type_status },
            { "data": "PRODUCT_TYPE_ID", render: type_tools}
        ],
        columnDefs: [
            { targets: 0, className: "text-center", width: "3%"},
            { targets: [1, 2], width: "30%", className: "truncate"},
            { targets: 3, className: "text-center", width: "10%"},
            { targets: 4, className: "text-center", width: "10%"},
        ]
    });

    $('#tb_product_type tbody').on( 'change', '[name="type_order_row"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="type_order_row"]').attr('data-id');
        var order_value_old   = row.find('[name="type_order_row"]').attr('data-type-order');
        var order_value_new   = row.find('[name="type_order_row"]').val();

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/product.php",
            data: {
                "cmd": "update_order",
                "id": id,
                "order_value_old": order_value_old,
                "order_value_new": order_value_new
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
                    tb_product_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#tb_product_type tbody').on( 'click', '[name="active_type"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active_type"]').attr('data-id');
        var active  = (this.checked == true) ? 'on' : 'off';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/product.php",
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
                    tb_product_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#tb_product_type tbody').on( 'click', '[name="remove_type"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove_type"]').attr('data-id');

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/product.php",
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
                    tb_product_type.ajax.reload();

                }else{
                    alert_center('Process remove', msg, "error")
                }
            }
        });

    });

    $('#tb_product_type tbody').on( 'click', '[name="edit_type"]', function (e) {
        $(this).children('.fa-save, .fa-edit').toggleClass("fa-save fa-edit");
        $(this).attr('name','edit_save');
        var row = $(this).closest("tr");
        var tds = row.find("td").not(':last');
        
        $.each(tds, function(i, el) {
            var txt = $(this).text();
            if(i != 0 && i != 3){
                $(this).html("").append("<input class='form-control-tb form-control-tb-sm' id=\""+i+"\" style='width: 100%;' type='text' value=\""+txt+"\">");
            } 
        });

    });

    $('#tb_product_type tbody').on( 'click', '[name="edit_save"]', function (e) {
        $(this).attr('name','edit_type');
        var cars = new Array();
        var row_save = $(this).closest("tr");
        var id   = row_save.find('[name="edit_type"]').attr('data-id');
        var tds_save  = row_save.find('td').not(':last');
        $.each(tds_save, function(i, el) {
            if(i != 0 && i != 3){
                var type_val = $(this).find("input").val()
            }
            cars.push(type_val); 
        });

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/product.php",
            data: {
                "cmd": "edit_type",
                "type_id" : id,
                "type_th": cars[1],
                "type_en": cars[2]
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
                    tb_product_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });  
}

function image(data, type, row, meta){
    if(JSON.parse(data).length != 0){
        var imagesUrl = BASE_URL + 'images/product/' + JSON.parse(data)[0]['file_name'];
    }else{
        var imagesUrl = BASE_URL + 'images/no-image.jpg';
    }
    
    var images = '';
    images += '<div class="col-auto">';
    images += ' <img name="product_img" src="' + imagesUrl + '" ';
    images += ' data-img="'  + encode_quote(data) + '"';
    images += ' class="rounded cursor-pointer" width="100%" >'
    images += '</div>';

    return images;
}

function product_status(data, type, row, meta){
    var checked = (data == 'on') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['PRODUCT_ID'] + '" name="active" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function product_type(data, type, row, meta){
    return row['PRODUCT_TYPE_NAME_TH'] + ' (' + row['PRODUCT_TYPE_NAME_EN'] + ')';
}

function product_order(data, type, row) {
    var typeHTML = '<select name="product_order_row" class="form-control w-100 text-center type-order" data-order="' + data + '" data-id="' + row['PRODUCT_ID'] + '">';
    for(var i = 1; i <= parseInt(row['max_order']); i++) {
        i = (row['PRODUCT_STATUS'] == 'on') ? i : '-'; 
        if(i == parseInt(data)) {
            typeHTML += '<option value="' + i + '" selected>' + i + '</option>';
        } else {
            typeHTML += '<option value="' + i + '">' + i + '</option>';
        }
    }
    typeHTML += '</select>';
    return typeHTML;
}

function product_tag(data, type, row) {
    var color_tag = '';
    if(data == 'NEW'){
        color_tag = 'success';
    }else if(data == 'PROMOTION'){
        color_tag = 'yellow';
    }else if(data == 'HOT'){
        color_tag = 'danger';
    }else if(data == 'SALE'){
        color_tag = 'info';
    }

    return '<a class="btn btn-' + color_tag + ' btn-square w-100 btn-sm">' + data + '</a>';
}

function datetime(data, type, row, meta){
    return moment(data).format('YYYY-MM-DD');
}

function tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'       + data + '"';
        tools += ' data-name-th = "'  + row['PRODUCT_NAME_TH'] + '"';
        tools += ' data-name-en = "'  + row['PRODUCT_NAME_EN'] + '"';
        tools += ' data-detail-th = "'  + encode_quote(row['PRODUCT_DETAIL_TH']) + '"';
        tools += ' data-detail-en = "'  + encode_quote(row['PRODUCT_DETAIL_EN']) + '"';
        tools += ' data-type = "'     + row['PRODUCT_TYPE_ID'] + '"';
        tools += ' data-price = "'    + row['PRODUCT_PRICE'] + '"';
        tools += ' data-img = "'      + encode_quote(row['PRODUCT_IMG']) + '"';
        tools += ' data-tag = "'      + row['PRODUCT_TAG'] + '"';
        tools += ' data-stock = "'    + row['PRODUCT_STOCK'] + '"';
        tools += ' data-sale = "'     + row['PRODUCT_PRICE_SALE'] + '"';
        tools += ' name="update" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button name="remove" data-id="' + data + '" class="btn btn-danger mx-1"><i class="far fa-trash-alt"></i></button>';
    return tools;
}

function type_status(data, type, row, meta){
    var checked = (data == 'on') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['PRODUCT_TYPE_ID'] + '" name="active_type" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function type_order(data, type, row) {
    var typeHTML = '<select name="type_order_row" class="form-control w-100 text-center type-order" data-type-order="' + data + '" data-id="' + row['PRODUCT_TYPE_ID'] + '">';
    for(var i = 1; i <= parseInt(row['max_order']); i++) {
        if(i == parseInt(data)) {
            typeHTML += '<option value="' + i + '" selected>' + i + '</option>';
        } else {
            typeHTML += '<option value="' + i + '">' + i + '</option>';
        }
    }
    typeHTML += '</select>';
    return typeHTML;
}

function type_tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'     + data + '"';
        tools += ' name="edit_type" type="button" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button type="button" name="remove_type"  data-id="' + data + '" class="btn btn-danger mx-1">'
        tools += '<i class="far fa-trash-alt"></i></button>';
    return tools;
}

