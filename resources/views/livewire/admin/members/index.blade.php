<div>
    @push('styles')
    <link href="{{ asset('vendor/datatables/datatables.min.css')}}" rel="stylesheet">
    @endpush
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <x-admin.title pre_title='Daftar' page_title='Member' />

    <div class="row">
    <div class="col-lg-12">
        <table class="table table-hover table-striped table-bordered" id="dataTables-example" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>WA</th>
                    <th>Alamat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @foreach($members as $member)
                    <td>{{ $loop->index + $members->firstItem() }}</td>
                    <td>{{ $member->data->nama_lengkap }}</td>
                    <td>{{ $member->data->no_hp }}</td>
                    <td>{{ $member->data->alamat }}</td>
                        <td width="20">
                            <x-button.group>
                                <x-button.btn class="btn btn-md btn-warning" icon="fa-pencil"></x-button.btn>
                            </x-button.group>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    @push('scripts')


    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/datatables.min.js')}}"></script>
    <script src="{{ asset('js/initiate-datatables.js')}}"></script>


    @endpush
</div>
