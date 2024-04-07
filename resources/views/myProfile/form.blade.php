<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama Lengkap" name="name" placeholder="Nama Lengkap..."
                        value="{{ isset($row) ? $row->name ?? '' : '' }}" />

                    <x-form-input-horizontal label="Username" name="username" placeholder="Username..."
                        value="{{ isset($row) ? $row->username ?? '' : '' }}" />

                    <x-form-input-horizontal label="No. HP" name="nohp_profile" placeholder="No. Handphone..."
                        value="{{ isset($row) ? $row->profile->nohp_profile ?? '' : '' }}" />

                    <x-form-textarea-horizontal label="Alamat" name="alamat_profile" placeholder="Alamat..."
                        value="{{ isset($row) ? $row->profile->alamat_profile ?? '' : '' }}" />

                    <x-form-radio-horizontal label="Jenis Kelamin" name="jeniskelamin_profile"
                        value="{{ isset($row) ? ($row->profile->jeniskelamin_profile === 'Laki-laki' ? 'L' : 'P' ?? '') : '' }}" />

                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Email" name="email" placeholder="Email..."
                        value="{{ isset($row) ? $row->email ?? '' : '' }}" />

                    <input type="hidden" name="password_old" value="{{ isset($row) ? $row->password ?? '' : '' }}">

                    <x-form-input-horizontal label="Password" name="password" placeholder="Password..." value=""
                        type="password" />

                    <x-form-input-horizontal label="Password Confirmation" name="password_confirmation"
                        placeholder="Password Confirmation..." value="" type="password" />

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row justify-content-end">
                <div class="col-sm-12">
                    <x-button-cancel-modal />
                    <x-button-submit-modal />
                </div>
            </div>
        </div>
    </form>

</div>


<script src="{{ asset('js/myProfile/form.js') }}"></script>
