<div class=" bravo-form-search-all" style="background-image: linear-gradient(0deg,rgba(0, 0, 0, 0.2),rgba(0, 0, 0, 0.2)),url('<?php echo e($bg_image); ?>') !important">
    <div class="container" style="height: 300px;">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-heading text-center"><?php echo e($title); ?></h1>
                <br>
                <div class="text-center bg_template_action">
                    <div class="text-left d-inline-block">
                        <p><?php echo e($sub_title); ?></p>
                        <?php $__currentLoopData = $list_slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($item['link']); ?>">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                                <?php echo e($item['title'] ?? ""); ?>

                                <i class="icofont-rounded-right"></i>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .bg_template_action p{
        color: #FFF;
        margin: 0 10px 15px ;
    }
    .bg_template_action a{
        background: #FFF;
        color: #0070C1;
        font-weight: 400;
        font-size: 20px;
        text-transform: capitalize;
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        margin: 10px;
    }
</style>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/modules/Template/Views/frontend/blocks/background-with-action.blade.php ENDPATH**/ ?>