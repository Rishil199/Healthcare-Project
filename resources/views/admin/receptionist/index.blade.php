@use ('App\Models\User')
@extends('layouts.app')
@push('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="{{ asset('assets/js/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content-breadcrumb')
<li>
   <span>
      <svg class="me-2" width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 384 384" style="enable-background:new 0 0 384 384;" xml:space="preserve">
         <g>
            <path d="M0.7,355.8c2.4-3.7,4.2-7.9,7.2-11.1c3.4-3.7,8.4-4.6,13.5-4.5c1.5,0,3,0,4.9,0c0-1.6,0-3,0-4.3
               c0.2-12.7-0.7-25.6,0.7-38.2c4.5-40.3,26.1-68.1,63.1-84.2c0.8-0.3,1.6-0.6,2.4-0.9c0.2-0.1,0.3-0.3,0.6-0.6
               c-2.3-0.9-4.6-1.5-6.7-2.5c-15.1-7.2-23.7-19.2-24.1-35.9c-0.5-25.4-0.6-50.8,0-76.1c1.2-49.2,40.3-90.7,89.2-95.7
               C204.6-3.8,253.1,35.3,258.8,88c0.7,6.9,0.7,14,0.8,21c0.1,20.4,0,40.7,0,61.1c0,20.8-10,34.6-29.7,41.4c-0.4,0.2-0.9,0.4-1.4,0.6
               c36.8,18,45.9,27.2,60.9,61c3.9-1,7.8-2,12.2-3.1c0-2-0.1-4.3,0-6.5c0.2-3.8,2.9-6.5,6.4-6.5c3.5,0,6.1,2.7,6.3,6.6
               c0.1,2.1,0,4.2,0,6.2c4.4,1.3,8.8,2.1,12.7,3.8c17.5,7.5,28,20.7,31.5,39.5c0.2,1.2,1.2,2.8,2.3,3.3c7.8,4.1,11.4,10.6,11.1,19.3
               c-0.1,3.6,0.3,6.1,4.1,7.9c4.9,2.3,6.8,7.3,8.7,12.1c0,4.5,0,9,0,13.5c-2.3,8.2-7.6,13.4-15.8,15.8c-117.5,0-235,0-352.5,0
               c-8.2-2.3-13.4-7.6-15.8-15.8C0.8,364.8,0.8,360.3,0.7,355.8z M215.7,264.4c0.9,1,1.6,1.7,2.2,2.5c4.9,6.1,4.1,14.4-2.3,18.8
               c-16.8,11.4-33.8,22.6-50.8,33.9c-2.7,1.8-5.4,1.9-8,0.1c-17-11.4-34.2-22.6-51.1-34.2c-6.5-4.4-7.1-12.8-2-18.8
               c0.6-0.7,1.3-1.4,2.1-2.3c-1.6-1.1-3-2.1-4.5-3.1c-9.8-6.6-11.1-12.2-5.1-22.3c3.4-5.7,6.8-11.5,10.3-17.2
               c-4.1,0.7-7.7,1.9-11.2,3.4c-30.3,12.7-49.3,35.1-54.5,67.5c-2.3,14.4-1.2,29.4-1.6,44.1c0,1,0.1,1.9,0.2,3c68.2,0,136.2,0,204.2,0
               c0.2-0.5,0.3-0.7,0.3-0.9c0-0.9,0.1-1.7,0.1-2.6c-0.3-9.1,3.2-16,11.6-20.1c0.9-0.4,1.6-1.8,1.8-2.8c2.2-12.8,8.1-23.5,18.2-31.8
               c1.8-1.5,2.2-2.7,1.4-5c-7.5-20.5-20.6-36.1-39.8-46.4c-6.8-3.7-14.3-6.2-21.4-9.2c-0.2,0.3-0.4,0.6-0.6,0.9
               c0.6,1.1,1.1,2.1,1.7,3.2c3.3,5.6,6.7,11.1,10,16.7c3.8,6.6,2.2,13.4-4,17.8C220.6,261.2,218.2,262.7,215.7,264.4z M192.5,190
               c0.8,1.5,1.5,3,2.3,4.4c2.2,4,5.1,6.4,10.2,5.8c4.2-0.5,8.5-0.1,12.7-0.1c17.6-0.1,29-11.6,29.1-29.2c0-23.4,0.1-46.7,0-70.1
               c0-4.7-0.2-9.5-1-14.2c-8.5-51.7-58.2-80.8-102.8-70.6c-35,7.9-65,40-67,75.6c-1.5,27.4-1,55-0.7,82.4c0.2,14.4,12,25.4,26.5,25.9
               c6,0.2,12,0.1,18,0.1c1,0,2.5-0.3,3-1c2.4-2.9,4.5-6,6.7-9c-14.9-13.3-17-16.6-23-34.8c-0.9-2.8-1.7-5.7-3-8.5
               c-0.5-1.1-1.7-2.4-2.9-2.8c-11.3-3.9-18.4-12.8-18.8-23.6c-0.4-11.5,5.9-20.8,17.1-25.6c1-0.4,2.1-2,2.2-3.1
               c0.3-3.6,0.1-7.2,0.1-10.9c0-3.5,1.6-5.8,4.8-6.8c9.1-2.8,13.8-8.9,14.6-18.3c0.3-3.1,1.8-5.2,4.8-5.9c3.1-0.7,5.3,0.7,7.3,3.2
               c2.8,3.4,5.8,6.9,9.4,9.5c9.5,6.7,20.7,9,32.1,10.4c3.6,0.4,7.3,1,10.8,0.7c13.5-0.9,22.9,5.5,30.3,15.9c1.9,2.7,4,4.2,7.2,5.3
               c10.1,3.4,16.2,10.7,17.4,21.4c1.2,11.1-3,20.8-13.2,25.1c-7.3,3.1-9.6,7.9-11.3,14.3c-0.5,1.8-1.1,3.6-1.7,5.3
               c-3.4,10.8-9.7,19.6-18.5,26.7C194.3,188.4,193.5,189.1,192.5,190z M130.6,70.3c-3,3.2-5.2,7.6-8.7,9.2c-8.3,3.8-8.8,10.2-7.9,17.7
               c0,0.4,0,0.7,0,1.1c-0.1,5.2-1.9,7.2-7,7.8c-7.4,0.9-12.5,6.2-12.4,13c0,6.9,5.1,12.3,12.5,12.9c3.8,0.3,5.9,2.2,7,5.6
               c1.7,5.5,3.8,10.8,5.4,16.3c4.7,17.2,16.9,27.3,32.4,34c4,1.7,9.4,2.8,13.4,1.5c16.5-5.1,29.8-14.5,35.9-31.6
               c2.4-6.7,4.5-13.5,6.8-20.2c1.1-3.2,2.9-5.3,6.6-5.6c7.9-0.7,12.8-5.9,12.8-13c0-7.1-4.9-12.2-12.8-13c-2.9-0.3-4.8-1.6-6.2-4.1
               c-1-1.9-2.2-3.6-3.5-5.3c-4.9-6.8-11-10.3-19.9-10.4C165.3,86.2,146.5,82.5,130.6,70.3z M192.4,372.2c56.4,0,112.7,0,169.1,0
               c1.1,0,2.3,0,3.4,0c3.9-0.1,6.4-2.1,7-5.5c1.3-6.9-0.1-11.9-4.1-13.2c-1.8-0.6-3.9-0.6-5.9-0.6c-112.7,0-225.5,0-338.2,0
               c-1.4,0-2.9-0.3-4.1,0.2c-1.7,0.6-4.4,1.5-4.6,2.7c-0.7,4.2-1.3,8.6-0.5,12.7c0.8,3.9,5,3.8,8.4,3.8
               C79.4,372.2,135.9,372.2,192.4,372.2z M180.9,197.3c-14.2,7-23.3,8.3-40.5-0.1c-2.8,3.7-5.4,7.5-8.5,10.8c-1.8,1.9-1.9,3.2-1.1,5.5
               c9.5,26,18.9,52,28.4,78c0.4,1.1,0.9,2.2,1.4,3.4c0.3-0.2,0.4-0.3,0.5-0.4c10-27.5,20.1-55,30.1-82.6c0.3-0.8,0.1-2-0.4-2.6
               C187.6,205.4,184.3,201.5,180.9,197.3z M345.5,314.4c-3-18.5-19.6-32.2-38.2-31.7c-18.6,0.5-35,14.5-36.8,31.7
               C295.4,314.4,320.3,314.4,345.5,314.4z M256.7,339.8c34.5,0,68.4,0,102.2,0c1.1-10.5-0.8-12.5-10.9-12.5c-21.5,0-42.9,0-64.4,0
               c-6.5,0-13-0.1-19.5,0c-4.8,0.1-7.1,2.4-7.4,7.1C256.6,336.2,256.7,337.9,256.7,339.8z M105.4,248.7c4.7,3.1,8.9,5.9,13.2,8.8
               c4.7,3.2,5.1,7.2,1.2,11.2c-2.1,2.1-4.4,4-6.9,6.2c12,8,23.2,15.5,35.3,23.5c-9.3-25.5-18.2-50-27.4-75.3
               C115.4,232,110.5,240.2,105.4,248.7z M208.4,275.1c-2.4-2.3-4.4-4.2-6.3-6.2c-4.3-4.4-3.9-8.2,1.2-11.7c4.2-2.9,8.4-5.7,12.8-8.6
               c-5.1-8.5-10-16.7-15.3-25.5c-9.2,25.4-18.1,49.8-27.3,75.3C185.6,290.4,196.7,282.9,208.4,275.1z" fill="#545a6d"/>
            <path d="M77.8,314.5c-4.2,0-8.5,0.1-12.7,0c-4.1-0.1-6.7-2.7-6.7-6.4c0-3.6,2.6-6.2,6.5-6.3c8.5-0.1,16.9-0.1,25.4,0
               c3.8,0.1,6.4,3,6.4,6.4c-0.1,3.5-2.7,6.1-6.6,6.2C86.1,314.6,81.9,314.5,77.8,314.5z" fill="#545a6d"/>
         </g>
      </svg>
   </span>
   <span><a href="{{route('receptionists.index')}}" class="text-black text-decoration-none">
   {{$title}}
      </a>
   </span>
</li>
@endsection
@section('content-body')
<div class="container">
   <div class="row">
      <div class="col-12">
         <div class="title main-title title-btn">
            <div class="title-text">
               <strong>{{$title}} List</strong>
            </div>
            <div class="form-btns title-btn">
               <a href="javascript:void(0)" data-url="{{ route('receptionists.create') }}" class="btn-add-receptionists" data-bs-toggle="addmodal" data-bs-target="#myAddModal" id="btn-add-receptionists">
                  <button class="btn btn-back ripple-hover plus">
                     <span class="svg-icon me-2">
                        <svg fill="#fff" width="18" version="1.1" id="lni_lni-plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                           y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                           <path d="M61,30.3H33.8V3c0-1-0.8-1.8-1.8-1.8S30.3,2,30.3,3v27.3H3c-1,0-1.8,0.8-1.8,1.8S2,33.8,3,33.8h27.3V61c0,1,0.8,1.8,1.8,1.8
                              s1.8-0.8,1.8-1.8V33.8H61c1,0,1.8-0.8,1.8-1.8S62,30.3,61,30.3z" fill="#fff"/>
                        </svg>
                     </span>
                     <span class="svg-text">
                     Add Staff
                     </span>
                  </button>
                  </a>
                  <span data-href="{{ route('receptionists.exportCSV') }}" id="export" class="btn btn-back ms-3" onclick ="exportReceptionist (event.target);">Export</span>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="theme-block mt-4">
            <div class="table-responsive">
               <table class="table theme-table sr-table receptionists-table" id="receptionists-table" style="width: 100%" name="Staff">
                  <thead class="table-dark">
                     <th>Name</th>
                     @if (Auth::user()->hasRole(User::ROLE_SUPER_ADMIN))          
                     <th>Hospital Name</th>
                     @else 
                     <th>Email</th>
                     @endif 
                     <th>Phone No.</th>
                     <th>Status</th>
                     <th>Created At</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('footer_js')
<script src="{{ asset('assets/js/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript">
   let receptionists_url = "{{ route('receptionists.index') }}"  
   let receptionists_store_url = "{{ route('receptionists.store') }}"
   let delete_receptionists_url = "{{ route('receptionists.destroy')}}"  
   let changeStatus = "{{ route('receptionists.changeStatus')}}"
</script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/receptionist.js') }}"></script>
@endpush