<div class="card w-75 mx-auto">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <strong>
                <i class="fa-solid fa-user-pen fa-2x me-2 text-primary"></i> Edit Profile
            </strong>
            <a href="#" class="btn btn-primary btn-edit"
                data-urlcreate="{{ url('myProfile/' . $myProfile->id . '/edit') }}" data-typemodal="extraLargeModal">
                <i class="fa-solid fa-pencil me-2"></i> Edit Biodata
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <x-data-horizontal label="Nama" value="{{ $myProfile->profile->nama_profile }}" />
        </div>
        <div class="mb-2">
            <x-data-horizontal label="No. Handphone" value="{{ $myProfile->profile->nohp_profile }}" />
        </div>
        <div class="mb-2">
            <x-data-horizontal label="Alamat" value="{{ $myProfile->profile->alamat_profile }}" />
        </div>
        <div class="mb-2">
            <x-data-horizontal label="Jenis Kelamin" value="{{ $myProfile->profile->jeniskelamin_profile }}" />
        </div>
    </div>
</div>
