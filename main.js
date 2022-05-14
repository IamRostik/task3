let url = location.protocol + '//' + location.hostname + location.pathname.replace(/\/$/, '');
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
    let button = $(event.relatedTarget), // Button that triggered the modal
        recipient = button.data('whatever'); // Extract info from data-* attributes
    let modal = $(this)
    if (recipient === 'Add'){
        modal.find('.submit').removeAttr('value');
        modal.find('#name_first').val('');
        modal.find('#name_last').val('');
    }
    if (recipient === 'Edit'){
        let id = button.data('id'),
            name_first = button.data('namefirst'),
            name_last = button.data('namelast');
        modal.find('#name_first').val(name_first);
        modal.find('#name_last').val(name_last);
        modal.find('.submit').attr('value',() => id);
    }
    modal.find('.modal-title').text(recipient + ' user')
})

$('#add-edit button:submit').click(function (e) {
    e.preventDefault();

    let id = $(this).val(),
        new_url = ''
    console.log(id)
    if (id) {
        new_url = url + '?type=edit&id=' + id;
    } else {
        new_url = url + '?type=add'
    }
    $.ajax({
        url: new_url,
        type: 'POST',
        data: $('.form').serialize(),
        success: function (res) {
            res = JSON.parse(res)
            console.log(res)
            if (res.error !== null){
                $('.modal').modal('hide')
                $('#alert').modal('show');
                $('#alert .modal-body').html(res.error.message);
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

    let agree = confirm('Are you sure?');
    if (!agree) return false;

    const id = $(this).data('id');
    $.ajax({
        url: url + '?type=del',
        type: 'GET',
        data: {id: id},
        success: function (res) {
            res = JSON.parse(res)
            console.log(res)
            deleteUser(res)
        }
    })
})

// Меню під і над таблицею
$('body').on('click', '.ok-button',function () {

    let data = '',
        checked = $('.align-middle input:checked');
        checked.each(function () {
            data += this.value + ',';
        })
    let act = $(this).parents('.col-sm-4').find('option').filter(':selected').val()
    if (!data){
        $('#alert').modal('show');
        $('#alert .modal-body').text('Не вибрані юзери!');
        return false;
    }
    if (act === 'default'){
        $('#alert').modal('show');
        $('#alert .modal-body').text('Треба вибрати один із варіантів!');
        return false;
    }
    if (act === 'del'){
        let agree = confirm('Are you sure?');
        if (!agree) return false;
    }

    data = data.slice(0,-1);
    let new_url = '';
    if (act === 'del') {
        new_url = url + '?type=del';
    } else {
        new_url = url + '?type=edit';
    }

        $.ajax({
            url: new_url,
            type: 'GET',
            data: {id: data, act: act},
            success: function (res) {
                res = JSON.parse(res);
                console.log(res)
                if (act === 'del') {
                    deleteUser(res)
                } else {
                    editStatusUsers(res)
                }
            }
        })
})



function addUser(res) {
    const
        id = res.user.id,

        status = res.user['status'] !== '0' ? 'active-circle' : 'not-active-circle',
        name_first = res.user['name_first'],
        name_last = res.user['name_last'],
        role = res.user.role;

   const el = "<tr id=\"tr-"+id+"\"><td class=\"align-middle\"><div class=\"custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top\"><input type=\"checkbox\" class=\"custom-control-input\" id=\"item-"+id+"\" value=\""+id+"\"><label class=\"custom-control-label\" for=\"item-"+id+"\"></label></div></td><td class=\"text-nowrap align-middle name\">"+name_first+"\n"+name_last+"</td><td class=\"text-nowrap align-middle\"><span class=\"role\">"+role+"</span></td><td class=\"text-center align-middle\"><i class=\"status fa fa-circle "+status+"\"></i></td><td class=\"text-center align-middle\"><div class=\"btn-group align-top\"><button class=\"btn btn-sm btn-outline-secondary badge edit\" type=\"button\" data-toggle=\"modal\" data-target=\"#add-edit\" data-whatever=\"Edit\" data-id=\""+id+"\" data-namefirst=\""+name_first+"\" data-namelast=\""+name_last+"\">Edit</button><button class=\"btn btn-sm btn-outline-secondary badge delete\" type=\"button\" data-id=\""+id+"\"><i class=\"fa fa-trash\"></i></button></div></td></tr>"

        $('tbody').append(el);
}

function editUser(res) {
    const
        id = res.user.id,
        el = $('tr[id=tr-'+id+']'),
        status = res.user['status'] !== '0' ? 'active-circle' : 'not-active-circle',
        name_first = res.user['name_first'],
        name_last = res.user['name_last'],
        role = res.user.role;

    el.find('.role').text(role)
    el.find('.name').text(name_first+"\n"+name_last)
    el.find('.status').attr('class', 'status fa fa-circle '+status)

}

function editStatusUsers(res){
    const id = res.user['id'],
        status = res.user['status'] !== '0' ? 'active-circle' : 'not-active-circle';
    for (const value of id){
        $('tr[id=tr-'+value+']').find('.status').attr('class', 'status fa fa-circle '+status);
    }
}

function deleteUser(res) {
    const id = res['id'];
    for (const value of id){
        $('tr[id=tr-'+value+']').remove()
    }
}
