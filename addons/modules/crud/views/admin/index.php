<div class="row heading">
    <div class="col-md-6">
        <h1>AutoCRUD</h1>
    </div>
    <div class="col-md-6 align-right">
         <div>
             <a class="btn btn-md btn-transparent" href="<?php echo site_url('panel/crud/create'); ?>"><span class="fa fa-plus-circle"></span> Create new CRUD</a>
         </div>
    </div>
</div>

<?php if($crud): ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama CRUD</th>
            <th>Slug</th>
            <th>Deskripsi</th>
            <th>Tabel</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        <?php $i = 0; foreach ($crud as $c): $i++; ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $c->title; ?></td>
            <td><?php echo $c->slug; ?></td>
            <td><?php echo $c->description; ?></td>
            <td><?php echo $c->main_table; ?></td>
            <td>
                <a href="<?php echo site_url('panel/crud/list/'.$c->slug); ?>" class="btn btn-xs">View </a>
            </td>
        </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>

<?php endif; ?>