<?php $__env->startPush('css'); ?>
    <style>
        .bravo_footer{
            display: none!important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
 


 <br>
    <form style="background: #FAFAFA" action="<?php echo e(route('booking.extra.store',['code'=>$booking->code])); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="container pt-100 pb-100 main-container">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <div>
                    <h2 class="extra-title">Extras</h2>
                    <p class="extra-desc">Add a bit extra to make it special</p>
                </div>
                <div><a class="btn btn-sm btn-primary" href="/booking/<?php echo e($booking->code); ?>/checkout">Skip Extras</a></div>
            </div>

            <div class="row mb-3">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-3">
                        <div class="extra-item h-full">
                            <div class="text-center e-name mb-3 text-15"><?php echo e($row->title); ?></div>
                            <div class="d-flex justify-content-center mb-3">
                                <div class="e-img text-center" style="width: 70%">
                                    <div class="d-block">
                                        <?php echo get_image_tag($row->image_id); ?>

                                    </div>

                                    <a class="btn btn-primary rounded" data-toggle="collapse" data-target="#extra-price-<?php echo e($row->id); ?>">
                                        Add Me
                                    </a>
                                </div>
                                <div class="pl-3 ml-auto">

                                    <div class="extra_box mb-2">
                                        <div>
                                            <div class="text-15 mb-1">From</div>
                                            <div class="text-14 font-weight-bold">
                                                $<?php echo e(round($row->price, 0)); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="extra_box mb-2 blue">
                                        <div>
                                            <a href="#" class="video-url" data-url="<?php echo e(handleVideoUrl($row->video_url)); ?>">
                                                <div class="text-15 mb-1">Video</div>
                                               <i class="fa fa-video-camera text-20"></i>

                                            </a>
                                        </div>
                                    </div>

                                    <div class="extra_box mb-2 blue">
                                        <a href="#" data-toggle="collapse" data-target="#extra-<?php echo e($row->id); ?>">
                                            <div class="text-15">More</div>
                                            <div class="text-14 font-weight-bold">
                                                <img src="<?php echo e(asset('themes/jamrock/images/image20.png')); ?>" alt="">
                                            </div>
                                        </a>
                                    </div>


<!--                                    <div class="d-flex mb-3 d-flex justify-content-between">
                                        <a href="#" class="video-url" data-url="<?php echo e(handleVideoUrl($row->video_url)); ?>">
                                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="22" cy="22" r="22" fill="#0070C1"/>
                                                <path d="M19.2004 15.0001C19.2004 14.2301 18.5704 13.6001 17.8004 13.6001H10.8004C10.0304 13.6001 9.40039 14.2301 9.40039 15.0001C9.40039 15.7981 10.0864 16.4001 10.8004 16.4001H17.8004C18.5704 16.4001 19.2004 15.7701 19.2004 15.0001ZM27.6004 22.0001L33.2004 16.4001V30.4001L27.6004 24.8001V22.0001ZM26.2004 27.6001V19.2001C26.2004 18.4301 25.5704 17.8001 24.8004 17.8001H13.6004C12.8304 17.8001 12.2004 18.4301 12.2004 19.2001V27.6001C12.2004 28.3701 12.8304 29.0001 13.6004 29.0001H24.8004C25.5704 29.0001 26.2004 28.3701 26.2004 27.6001Z" fill="white"/>
                                            </svg>

                                        </a>
                                        <a href="#" data-toggle="collapse" data-target="#extra-<?php echo e($row->id); ?>">
                                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="22" cy="22" r="22" fill="#0070C1"/>
                                                <path d="M24.9889 18.6312L19.6969 19.2945L19.5079 20.173L20.5492 20.362C21.2264 20.5247 21.3612 20.768 21.2142 21.4453L19.5079 29.455C19.0617 31.5252 19.7529 32.5 21.3752 32.5C22.6352 32.5 24.0947 31.919 24.7579 31.1193L24.9609 30.1585C24.5007 30.5645 23.8234 30.7273 23.3772 30.7273C22.7419 30.7273 22.5127 30.281 22.6737 29.4953L24.9889 18.6312ZM25.1482 13.81C25.1482 14.4226 24.9048 15.0102 24.4716 15.4434C24.0384 15.8766 23.4508 16.12 22.8382 16.12C22.2255 16.12 21.6379 15.8766 21.2047 15.4434C20.7715 15.0102 20.5282 14.4226 20.5282 13.81C20.5282 13.1973 20.7715 12.6098 21.2047 12.1766C21.6379 11.7434 22.2255 11.5 22.8382 11.5C23.4508 11.5 24.0384 11.7434 24.4716 12.1766C24.9048 12.6098 25.1482 13.1973 25.1482 13.81Z" fill="white"/>
                                            </svg>
                                        </a>
                                    </div>-->
<!--                                    <div class="flx-grow-1 d-flex justify-content-end align-items-end">
                                        <div class="mr-3">
                                            <div><?php echo e(__("from")); ?></div>
                                            <div class="text-price text-blue-800 text-14 font-500"><?php echo e($row->price); ?></div>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary" data-toggle="collapse" data-target="#extra-price-<?php echo e($row->id); ?>">
                                                <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.6123 1.50977L6.78086 6.67832L1.6123 11.8469" stroke="white" stroke-width="2.00999" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="collapse" id="extra-<?php echo e($row->id); ?>">
                                    <?php if(!empty($row->exclude)): ?>
                                    <?php $__currentLoopData = $row->include; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-2 d-flex align-items-center">
                                            <svg class="mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.8128 3.71094H16.4476C16.2562 3.71094 16.0745 3.79883 15.9573 3.94922L7.90461 14.1504L4.04328 9.25781C3.98487 9.18365 3.91042 9.12368 3.82551 9.08241C3.74061 9.04114 3.64745 9.01965 3.55305 9.01953H2.18782C2.05696 9.01953 1.98469 9.16992 2.06477 9.27148L7.41438 16.0488C7.66438 16.3652 8.14485 16.3652 8.3968 16.0488L17.9359 3.96094C18.0159 3.86133 17.9437 3.71094 17.8128 3.71094Z" fill="#00B050"/>
                                            </svg>
                                            <?php echo e($item['title'] ?? ''); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if(!empty($row->exclude)): ?>
                                    <?php $__currentLoopData = $row->exclude; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div  class="mb-2 d-flex align-items-center">
                                            <svg class="mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.8128 3.71094H16.4476C16.2562 3.71094 16.0745 3.79883 15.9573 3.94922L7.90461 14.1504L4.04328 9.25781C3.98487 9.18365 3.91042 9.12368 3.82551 9.08241C3.74061 9.04114 3.64745 9.01965 3.55305 9.01953H2.18782C2.05696 9.01953 1.98469 9.16992 2.06477 9.27148L7.41438 16.0488C7.66438 16.3652 8.14485 16.3652 8.3968 16.0488L17.9359 3.96094C18.0159 3.86133 17.9437 3.71094 17.8128 3.71094Z" fill="#DE3E3E"/>
                                            </svg>
                                            <?php echo e($item['title'] ?? ''); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="collapse" id="extra-price-<?php echo e($row->id); ?>">
                                <?php if(is_array($row->dropdown) || is_object($row->dropdown)): ?>
                                    <?php $__currentLoopData = $row->dropdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dropdown): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $drop = \Themes\Jamrock\Booking\Models\Dropdown::find($dropdown);
                                        $options = \Themes\Jamrock\Booking\Models\Options::where('dropdown_id', $dropdown)->get();
                                        ?>
                                        <div class="form-group">
                                            <select name="option[]" class="form-control option_list bg-gray" required>
                                                <option class="text-10" value=""><?php echo e($drop->title); ?></option>
                                                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option class="text-10" value="<?php echo e($option->id); ?>"><?php echo e($option->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                                <div class="d-flex mb-2 justify-content-between align-items-center">
                                    <div>
                                        <a href="javascript:;" class="e-minus cursor-pointer">
                                            <i class="fa fa-minus-circle text-danger text-20"></i>
                                        </a>
<!--                                        <svg class="e-minus cursor-pointer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="25" cy="25" r="25" fill="#979797"/>
                                            <rect x="34" y="24" width="2" height="18" transform="rotate(90 34 24)" fill="white"/>
                                        </svg>-->

                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        Total:
                                        <span class="e-price ml-1" data-base="<?php echo e($row->price); ?>">
                                            0
                                        </span>
                                        <input name="extra[<?php echo e($row->id); ?>]" class="ml-2 e-number text-center border-radius-3 border" style="max-width: 50px;font-size: 15px" readonly value="0"/>
                                    </div>
                                    <div>
                                        <a href="javascript:;" class="e-plus cursor-pointer">
                                            <i class="fa fa-plus-circle text-primary text-20"></i>
                                        </a>
<!--                                        <svg class="e-plus cursor-pointer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="25" cy="25" r="25" fill="#00B050"/>
                                            <rect x="24" y="16" width="2" height="18" fill="white"/>
                                            <rect x="34" y="24" width="2" height="18" transform="rotate(90 34 24)" fill="white"/>
                                        </svg>-->
                                    </div>
                                </div>

                                    <div class="mt-2 store_extra d-flex align-items-start justify-content-center">
                                        <button type="button" class="btn btn-default bg-gray py-1" onclick="$('#extra-price-'+<?php echo e($row->id); ?>).toggleClass('show')">Cancel</button>
                                        <button type="button" class="btn btn-primary py-1 ml-auto save_extra" data-extra="<?php echo e($row->id); ?>">Confirm</button>
                                    </div>

<!--                                <div class="text-center font-weight-bold">
                                    Price: <span class="e-price" data-base="<?php echo e($row->price); ?>">
                                            0
                                        </span>
                                </div>-->
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo e($service->getDetailUrl()); ?>" class="btn btn-secondary" style="min-width: 105px">Back</a>
                <a href="<?php echo e(url('booking')); ?>/<?php echo e($booking->code); ?>/checkout" style="min-width: 105px" type="button" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </form>
    <div class="modal" id="video_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item bravo_embed_video" src="" allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        $('.video-url').click(function (e){
            e.preventDefault();
            $('#video_modal iframe').attr('src',$(this).data('url'));
            $('#video_modal').modal('show');
        });


        $('.option_list').on('change', function (){
            var items = []
            var parent = $(this).closest('.extra-item');
            $(parent).find('select[name="option[]"]').each(function(){
                var option = parseInt($(this).val());
                if(option){
                    items.push(option);
                }
            });

            $.ajax({
                url: '<?php echo e(url('get-combination')); ?>',
                data: {
                    items: items,
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                context:this,
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    var parent = $(this).closest('.extra-item');
                    parent.find('.e-price').attr('data-base', res);
                }
            })
        })


        $('.e-minus').click(function (){
            var parent = $(this).closest('.extra-item');
            var num = parseInt(parent.find('.e-number').val());
            if(num > 0){
                parent.find('.e-number').val(num - 1)
            }
            calculatePrice(parent);
        })
        $('.e-plus').click(function (){
            var parent = $(this).closest('.extra-item');
            var num = parseInt(parent.find('.e-number').val());
            parent.find('.e-number').val(num + 1)
            calculatePrice(parent);
        })

        function calculatePrice(parent){
            var num = parseInt(parent.find('.e-number').val());
            var price = parseFloat(parent.find('.e-price').data('base'));

            parent.find('.e-price').html(bravo_format_money(price * num));
        }


        $('.save_extra').on('click', function (){
            var id = $(this).attr('data-extra');
            var extra_id = id;
            var booking_id = '<?php echo e($booking->code); ?>';
            var number = $('input[name="extra['+id+']"]').val()

            if(number < 1){
                alert('Please at least select quantity 1');
                return false;
            }

            var items = []
            var parent = $(this).closest('.extra-item');
            $(parent).find('select[name="option[]"]').each(function(){
                var option = parseInt($(this).val());
                if(option){
                    items.push(option);
                }
            });
            $.ajax({
                url: '<?php echo e(url('save_extra')); ?>',
                data: {
                    extra_id: extra_id,
                    booking_id: booking_id,
                    number: number,
                    items: items,
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                context:this,
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    alert('Extra successfully added')
                    $(parent).find('.btn-primary.rounded').html('Added');
                    $('#extra-price-'+id).toggleClass('show');

                    $(parent).find('select[name="option[]"]').each(function(){
                        $(this).val('')
                    });

                    $(parent).find('input').each(function(){
                        $(this).val('0')
                    });
                }
            })
        })



    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Booking/Views/frontend/extra.blade.php ENDPATH**/ ?>