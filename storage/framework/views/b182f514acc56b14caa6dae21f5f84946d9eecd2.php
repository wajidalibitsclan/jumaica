<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('extra.admin.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar"><?php echo e($row->id ? __('Edit: ').$row->title : __('Add extra')); ?></h1>
                </div>
            </div>
            <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if($row->id): ?>
                <?php echo $__env->make('Language::admin.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-body">
                                <?php echo $__env->make('Booking::admin.extra.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-title"><strong><?php echo e(__('Publish')); ?></strong></div>
                            <div class="panel-body">
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> <?php echo e(__('Save Changes')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script.body'); ?>
    <script>
        $(".form-group-item .btn-add-item").click(function () {
            $('.g-items .new-has-ckeditor').each(function(e){
                var id = $(this).attr('id');
                if(tinymce.get('#'+id)){}else{
                    setTimeout(function () {
                        init(id)
                    },300)
                }

            })
        })

        function init(id) {
            console.log(id)
            tinymce.init({
                selector:'#'+id,
                plugins: 'preview searchreplace autolink code fullscreen image link media codesample table charmap hr toc advlist lists wordcount imagetools textpattern help pagebreak hr paste',
                toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | pagebreak codesample code| removeformat',
                image_advtab: true,
                image_caption: true,
                toolbar_drawer: 'sliding',
                relative_urls : false,
                paste_webkit_styles: 'none',
                paste_retain_style_properties: 'none',
                // height:h,
                file_picker_callback: function (callback, value, meta) {
                    /* Provide file and text for the link dialog */
                    if (meta.filetype === 'file') {
                        uploaderModal.show({
                            multiple:false,
                            file_type:'video',
                            onSelect:function (files) {
                                if(files.length)
                                    callback(bookingCore.url+'/media/preview/'+files[0].id);
                            },
                        });
                    }

                    /* Provide image and alt text for the image dialog */
                    if (meta.filetype === 'image') {
                        uploaderModal.show({
                            multiple:false,
                            file_type:'image',
                            onSelect:function (files) {
                                if(files.length)
                                    callback(files[0].thumb_size);
                            },
                        });
                    }

                    /* Provide alternative source and posted for the media dialog */
                    if (meta.filetype === 'media') {
                        uploaderModal.show({
                            multiple:false,
                            file_type:'video',
                            onSelect:function (files) {
                                if(files.length)
                                    callback(bookingCore.url+'/media/preview/'+files[0].id);
                            },
                        });
                    }
                },
            });

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/admin/extra/detail.blade.php ENDPATH**/ ?>