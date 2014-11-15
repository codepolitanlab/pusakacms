<ul class="navlist">
    <?php foreach ($links as $link): ?>
        <li>
            <div class="link">
                <div><span class="fa fa-align-justify" style="color:#aaa;line-height:27px;"></span></div>
                <div><?php echo $link['title']; ?></div>
                <div><a href="<?php echo ($link['source'] == 'uri') ? site_url($link['url']) : $link['source'].$link['url']; ?>" target="_blank"><?php echo $link['url']; ?></a></div>
                <div class="align-right pull-right">
                    <div class="option">
                        <a href="#" class="add" data-toggle="modal" data-target="#linkModal" data-area="<?php echo $area; ?>" data-title="<?php echo $link['title']; ?>" data-source="<?php echo $link['source']; ?>" data-url="<?php echo $link['url']; ?>" data-linktarget="<?php echo $link['target']; ?>"><span class="fa fa-link"></span> Add Sublink</a>
                        <a href="#" class="edit" data-mode="edit" data-toggle="modal" data-target="#linkModal" data-area="<?php echo $area; ?>" data-title="<?php echo $link['title']; ?>" data-source="<?php echo $link['source']; ?>" data-url="<?php echo $link['url']; ?>" data-linktarget="<?php echo $link['target']; ?>"><span class="fa fa-edit"></span> Edit</a>
                        <a href="<?php echo site_url('panel/navigation/delete_link/'.$area.'/'.urlencode($link['title'])); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
                    </div>
                </div>
            </div>
            <?php if(isset($link['children'])): ?>
            <div class="children">
                <?php echo Modules::run('panel/navigation/navigation_list', $area, $link['children']); ?>
            </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>