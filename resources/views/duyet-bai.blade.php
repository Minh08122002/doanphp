@extends('main')
@section('content')
<section class="content">
@include('sweetalert::alert')
<div class="row">
        
<div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  
                    <div class="post">
                    @foreach($listTin as $Tin )
                      <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="{{asset('image/'. $Tin->file)}}" alt="">
        
                      <span class="username">
                      <a href="{{route('duyetbai_duyet',['id'=>$Tin->id])}}" class="btn btn-sm btn-primary float-right">
                      <i class="fab fa-angellist"></i> Duyệt
                    </a>
                    
                    <form action="{{route('listpost_xoa',['id'=>$Tin->id])}}" method="get">
                  <button class="btn btn-danger btn-sm float-right xoa " type="submit">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
                    
                </a>
    
                        </span>
                        <span class="description">{{ $Tin->thoi_gian }}</span>
                      </div>
                      <div><b>{{ $Tin->tieu_de }}</b></div>
                      <div>Số Điện Thoại:{{ $Tin->lien_lac }}</div>
                      <p>
                      {{ $Tin->noi_dung }}
                      </p>
                      <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('image/timdo/'. $Tin->file)}}" alt="">
                        </div>
                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                        
                        </span>
                      </p>

                      <hr>
                    @endforeach
                    </div>
            

                    
                    
                  </div>
                  
                </div>
           
              </div>
        </div></section>
    @endsection