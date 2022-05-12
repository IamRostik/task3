<?php foreach ($users as $user): ?>
    <tr>
        <td class="align-middle">
            <div
                class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                <input type="checkbox" class="custom-control-input" id="item-<?=$user['id']?>" value="<?=$user['id']?>">
                <label class="custom-control-label" for="item-<?=$user['id']?>"></label>
            </div>
        </td>
        <td class="text-nowrap align-middle"><?=$user['first_name'] . PHP_EOL . $user['last_name']?></td>
        <td class="text-nowrap align-middle"><span><?=$user['role']?></span></td>
        <td class="text-center align-middle"><i class="fa fa-circle <?= $user['status'] ? 'active-circle' :  'not-active-circle'?>"></i></td>
        <td class="text-center align-middle">
            <div class="btn-group align-top">
                <button class="btn btn-sm btn-outline-secondary badge edit" type="button" data-toggle="modal" data-target="#add-edit" data-whatever="Edit" data-id="<?=$user['id']?>" data-firstname="<?=$user['first_name']?>" data-lastname="<?=$user['last_name']?>">Edit</button>
                <button class="btn btn-sm btn-outline-secondary badge delete" type="button" data-id="<?=$user['id']?>"><i class="fa fa-trash"></i></button>
            </div>
        </td>
    </tr>
<?php endforeach; ?>