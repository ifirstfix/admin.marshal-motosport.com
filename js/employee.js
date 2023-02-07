$(function(){
    var dt_employee = $('#datatable_employee').DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/employee.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "employee";
            }
        },
        type: "JSON",
        columns: [
            { data: "EMPLOYEE_STATUS",  render: status},
            { data: "EMPLOYEE_USERNAME"},
            { data: "EMPLOYEE_EMAIL"},
            { data: "EMPLOYEE_LANGUAGEUSER", render: lang},
            { data: "EMPLOYEE_SYS_GROUPNAME", render: group},
            { data: "EMPLOYEE_ID", render: employee_tools}
        ],
        columnDefs: [
            { targets: "_all", defaultContent: "-"},
            { targets: [0,5,3,4], className: "text-center", width: "10%"}
        ]
    });
    
    $('#datatable_employee').on('click', '[name="edit_employee"]', function(e){
        var data = $(e.currentTarget).data();
        $('#edit_e_username').val(data.username);
        $('#edit_e_name').val(data.fullName);
        $('input[name=edit_e_language]').attr("checked", false);
        $('input[name=edit_e_language][value=' + data.lang + ']').attr("checked", true);
        $('#edit_e_email').val(data.email);

        $("#edit_e_group option").each(function () {
            if($(this).val() == data.group){
                $(this).attr("selected","selected");
            } else {
                $(this).removeAttr("selected");
            }
        });

        /* STATUS */
        var statusHTML_enable = '';
        statusHTML_enable += '<span class="avatar me-3 badge bg-success"></span>';
        statusHTML_enable += '<div><div class="font-weight-medium">Enable</div></div>';

        var statusHTML_disable = '';
        statusHTML_disable += '<span class="avatar me-3 badge bg-danger"></span>';
        statusHTML_disable += '<div><div class="font-weight-medium">Disable</div></div>';

        if(data.status == true){
            $('input[name=edit_e_status]').attr("checked", true);
            $('#edit_text_status').html(statusHTML_enable);
        }else{
            $('input[name=edit_e_status]').attr("checked", false);
            $('#edit_text_status').html(statusHTML_disable);
        }

        $('input[name=edit_e_status]').on('change', function() {
            if(this.checked) {
                $('#edit_text_status').html(statusHTML_enable);
            }else{
                $('#edit_text_status').html(statusHTML_disable);
            }
        });
        /* STATUS */

        $('#edit_e_id').val(data.empId);
        $('#modal_edit').modal('show');
    });

    $('#modal_remove').on('click', '.btn-confirm-del', function(){
        $.ajax({
            type: "post",
            url: BASE_LANG + "service/employee.php",
            data: {
                "cmd": "remove_employee",
                "emp_id": $(this).data('empId')
            },
            dataType: "json",
            success: function (res) {
                var msg = res['msg'];
                if (res['status']) {
                    alert_center('Remove employee', msg, "success")
                    dt_employee.ajax.reload();
                }else{
                    alert_center('Remove employee', msg, "error")
                }
            }
        });
    });
    
    $("#modal_add").on("hidden.bs.modal", function () {
        $('#frm_add_employee')[0].reset();
        $('#frm_add_employee').find('.is-invalid').removeClass("is-invalid");
        $('#frm_add_employee').find('.is-valid').removeClass("is-valid");
    });

    $("#modal_edit").on("hidden.bs.modal", function () {
        $('#frm_edit_employee')[0].reset();
        $('#frm_edit_employee').find('.is-invalid').removeClass("is-invalid");
        $('#frm_edit_employee').find('.is-valid').removeClass("is-valid");
    });

    $('#modal_remove').on('show.bs.modal', function(e) {
        var data = $(e.relatedTarget).data();
        $('.title', this).text(data.userName);
        $('.btn-confirm-del', this).data('empId', data.empId);
    });

    $('#frm_add_employee').validate({
        rules: {
            add_emp_username: {
                required: true
            },
            add_emp_username: {
                required: true
            },
            add_emp_email: {
                required: true
            },
            add_emp_group: {
                required: true
            }
        },
        errorPlacement: function(error,element) {
            return true;
        },
        errorClass: "text-danger",
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
            $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "add_employee");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/employee.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    var status = res['status'];
                    var msg = res['msg'];
                    if (status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Add employee', msg, "success")
                        dt_employee.ajax.reload();
                    } else {
                        alert_center('Add employee', msg, "error")
                    }
                }
            });
        }
    });

    $('#frm_edit_employee').validate({
        rules: {
            edit_e_username: {
                required: true
            },
            edit_e_username: {
                required: true
            },
            edit_e_email: {
                required: true
            },
            edit_e_group: {
                required: true
            }
        },
        errorPlacement: function(error,element) {
            return true;
        },
        errorClass: "text-danger",
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
            $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "update_employee");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/employee.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    var status = res['status'];
                    var msg = res['msg'];
                    if (status == true) {
                        $('#modal_edit').modal('hide');
                        alert_center('Update employee', msg, "success")
                        dt_employee.ajax.reload();
                    } else {
                        alert_center('Update employee', msg, "error")
                    }
                }
            });
        }
    });

})

function status(data, type, row) {
    var status = (data == 'true') ? 'success' : 'danger';
    return '<div class="badge bg-' + status + '"></div>';
}

function lang(data, type, row) {
    return '<span class="flag flag-country-' + data + '"></span> ';
}

function group(data, type, row) {
    return '<span class="badge bg-yellow-lt w-100">' + row['GROUP_NAME'] + '</span>';
}

function employee_tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-emp-id = "' + data + '"';
        tools += ' data-username = "' + row['EMPLOYEE_USERNAME'] + '"';
        tools += ' data-email = "' + row['EMPLOYEE_EMAIL'] + '"';
        tools += ' data-lang = "'  + row['EMPLOYEE_LANGUAGEUSER'] + '"';
        tools += ' data-group = "' + row['EMPLOYEE_SYS_GROUPNAME'] + '"';
        tools += ' data-status = "' + row['EMPLOYEE_STATUS'] + '"';
        tools += ' name="edit_employee" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button name="remove_employee" data-user-name = "' + row['EMPLOYEE_USERNAME'];
        tools += '" data-emp-id="' + data + '" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#modal_remove">'
        tools += '<i class="far fa-trash-alt"></i></button>';
    return tools
}