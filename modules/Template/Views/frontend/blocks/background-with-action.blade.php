<div class=" bravo-form-search-all" style="background-image: linear-gradient(0deg,rgba(0, 0, 0, 0.2),rgba(0, 0, 0, 0.2)),url('{{$bg_image}}') !important">
    <div class="container" style="height: 300px;">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-heading text-center">{{$title}}</h1>
                <br>
                <div class="text-center bg_template_action">
                    <div class="text-left d-inline-block">
                        <p>{{$sub_title}}</p>
                        @foreach($list_slider as $item)
                            <a href="{{$item['link']}}">
                                <i class="{{$item['icon']}}"></i>
                                {{ $item['title'] ?? "" }}
                                <i class="icofont-rounded-right"></i>
                            </a>
                        @endforeach
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
