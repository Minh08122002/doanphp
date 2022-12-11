@extends('main')
@section('content')
<section class="content">
@include('sweetalert::alert')

<div class="row">
        
<div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                 
                    <div class="post">
                    @foreach($dsTin as $Tin )
                   
                      <div class="user-block">
                       <img class="img-circle img-bordered-sm" src="{{asset('image/'. $Tin->file)}}" alt=""> 
        
                      <span class="username">
                          <a href="#">{{ $Tin->user_name }}</a>
                          <a class="btn btn-danger btn-sm float-right " href="{{route('listpost_xoa',['id'=>$Tin->id])}}"
                onclick="removeRow(' . $Tin->id . ')">
                    <i class="fas fa-trash"></i>
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