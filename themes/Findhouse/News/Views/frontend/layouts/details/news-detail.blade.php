<div class="mbp_thumb_post">
    @php $category = $row->getCategory; @endphp
    @if(!empty($category))
        <div class="blog_sp_tag">
            @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
            <a href="{{$category->getDetailUrl(app()->getLocale())}}">{{$t->name ?? ''}}</a>
        </div>
    @endif
    <h3 class="blog_sp_title">{{$translation->title}}</h3>
    <ul class="blog_sp_post_meta">
        @if(!empty($row->getAuthor))
            <li class="list-inline-item">
                @if($avatar_url = $row->getAuthor->getAvatarUrl())
                    <a href="#"><img src="{{$avatar_url}}" alt="{{ $row->getAuthor->getDisplayName() }}"></a>
                @endif
            </li>
            <li class="list-inline-item"><a href="#">{{$row->getAuthor->getDisplayName() ?? ''}}</a></li>
        @endif
            <li class="list-inline-item"><span class="flaticon-calendar"></span></li>
            <li class="list-inline-item"><a href="#">{{ display_date($row->updated_at)}}</a></li>
            <li class="list-inline-item"><span class="flaticon-view"></span></li>
            <li class="list-inline-item"><a href="#"> {{ $row->view }} {{__('views')}}</a></li>
    </ul>
    <div class="thumb">
        @if($image_url = get_file_url($row->image_id, 'full'))
            <img class="img-fluid" src="{{ $image_url  }}" alt="{{$translation->title}}">
        @endif
    </div>
    <div class="details">
        {!! $translation->content !!}
    </div>
    <ul class="blog_post_share">
        <li><p>{{__("Share")}}</p></li>
        <li><a target="_blank" original-title="{{__("Facebook")}}" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"><i class="fa fa-facebook"></i></a></li>
        <li><a target="_blank" original-title="{{__("Twitter")}}" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"><i class="fa fa-twitter"></i></a></li>
    </ul>
</div>
 
