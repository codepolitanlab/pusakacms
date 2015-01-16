<div class="row heading">
    <div class="col-md-6">
        <h1>SITES</h1>
    </div>
    <div class="col-md-6 align-right">
        <div>
            <a class="btn btn-md btn-transparent" href="{{ func.site_url }}site/create"><span class="fa fa-plus-circle"></span> Create new site</a>
        </div>
    </div>
</div>

<?php if(!empty($sites)): ?>
    <ul class="content-list nav">
        <?php foreach ($sites as $site => $detail): ?>
            <li>
                <div class="list-desc">
                    <h3><a href="<?php echo site_url('site/detail/'.$site); ?>"><?php echo $detail['site_name']; ?></a></h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <small>

                                <!-- show local link -->
                                <?php if($_SERVER['HTTP_HOST'] == $this->config->item('localhost_domain')): ?>

                                    <a href="<?php echo base_url($site); ?>" target="_blank">
                                        <span class="fa fa-external-link"></span>
                                        <?php echo base_url($site); ?>
                                    </a>
                                    &nbsp; &nbsp; &nbsp; 

                                <?php endif; ?>
                                
                                <!-- show online link -->
                                <?php if(isset($detail['site_domain']) 
                                    && ! empty($detail['site_domain'])):

                                    if(! $this->config->item('subsite_domain')): ?>

                                        <a href="<?php echo $detail['protocol']."://".$detail['site_domain']; ?>" target="_blank">
                                            <span class="fa fa-external-link"></span>
                                            <?php echo $detail['site_domain']; ?>
                                        </a>

                                    <?php else: ?>

                                        <a href="<?php echo $detail['protocol']."://".$this->config->item('subsite_domain').'/'.$site; ?>" target="_blank">
                                            <span class="fa fa-external-link"></span>
                                            <?php echo $this->config->item('subsite_domain').'/'.$site; ?>
                                        </a>

                                    <?php endif; ?>


                                <?php else: ?>
                                    
                                    <div>
                                    <span class="fa fa-warning"></span>
                                    'site_domain' settings in this site detail not configured properly.
                                    </div>

                                <?php endif; ?>
                            </small>
                        </div>
                        <div class="col-md-6 align-right">
                            <div class="option">
                                <a href="<?php echo site_url('site/edit/'.$site); ?>" class="edit"><span class="fa fa-edit"></span> Edit</a>
                                <?php if($site != SITE_SLUG): ?>
                                <a href="<?php echo site_url('site/delete/'.$site); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
