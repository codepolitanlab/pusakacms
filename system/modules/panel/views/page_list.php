<?php if(! empty($pages)):
	foreach($pages as $uri => $content):
		if($uri != '_title'): ?>
    <li data-title="<?php echo $content['_title']; ?>" data-url="<?php echo $uri; ?>" class="dd-item dd3-item" id="page">
        <div class="dd-handle dd3-handle" title="klik and drag to rearrange"><span class="fa fa-align-justify" style="color:#aaa;line-height:27px;"></span></div>
        <div class="dd3-content">
            <?php echo $content['_title']; ?>
            <small><a href="<?php echo site_url($uri); ?>" target="_blank"><?php echo $uri; ?></a></small>
            <div class="align-right pull-right">
                <div class="option">
                    <a href="<?php echo site_url('panel/pages/edit?page='.$uri); ?>" class="edit" title="Edit"><span class="fa fa-edit"></span></a>
					<a href="<?php echo site_url('panel/pages/create?parent='.$uri); ?>" class="add" title="Add Subpage"><span class="fa fa-plus"></span></a>
					<a href="<?php echo site_url('panel/pages/delete?page='.$uri); ?>" class="remove" title="Delete"><span class="fa fa-times"></span></a>
                </div>
            </div>
        </div>
        <?php if(count($content) > 1): ?>
            <ol class="dd-list">
				<?php echo Modules::run('panel/pages/_page_list', $content); ?>
            </ol>
		<?php endif; ?>
    </li>
<?php endif; endforeach; endif; ?>
