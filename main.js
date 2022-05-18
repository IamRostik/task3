let url_func = location.protocol + '//' + location.hostname + '/php/MainFunc.php';
// Груповий чекбокс
$('#all-items').click(function () {
    const checkboxes = $(".align-middle input:checkbox");
    if ($(this).prop('checked')) checkboxes.prop('checked', true);
    if (!$(this).prop('checked')) checkboxes.prop('checked', false);
})

$('body').on('click','.align-middle input:checkbox',function () {
        if ($(".align-middle input:checkbox:not(:checked)").length){
            $('#all-items').prop('checked', false)
        } else {
            $('#all-items').prop('checked', true)
        }
})
// Додавання та редагування юзерів

$('#add-edit').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget), // Button that triggered the modal
        recipient = button.data('whatever'); // Extract info from data-* attributes
    const modal = $(this)
    if (recipient === 'Add'){
        $('.submit').val('');
        $('.form').trigger('reset');
    }
    if (recipient === 'Edit'){
        const
            id = button.data('id');
            $.ajax({
            url: url_func + '/get_one_user?type=get_user',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (res) {
                $('#add-edit #name_first').val(res.user['name_first']);
                $('#add-edit #name_last').val(res.user['name_last']);
                if (res.user['status'] === '1') $('#add-edit #change-status').prop('checked', true);
                if (res.user['status'] === '0') $('#add-edit #change-status').prop('checked', false);
                $('#add-edit option[value='+res.user['role']+']').prop('selected',true);
            }
        })
        $('.submit').val(id);
    }
    modal.find('.modal-title').text(recipient + ' user')
})

$('#add-edit button:submit').click(function (e) {
    e.preventDefault();

    let id = $(this).val(),
        new_url = ''
    if (id) {
        new_url = url_func + '/edit_user?type=edit_one&id='+id;
    } else {
        new_url = url_func + '/add_user?type=add';
    }
    $.ajax({
        url: new_url,
        type: 'POST',
        data: $('.form').serialize(),
        dataType: 'json',
        success: function (res) {
            if (res.error !== null){
                $('#add-edit').modal('hide')
                $('#alert .modal-body').html(res.error.message);
                $('#alert').modal('show');
                return false;
            }
            if (id){
                editUser(res)
            } else {
                addUser(res)
                $('#all-items').prop('checked', false)
            }
            $('.modal').modal('hide')

        }
    })
})

// Кнопка видалення юзерів
$('body').on('click', '.delete',function () {
    const id = $(this).data('id');
        modalConfirm(function (bool) {
            if (bool){
                $.ajax({
                    url: url_func + '/delete_user?type=del',
                    type: 'POST',
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        deleteUser(res)
                        $('#confirm').modal('hide');
                    }
                })
            }
        },id)
})

// Меню під і над таблицею
$('body').on('click', '.ok-button',function () {

    let data = '',
        checked = $('.align-middle input:checked');
        checked.each(function () {
            data += this.value + ',';
        })
    let act = $(this).parents('.col-sm-4').find('option:selected').val()
    if (!data){
        $('#alert .modal-body').text('Not selected users!');
        $('#alert').modal('show');
        return false;
    }
    data = data.slice(0,-1);
    let new_url = '';
    switch (act){

        case 'default':
        $('#alert .modal-body').text('Choose an action!');
        $('#alert').modal('show');

        return false;

        case 'del':
        new_url = url_func + '/delete_user?type=del';
        modalConfirm(function (bool) {
            if (bool){
                $.ajax({
                    url: new_url,
                    type: 'POST',
                    data: {id: data, act: act},
                    dataType: 'json',
                    success: function (res) {
                        deleteUser(res)
                        $('#confirm').modal('hide');
                    }
                })
            }
        })
        break;

        default:
        new_url = url_func + '/edit_status_users?type=edit_some';
        $.ajax({
            url: new_url,
            type: 'POST',
            data: {id: data, act: act},
            dataType: 'json',
            success: function (res) {
                editStatusUsers(res)
            }
        })
        break;
    }
})

function modalConfirm (callback,id = null){
    if (id !== null){
        const name = $('tr[id=tr-'+id+'] .name').text();
        $('#confirm .modal-body').html('Are you sure you want to delete '+name+'?')
    } else {
        $('#confirm .modal-body').html('Are you sure you want to delete selected users?')
    }

    $('#confirm').modal('show');

    $('#modal-btn-yes').click(function () {
        callback(true);
    })

    $('#modal-btn-no').click(function () {
        callback(false);
        $('#confirm').modal('hide');
    })
}


function addUser(res) {
    const
        id = res.user.id,
        status = res.user['status'] !== '0' ? 'active-circle' : '',
        name_first = res.user['name_first'],
        name_last = res.user['name_last'],
        role = res.user.role;

   const el = "<tr id=\"tr-"+id+"\"><td class=\"align-middle\"><div class=\"custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top\"><input type=\"checkbox\" class=\"custom-control-input\" id=\"item-"+id+"\" value=\""+id+"\"><label class=\"custom-control-label\" for=\"item-"+id+"\"></label></div></td><td class=\"text-nowrap align-middle name\">"+name_first+"\n"+name_last+"</td><td class=\"text-nowrap align-middle\"><span class=\"role\">"+role+"</span></td><td class=\"text-center align-middle\"><i class=\"status fa fa-circle not-active-circle "+status+"\"></i></td><td class=\"text-center align-middle\"><div class=\"btn-group align-top\"><button class=\"btn btn-sm btn-outline-secondary badge edit\" type=\"button\" data-toggle=\"modal\" data-target=\"#add-edit\" data-whatever=\"Edit\" data-id=\""+id+"\" data-namefirst=\""+name_first+"\" data-namelast=\""+name_last+"\">Edit</button><button class=\"btn btn-sm btn-outline-secondary badge delete\" type=\"button\" data-id=\""+id+"\"><i class=\"fa fa-trash\"></i></button></div></td></tr>"

        $('tbody').append(el);
}

function editUser(res) {
    const
        id = res.user.id,
        el = $('tr[id=tr-'+id+']'),
        status = res.user['status'] !== '0' ? 'active-circle' : '',
        name_first = res.user['name_first'],
        name_last = res.user['name_last'],
        role = res.user.role;

    el.find('.role').text(role)
    el.find('.name').text(name_first+"\n"+name_last)
    el.find('.status').removeClass('active-circle').addClass(status)

}

function editStatusUsers(res){
    const id = res.user['id'],
        status = res.user['status'] !== '0' ? 'active-circle' : '';
    for (const value of id){
        $('tr[id=tr-'+value+'] .status').removeClass('active-circle').addClass(status);
    }

    $('.table input:checked').prop('checked', false);
}

function deleteUser(res) {
    const id = res['id'];
    for (const value of id){
        $('tr[id=tr-'+value+']').remove()
    }
}
