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
        modal.find('#firstname').val('');
        modal.find('#lastname').val('');
    }
    if (recipient === 'Edit'){
        let id = button.data('id'),
            firstname = button.data('firstname'),
            lastname = button.data('lastname');
        modal.find('#firstname').val(firstname);
        modal.find('#lastname').val(lastname);
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
        beforeSuccess: $('tbody').fadeOut(300),
        success: function (res) {
            $('tbody').html(res).fadeIn(300)
            $('.modal').modal('hide')
            $('#all-items').prop('checked', false)
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
        beforeSuccess: $('tbody').fadeOut(300),
        success: function (res) {
            $('tbody').html(res).fadeIn(300)
            $('#all-items').prop('checked', false)
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
    let res = $(this).parents('.col-sm-4').find('option').filter(':selected').val()
    if (!data){
        $('#alert').modal('show');
        $('#alert .modal-body').text('Не вибрані юзери!');
        return false;
    }
    if (res === 'default'){
        $('#alert').modal('show');
        $('#alert .modal-body').text('Треба вибрати один із варіантів!');
        return false;
    }
    if (res === 'del'){
        let agree = confirm('Are you sure?');
        if (!agree) return false;
    }

    data = data.slice(0,-1);
    let new_url = '';
    if (res === 'del') {
        new_url = url + '?type=del';
    } else {
        new_url = url + '?type=edit';
    }

        $.ajax({
            url: new_url,
            type: 'GET',
            data: {id: data, res: res},
            beforeSuccess: $('tbody').fadeOut(300),
            success: function (res) {
                $('tbody').html(res).fadeIn(300)
                $('#all-items').prop('checked', false)
            }
        })
})
