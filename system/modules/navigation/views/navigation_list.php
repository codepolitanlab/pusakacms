<?php foreach ($links as $link): ?>
    <li data-title="<?php echo $link['title']; ?>" data-slug="<?php echo $link['slug']; ?>" data-url="<?php echo $link['url']; ?>" data-source="<?php echo $link['source']; ?>" data-target="<?php echo $link['target']; ?>" class="dd-item dd3-item">
        <div class="dd-handle dd3-handle" title="klik and drag to rearrange"><span class="fa fa-align-justify" style="color:#aaa;line-height:27px;"></span></div>
        <div class="dd3-content">
            <?php echo $link['title']; ?>
            <small>(<?php echo $link['slug']; ?>)</small>
            <small><a href="<?php echo ($link['source'] == 'uri') ? site_url($link['url']) : $link['source'].$link['url']; ?>" target="_blank"><?php echo $link['url']; ?></a></small>
            <div class="align-right pull-right">
                <div class="option">
                    <a href="#" class="edit" data-mode="edit" data-toggle="modal" data-target="#linkModal" data-area="<?php echo $area; ?>" data-title="<?php echo $link['title']; ?>" data-slug="<?php echo $link['slug']; ?>" data-source="<?php echo $link['source']; ?>" data-url="<?php echo $link['url']; ?>" data-linktarget="<?php echo $link['target']; ?>"><span class="fa fa-edit"></span> Edit</a>
                    <a href="<?php echo site_url('panel/navigation/delete_link/'.$area.'/'.$link['slug']); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
                </div>
            </div>
        </div>
        <?php if(isset($link['children'])): ?>
            <ol class="dd-list">
                <?php echo Modules::run('panel/navigation/navigation_list', $area, $link['children']); ?>
            </ol>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
