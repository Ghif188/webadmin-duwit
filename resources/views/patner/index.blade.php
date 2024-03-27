@extends('layout.base')

@section('title', 'List Patner')

@section('css')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Patner /</span> Daftar Patner</h4>

<!-- Bootstrap Table with Header - Footer -->
<div class="card">
     <h5 class="card-header">Tabel Patner</h5>
     <div class="container">
          <div class="col m-2 ">
               <div class="table-responsive">
                   <table class="table display responsive nowrap" id="patner-table">
                       <thead>
                           <tr>
                               <th>Logo</th>
                               <th>Kode Patner</th>
                               <th>Nama</th>
                               <th>Telepon</th>
                               <th>Email</th>
                               <th>Status</th>
                               <th>Lokasi</th>
                               <th>Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                          @forelse ($patners as $patner)
                          <tr>
                               <td>
                                   <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                                       <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                           class="avatar avatar-md pull-up" title="{{ $patner->name }}">
                                           <img src="{{ $patner->picture }}" alt="Avatar" class="rounded-circle" />
                                       </li>
                                   </ul>
                               </td>
                               <td>{{ $patner->patner_code }}</td>
                               <td><strong>{{ $patner->name }}</strong></td>
                               <td>{{ $patner->phone }}</td>
                               <td>{{ $patner->email }}</td>
                               @if($patner->status == 'active')
                                   <td><span class="badge bg-label-primary me-1"> Aktif </span></td>
                               @else
                                   <td><span class="badge bg-label-danger me-1"> Blokir </span></td>
                               @endif
                               <td>{{ $patner->city }} , {{ $patner->province }}</td>
                              <td>
                                  <div class="dropdown">
                                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                          data-bs-toggle="dropdown">
                                          <i class="bx bx-dots-vertical-rounded"></i>
                                      </button>
                                      <div class="dropdown-menu">
                                          <a class="dropdown-item" href="{{ route('patner.detail', [ 'id' => $patner->id ]) }}">
                                            <i class='bx bx-check-circle'></i> Detail</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          @empty
                               
                          @endforelse
                       </tbody>
                   </table>
               </div>
          </div>
     </div>
</div>
<!-- Bootstrap Table with Header - Footer -->

<hr class="my-5" />
@endsection


@section('js_page')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
     $(function() {
          $("#patner-table").DataTable({
               responsive: true,
               paging: true,
               // "lengthChange": true,
               searching: true,
               ordering: true,
               autoWidth: false,
          });
     })
    </script>
@endsection
