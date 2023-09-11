<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('dist/frontend/module/tour/css/tour.css?_ver='.config('app.asset_version'))); ?>"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css")); ?>"/>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="bravo_faqs">
        <div class="main-form">
            <div class="container">
                <form action="<?php echo e(route('faq.search')); ?>"
                      class="d-flex form-search justify-content-center  position-relative mb-1">
                    <input class="form-control" type="text" name="s" value="<?php echo e(request()->input('s')); ?>"
                           placeholder="<?php echo e(__("Search For")); ?>">
                    <button type="submit" class="btn btn-primary position-absolute"><?php echo e(__("Search")); ?></button>
                </form>
                <div class="list-category d-flex">
                    <div class="item <?php echo e(!request()->has('cat_id') ? "active":""); ?>">
                        <a class="btn btn-primary " href="<?php echo e(route('faq.search')); ?>">
                            All
                        </a>
                    </div>
                    <?php
                    $current_category_ids = Request::query('cat_id');
                    $traverse = function ($categories, $prefix = '') use (&$traverse, $current_category_ids) {
                    $i = 0;
                    foreach ($categories as $category) {
                    $checked = '';
                    if (!empty($current_category_ids)) {
                        foreach ($current_category_ids as $key => $current) {
                            if ($current == $category->id)
                                $checked = 'active';
                        }
                    }
                    $traslate = $category->translateOrOrigin(app()->getLocale())
                    ?>
                    <div class="item <?php echo e($checked); ?>">
                        <a class="btn btn-primary" href="<?php echo e(route('faq.search',['cat_id[]'=>$category->id])); ?>">
                            <?php echo e($prefix); ?> <?php echo e($traslate->name); ?>

                        </a>
                    </div>
                    <?php
                    $i++;
                    $traverse($category->children, $prefix . '-');
                    }
                    };
                    $traverse($faq_category);
                    ?>
                </div>
            </div>
        </div>
        <div class="box-content">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white border d-flex flex-row justify-content-between p-3">
                            <div class="title">
                                <?php echo e($title_page); ?>

                            </div>
                            <div class="text-secondary">
                                <?php echo e($rows->total()); ?> FAQs Found
                            </div>
                        </div>
                        <div class="box-list">
                            <div id="accordion" class="lits-accordion">
                                <?php if($rows->total() > 0): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php  $translation = $row->translateOrOrigin(app()->getLocale()); ?>
                                        <div class="card">
                                            <div class="card-header collapsed" id="headingOne_<?php echo e($row->id); ?>"
                                                 data-toggle="collapse" data-target="#collapseOne_<?php echo e($row->id); ?>"
                                                 aria-expanded="true" aria-controls="collapseOne_<?php echo e($row->id); ?>">
                                                <?php echo e($translation->title); ?>

                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.33301 7.5L9.99967 14.1667L16.6663 7.5"
                                                          stroke-width="2.33333" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div id="collapseOne_<?php echo e($row->id); ?>" class="collapse"
                                                 aria-labelledby="headingOne_<?php echo e($row->id); ?>" data-parent="#accordion">
                                                <div class="card-body">
                                                    <?php echo $translation->content; ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php echo e(__("Faq not found")); ?>

                                <?php endif; ?>
                            </div>
                            <div class="bravo-pagination mb-2 mt-5">
                                <?php echo e($rows->appends(request()->query())->links()); ?>

                                <?php if($rows->total() > 0): ?>
                                    <span
                                        class="count-string"><?php echo e(__("Showing :from - :to of :total Faqs",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()])); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script type="text/javascript" src="<?php echo e(asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js")); ?>"></script>
    <script type="text/javascript"
            src="<?php echo e(asset('module/tour/js/tour.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Faq/Views/frontend/search.blade.php ENDPATH**/ ?>