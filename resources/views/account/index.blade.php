@extends('layout.base')

@section('title', 'List Akun')

@section('css')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Akun Pengguna /</span> Daftar Akun</h4>

<!-- Bootstrap Table with Header - Footer -->
<div class="card">
     <h5 class="card-header">Tabel Akun Pengguna</h5>
     <div class="container">
          <div class="col m-2 ">
               <div class="table-responsive">
                   <table class="table display responsive nowrap" id="patner-table">
                       <thead>
                           <tr>
                               <th>Profil</th>
                               <th>Kode Akun</th>
                               <th>Nama Pengguna</th>
                               <th>Nomor Hp</th>
                               <th>Email</th>
                               <th>Status</th>
                               <th>Peran</th>
                               <th>Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                          @forelse ($accounts as $account)
                          <tr>
                               <td>
                                   <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                                       <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                           class="avatar avatar-md pull-up" title="{{ $account->fullname }}">
                                           <img src="{{ $account->avatar }}" alt="Avatar" class="rounded-circle" />
                                       </li>
                                   </ul>
                               </td>
                               <td>{{ $account->account_code }}</td>
                               <td><strong>{{ $account->fullname }}</strong></td>
                               <td>+{{ $account->phone }}</td>
                               <td>{{ $account->email }}</td>
                               @if($account->status == 'active')
                                   <td><span class="badge bg-label-primary me-1"> Aktif </span></td>
                               @else
                                   <td><span class="badge bg-label-danger me-1"> Blokir </span></td>
                               @endif
                               <td><span class="badge bg-label-secondary me-1"> {{ $account->role }} </span></td>
                              <td>
                                  <div class="dropdown">
                                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                          data-bs-toggle="dropdown">
                                          <i class="bx bx-dots-vertical-rounded"></i>
                                      </button>
                                      <div class="dropdown-menu">
                                          <a class="dropdown-item" href="{{ route('account.detail', [ 'id' => $account->id ]) }}">
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
