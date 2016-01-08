<div class="row heading">
    <div class="col-md-6">
        <h1><?php echo $crud->title ?></h1>
    </div>
    <div class="col-md-6 align-right">
        <div>
            <a class="btn btn-md btn-transparent" href="<?php echo site_url('panel/crud/list/'.$crud->slug.'/create'); ?>"><span class="fa fa-plus-circle"></span> Create new site</a>
        </div>
    </div>
</div>

<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <?php foreach ($crud->show_fields as $field): ?>
            <th><?php echo ucwords(str_replace("_", " ", $field)); ?></th>
            <?php endforeach; ?>
            <th width="20%"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php if($data): ?>
        <?php $i = 0; foreach ($data as $d): $i++; ?>
        <tr>
            <td><?php echo $i; ?></td>
            <?php foreach ($crud->show_fields as $field): ?>
            <td><?php echo $d->{$field}; ?></td>
            <?php endforeach; ?>
            <td class="text-right">
                <a href="<?php echo site_url('panel/crud/data/'.$d->ID); ?>" class="btn btn-info btn-xs">View</a>
                <a href="<?php echo site_url('panel/crud/data_edit/'.$d->ID); ?>" class="btn btn-default btn-xs">Edit</a>
                <a href="<?php echo site_url('panel/crud/data_delete/'.$d->ID); ?>" class="btn btn-warning btn-xs">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        
    </tbody>
</table>